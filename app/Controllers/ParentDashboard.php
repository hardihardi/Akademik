<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ParentDashboard extends BaseController
{
    protected $db;
    protected $studentModel;
    protected $attendanceModel;
    protected $gradesModel;
    protected $announcementModel;
    protected $assignmentModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->studentModel = new \App\Models\StudentModel();
        $this->attendanceModel = new \App\Models\AttendanceModel();
        $this->gradesModel = new \App\Models\GradesModel();
        $this->announcementModel = new \App\Models\AnnouncementModel();
        $this->assignmentModel = new \App\Models\AssignmentModel();
    }

    private function getStudent()
    {
        return $this->db->table('students')
                        ->select('students.*, classes.id as class_id, classes.name as class_name')
                        ->join('classes', 'classes.id = students.class_id', 'left')
                        ->where('students.user_id', session()->get('id'))
                        ->get()->getRowArray();
    }

    public function permission()
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $data = [
            'title' => 'Ajukan Izin/Sakit - ' . $student['full_name'],
            'student' => $student,
        ];

        return view('parent/attendance/permission', $data);
    }

    public function submit_permission()
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $rules = [
            'date' => 'required',
            'status' => 'required|in_list[I,S]',
            'note' => 'required|min_length[5]',
            'evidence' => 'uploaded[evidence]|max_size[evidence,5120]|ext_in[evidence,jpg,jpeg,png,pdf]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Input tidak valid. Pastikan file berupa Gambar/PDF maksimal 5MB.');
        }

        $file = $this->request->getFile('evidence');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            
            // Ensure directory exists
            if (!is_dir(FCPATH . 'uploads/attendance')) {
                mkdir(FCPATH . 'uploads/attendance', 0777, true);
            }

            $file->move(FCPATH . 'uploads/attendance', $newName);

            $date = $this->request->getPost('date');
            
            // Get active year
            $ayModel = new \App\Models\AcademicYearModel();
            $activeYear = $ayModel->getActiveYear();

            // Check if attendance record already exists for this date
            $existing = $this->attendanceModel->where('student_id', $student['id'])
                                              ->where('date', $date)
                                              ->first();

            $attendanceData = [
                'student_id' => $student['id'],
                'class_id' => $student['class_id'],
                'date' => $date,
                'status' => $this->request->getPost('status'),
                'note' => $this->request->getPost('note'),
                'academic_year_id' => $activeYear['id'] ?? null,
                'evidence_path' => $newName,
                'is_verified' => 0 // Needs manual verification by teacher/admin
            ];

            if ($existing) {
                // Delete old evidence if exists
                if ($existing['evidence_path'] && file_exists(FCPATH . 'uploads/attendance/' . $existing['evidence_path'])) {
                    unlink(FCPATH . 'uploads/attendance/' . $existing['evidence_path']);
                }
                $this->attendanceModel->update($existing['id'], $attendanceData);
            } else {
                $this->attendanceModel->insert($attendanceData);
            }

            return redirect()->to('parent/attendance')->with('message', 'Pengajuan izin berhasil dikirim dan menunggu verifikasi.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mengunggah bukti.');
    }

    public function attendance()
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Resolve academic year from the student's class
        $ayModel = new \App\Models\AcademicYearModel();
        $classData = $this->db->table('classes')->select('academic_year_id')->where('id', $student['class_id'])->get()->getRowArray();
        $academicYearId = $classData['academic_year_id'] ?? null;
        $displayYear = $academicYearId ? $ayModel->find($academicYearId) : $ayModel->getActiveYear();
        $ayId = $displayYear['id'] ?? 0;

        $stats = $this->attendanceModel->where('student_id', $student['id'])->where('academic_year_id', $ayId)->select('status, COUNT(*) as count')->groupBy('status')->findAll();
        $summary = ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0, 'total' => 0];
        foreach ($stats as $s) {
            $summary[$s['status']] = (int)$s['count'];
            $summary['total'] += (int)$s['count'];
        }

        $data = [
            'title' => 'Detail Kehadiran - ' . $student['full_name'],
            'student' => $student,
            'attendance' => $this->attendanceModel->where('student_id', $student['id'])->where('academic_year_id', $ayId)->orderBy('date', 'DESC')->paginate(10, 'attendance'),
            'pager' => $this->attendanceModel->pager,
            'summary' => $summary,
            'activeYear' => $displayYear
        ];

        return view('parent/attendance', $data);
    }

    public function grades()
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Resolve academic year from the student's class
        $ayModel = new \App\Models\AcademicYearModel();
        $classData = $this->db->table('classes')->select('academic_year_id')->where('id', $student['class_id'])->get()->getRowArray();
        $academicYearId = $classData['academic_year_id'] ?? null;
        $displayYear = $academicYearId ? $ayModel->find($academicYearId) : $ayModel->getActiveYear();
        $ayId = $displayYear['id'] ?? 0;

        $data = [
            'title' => 'Detail Nilai - ' . $student['full_name'],
            'student' => $student,
            'grades' => $this->gradesModel->select('grades.*, subjects.name as subject_name')
                                          ->join('subjects', 'subjects.id = grades.subject_id')
                                          ->where('student_id', $student['id'])
                                          ->where('grades.academic_year_id', $ayId)
                                          ->orderBy('created_at', 'DESC')
                                          ->paginate(20, 'grades'),
            'pager' => $this->gradesModel->pager,
            'activeYear' => $displayYear
        ];

        return view('parent/grades', $data);
    }

    public function schedule()
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Normally we'd have a schedule table, but based on Home.php view, we'll mock it or find subjects
        $subjects = $this->db->table('subjects')->get()->getResultArray();

        $data = [
            'title' => 'Jadwal Pelajaran - ' . $student['full_name'],
            'student' => $student,
            'subjects' => $subjects
        ];

        return view('parent/schedule', $data);
    }

    public function announcements()
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        // School-wide announcements (all)
        $schoolAnnouncements = $this->announcementModel->where('target_role', 'all')
                                                       ->orderBy('created_at', 'DESC')
                                                       ->paginate(5, 'school');

        // Class-specific announcements
        $classAnnouncements = $this->announcementModel->where('class_id', $student['class_id'])
                                                      ->orderBy('created_at', 'DESC')
                                                      ->paginate(5, 'class');

        $data = [
            'title' => 'Pengumuman - ' . $student['full_name'],
            'student' => $student,
            'schoolAnnouncements' => $schoolAnnouncements,
            'classAnnouncements' => $classAnnouncements,
            'pager' => $this->announcementModel->pager
        ];

        return view('parent/announcements', $data);
    }

    public function view_announcement($id)
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $announcement = $this->announcementModel->find($id);

        if (!$announcement) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengumuman tidak ditemukan.');
        }

        // Security check: ensure announcement is for 'all' or specific class of student
        if ($announcement['target_role'] !== 'all' && $announcement['target_role'] !== 'ortu' && $announcement['class_id'] != $student['class_id']) {
             throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengumuman tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Pengumuman - ' . $announcement['title'],
            'student' => $student,
            'announcement' => $announcement
        ];

        return view('parent/announcements/view', $data);
    }

    public function assignments()
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $search = $this->request->getVar('search');
        $subjectId = $this->request->getVar('subject_id');
        $statusFilter = $this->request->getVar('status');

        $ayModel = new \App\Models\AcademicYearModel();
        $activeYear = $ayModel->getActiveYear();
        $ayId = $activeYear['id'] ?? 0;

        $query = $this->assignmentModel->select('assignments.*, subjects.name as subject_name, teachers.full_name as teacher_name, submissions.status as sub_status, submissions.grade')
                                             ->join('subjects', 'subjects.id = assignments.subject_id', 'left')
                                             ->join('teachers', 'teachers.id = assignments.teacher_id', 'left')
                                             ->join('submissions', 'submissions.assignment_id = assignments.id AND submissions.student_id = ' . $student['id'], 'left')
                                             ->where('assignments.class_id', $student['class_id']);

        if ($search) {
            $query->groupStart()
                  ->like('assignments.title', $search)
                  ->orLike('teachers.full_name', $search)
                  ->groupEnd();
        }

        if ($subjectId) {
            $query->where('assignments.subject_id', $subjectId);
        }

        if ($statusFilter) {
            $now = date('Y-m-d H:i:s');
            switch ($statusFilter) {
                case 'submitted':
                    $query->where('submissions.status', 'submitted');
                    break;
                case 'reviewed':
                    $query->where('submissions.status', 'reviewed');
                    break;
                case 'not_submitted':
                    $query->where('submissions.id', null)
                          ->where('assignments.deadline >', $now);
                    break;
                case 'late':
                    $query->where('submissions.id', null)
                          ->where('assignments.deadline <', $now);
                    break;
            }
        }

        $assignments = $query->orderBy('assignments.deadline', 'ASC')
                             ->paginate(9, 'assignments');

        // Fetch subjects for filter
        $subjects = $this->db->table('subjects')
                             ->select('subjects.*')
                             ->join('teacher_assignments', 'teacher_assignments.subject_id = subjects.id')
                             ->where('teacher_assignments.class_id', $student['class_id'])
                             ->groupBy('subjects.id')
                             ->get()->getResultArray();

        $data = [
            'title' => 'Tugas & Materi - ' . $student['full_name'],
            'student' => $student,
            'assignments' => $assignments,
            'pager' => $this->assignmentModel->pager,
            'subjects' => $subjects,
            'filters' => [
                'search' => $search,
                'subject_id' => $subjectId,
                'status' => $statusFilter
            ]
        ];

        return view('parent/assignments/index', $data);
    }

    public function view_assignment($id)
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $assignment = $this->db->table('assignments')
                                ->select('assignments.*, subjects.name as subject_name, teachers.full_name as teacher_name')
                                ->join('subjects', 'subjects.id = assignments.subject_id', 'left')
                                ->join('teachers', 'teachers.id = assignments.teacher_id', 'left')
                                ->where('assignments.id', $id)
                                ->where('assignments.class_id', $student['class_id'])
                                ->get()->getRowArray();

        if (!$assignment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tugas tidak ditemukan.');
        }

        $submission = $this->db->table('submissions')
                               ->where('assignment_id', $id)
                               ->where('student_id', $student['id'])
                               ->get()->getRowArray();

        $data = [
            'title' => 'Detail Tugas - ' . $assignment['title'],
            'student' => $student,
            'assignment' => $assignment,
            'submission' => $submission
        ];

        return view('parent/assignments/view', $data);
    }

    public function submit_assignment($id)
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $assignment = $this->db->table('assignments')->where('id', $id)->get()->getRowArray();
        if (!$assignment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tugas tidak ditemukan.');
        }

        // Check if deadline passed
        if (strtotime($assignment['deadline']) < time()) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Batas waktu pengumpulan telah berakhir.']);
            }
            return redirect()->back()->with('error', 'Batas waktu pengumpulan telah berakhir.');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'submission_file' => 'uploaded[submission_file]|max_size[submission_file,5120]|ext_in[submission_file,pdf,doc,docx,jpg,png,zip]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'File tidak valid. Maksimal 5MB dengan format PDF, DOC, JPG, PNG, atau ZIP.']);
            }
            return redirect()->back()->with('error', 'File tidak valid. Maksimal 5MB dengan format PDF, DOC, JPG, PNG, atau ZIP.');
        }

        $file = $this->request->getFile('submission_file');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            
            // Ensure directory exists
            if (!is_dir(FCPATH . 'uploads/submissions')) {
                mkdir(FCPATH . 'uploads/submissions', 0777, true);
            }

            $file->move(FCPATH . 'uploads/submissions', $newName);

            // Check if already submitted
            $existing = $this->db->table('submissions')
                                ->where('assignment_id', $id)
                                ->where('student_id', $student['id'])
                                ->get()->getRowArray();

            if ($existing) {
                // Delete old file
                if ($existing['file_path'] && file_exists(FCPATH . 'uploads/submissions/' . $existing['file_path'])) {
                    unlink(FCPATH . 'uploads/submissions/' . $existing['file_path']);
                }

                $this->db->table('submissions')->where('id', $existing['id'])->update([
                    'file_path'  => $newName,
                    'status'     => 'submitted',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $this->db->table('submissions')->insert([
                    'assignment_id' => $id,
                    'student_id'    => $student['id'],
                    'file_path'     => $newName,
                    'status'        => 'submitted',
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            }

            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Tugas berhasil dikirim!']);
            }
            return redirect()->back()->with('message', 'Tugas berhasil dikirim!');
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Terjadi kesalahan saat mengunggah file.']);
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggah file.');
    }

    public function reports()
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Fetch all academic years available to show in a grid
        $academicYears = $this->db->table('academic_years')
                                  ->orderBy('year', 'DESC')
                                  ->orderBy('semester', 'DESC')
                                  ->get()->getResultArray();

        $activeYear = $this->db->table('academic_years')->where('status', 'Active')->get()->getRowArray();

        $data = [
            'title' => 'Rapor Siswa - ' . $student['full_name'],
            'student' => $student,
            'academicYears' => $academicYears,
            'activeYear' => $activeYear
        ];

        return view('parent/reports', $data);
    }

    public function download_report($academicYearId)
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Logic adapted from Report.php -> downloadPdf
        $activeYear = $this->db->table('academic_years')->where('id', $academicYearId)->get()->getRowArray();
        if (!$activeYear) {
            return redirect()->back()->with('error', 'Tahun akademik tidak ditemukan.');
        }

        // Use the common Report controller's data gathering logic or a simplified version
        // Since we want to avoid duplicate logic, we'll implement a tailored version here or call a service if available.
        // For now, mirroring the essential logic from Report::getReportData
        
        $semester = $activeYear['semester'] == 'Ganjil' ? '1' : '2';
        $studentId = $student['id'];
        
        $class = $this->db->table('classes')->where('id', $student['class_id'])->get()->getRowArray();
        $subjects = $this->db->table('subjects')->get()->getResultArray();
        $school = school_branding();

        // Fetch Grades
        $gradesRaw = $this->db->table('grades')->where([
            'student_id' => $studentId,
            'semester' => $semester,
            'academic_year_id' => $activeYear['id']
        ])->get()->getResultArray();
        
        $grades = [];
        foreach ($gradesRaw as $getRow) {
            $grades[$getRow['subject_id']][$getRow['type']] = $getRow['score'];
        }

        $reportData = [];
        foreach ($subjects as $subject) {
            $tugas = $grades[$subject['id']]['Tugas'] ?? 0;
            $uts = $grades[$subject['id']]['UTS'] ?? 0;
            $uas = $grades[$subject['id']]['UAS'] ?? 0;

            $weights = get_assessment_weights();
            $finalScore = ($tugas * $weights['tugas']) + ($uts * $weights['uts']) + ($uas * $weights['uas']);
            
            $reportData[] = [
                'subject' => $subject['name'],
                'kkm' => $subject['kkm'] ?? 70,
                'score' => round($finalScore),
            ];
        }

        // Attendance Summary: Scoped to semester date range
        $yearParts = explode('/', $activeYear['year']); // e.g. "2025/2026"
        $yearStart = $yearParts[0] ?? date('Y');
        $yearEnd = $yearParts[1] ?? ($yearStart + 1);
        
        if ($semester == '1') {
            $semesterStart = $yearStart . '-07-01';
            $semesterEnd = $yearStart . '-12-31';
        } else {
            $semesterStart = $yearEnd . '-01-01';
            $semesterEnd = $yearEnd . '-06-30';
        }

        $attendanceQuery = $this->db->table('attendance')
                                    ->where('student_id', $studentId);
        
        $attendanceSummary = (clone $attendanceQuery)
                              ->where('academic_year_id', $activeYear['id'])
                              ->where('date >=', $semesterStart)
                              ->where('date <=', $semesterEnd)
                              ->get()->getResultArray();
        
        if (empty($attendanceSummary)) {
            $attendanceSummary = (clone $attendanceQuery)
                                  ->where('date >=', $semesterStart)
                                  ->where('date <=', $semesterEnd)
                                  ->get()->getResultArray();
        }
        
        if (empty($attendanceSummary)) {
            $attendanceSummary = $this->db->table('attendance')
                                    ->where('student_id', $studentId)
                                    ->where('academic_year_id', $activeYear['id'])
                                    ->get()->getResultArray();
        }
        
        $attendance = ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0];
        foreach($attendanceSummary as $att) {
           if(isset($attendance[$att['status']])) {
               $attendance[$att['status']]++;
           }
        }

        $reportCard = $this->db->table('report_cards')
                               ->where('student_id', $studentId)
                               ->where('academic_year_id', $activeYear['id'])
                               ->where('semester', $semester)
                               ->get()->getRowArray();
        // Fetch Homeroom Teacher Info
        $homeroomInfo = null;
        if ($class) {
            $homeroomAssignment = $this->db->table('homeroom_assignments')
                                           ->where('class_id', $class['id'])
                                           ->where('academic_year_id', $activeYear['id'])
                                           ->get()->getRowArray();
            if ($homeroomAssignment) {
                $homeroomInfo = $this->db->table('teachers')
                                        ->where('id', $homeroomAssignment['teacher_id'])
                                        ->get()->getRowArray();
            }
        }

        $data = [
            'student' => $student,
            'class' => $class,
            'reportData' => $reportData,
            'attendance' => $attendance,
            'semester' => $semester,
            'year' => $activeYear['year'],
            'date' => date('d F Y'),
            'school' => $school,
            'school_city' => $school['city'] ?? 'Ditetapkan',
            'reportCard' => $reportCard,
            'homeroom' => $homeroomInfo ? $homeroomInfo['full_name'] : (session()->get('username')),
            'homeroom_nip' => $homeroomInfo ? ($homeroomInfo['nip'] ?? '-') : '-'
        ];

        // Local path mapping for DomPDF
        if($data['school']['logo_raw'] && file_exists(FCPATH . $data['school']['logo_raw'])) {
            $data['school']['logo'] = FCPATH . $data['school']['logo_raw'];
        }
        if($data['school']['signature_raw'] && file_exists(FCPATH . $data['school']['signature_raw'])) {
            $data['school']['headmaster_signature'] = FCPATH . $data['school']['signature_raw'];
        }

        $dompdf = new \Dompdf\Dompdf([
            'isRemoteEnabled' => false,
            'chroot' => FCPATH,
            'isHtml5ParserEnabled' => true,
        ]);

        $html = view('academic/report/pdf_template', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Rapor_' . str_replace(' ', '_', $data['student']['full_name']) . '_' . str_replace(['/', '\\'], '_', $activeYear['year']) . '_S' . $semester . '.pdf';
        
        return $this->response->download($filename, $dompdf->output())->setContentType('application/pdf');
    }
}
