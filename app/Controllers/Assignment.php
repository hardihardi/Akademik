<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssignmentModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\TeacherAssignmentModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Assignment extends BaseController
{
    protected $assignmentModel;
    protected $classModel;
    protected $subjectModel;

    public function __construct()
    {
        $this->assignmentModel = new AssignmentModel();
        $this->classModel      = new ClassModel();
        $this->subjectModel    = new SubjectModel();
    }

    public function index()
    {
        if (session()->get('role') == 'ortu') {
            return redirect()->to('/parent/assignments');
        }
        $role      = session()->get('role');
        $userId    = session()->get('id');
        $teacherId = null;

        if ($role == 'guru') {
            $db        = \Config\Database::connect();
            $teacher   = $db->table('teachers')->where('user_id', $userId)->get()->getRowArray();
            $teacherId = $teacher ? $teacher['id'] : null;
        }

        $classId = $this->request->getGet('class_id');
        $search  = $this->request->getGet('search');
        $type    = $this->request->getGet('type');
        $gradingStatus = $this->request->getGet('grading_status');

        $activeYear = get_active_academic_year();
        $academicYearId = $activeYear ? $activeYear['id'] : null;

        $query = $this->assignmentModel->getAssignmentsWithRelations(
            $classId ? (int)$classId : null,
            $teacherId,
            $search ?: null,
            $type ?: null
        );

        if ($academicYearId) {
            $query->where('assignments.academic_year_id', $academicYearId);
        }

        if ($gradingStatus == 'ungraded') {
            $query->where($this->assignmentModel->pendingSubquery . ' > 0', null, false);
        } elseif ($gradingStatus == 'graded') {
            $query->where($this->assignmentModel->pendingSubquery . ' = 0', null, false);
        }

        $assignments = $query->paginate(9, 'assignments');

        $data = [
            'title'       => 'Daftar Pembelajaran',
            'assignments' => $assignments,
            'pager'       => $this->assignmentModel->pager,
            'classes'     => $this->classModel->findAll(),
            'activeYear'  => $activeYear,
            'selectedClass' => $classId,
            'currentTeacherId' => $teacherId,
            'filters' => [
                'search'   => $search,
                'class_id' => $classId,
                'type'     => $type,
                'grading_status' => $gradingStatus,
            ],
        ];

        return view('admin/assignments/index', $data);
    }

    public function create()
    {
        if (session()->get('role') == 'ortu') {
            return redirect()->to('/parent/assignments');
        }
        $role   = session()->get('role');
        $userId = session()->get('id');
        $db     = \Config\Database::connect();

        $teacherId = null;
        if ($role == 'guru') {
            $teacher = $db->table('teachers')->where('user_id', $userId)->get()->getRowArray();
            $teacherId = $teacher ? $teacher['id'] : null;
            
            if (!$teacherId) {
                return redirect()->to('/assignments')->with('error', 'Data guru tidak ditemukan.');
            }
        }

        $data = [
            'title'    => 'Tambah Pembelajaran',
            'classes'  => $this->classModel->findAll(),
            'subjects' => $this->subjectModel->findAll(),
            'teachers' => ($role == 'admin') ? $db->table('teachers')->select('id, full_name')->get()->getResultArray() : [],
            'teacherId' => $teacherId,
        ];

        return view('admin/assignments/create', $data);
    }

    public function store()
    {
        if (session()->get('role') == 'ortu') {
            return redirect()->to('/parent/assignments');
        }
        $rules = $this->assignmentModel->getValidationRules();
        unset($rules['academic_year_id']);
        $rules['file_upload'] = 'max_size[file_upload,5120]|ext_in[file_upload,pdf,doc,docx,ppt,pptx,jpg,png,zip]';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Periksa kembali form.');
        }

        $file = $this->request->getFile('file_upload');
        $filePath = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            
            // Ensure directory exists
            if (!is_dir(ROOTPATH . 'public/uploads/assignments')) {
                mkdir(ROOTPATH . 'public/uploads/assignments', 0777, true);
            }

            $file->move(ROOTPATH . 'public/uploads/assignments', $newName);
            $filePath = $newName;
        }

        $activeYear = get_active_academic_year();
        $academicYearId = $activeYear ? $activeYear['id'] : null;

        $saveData = [
            'class_id'    => $this->request->getVar('class_id'),
            'subject_id'  => $this->request->getVar('subject_id'),
            'teacher_id'  => $this->request->getVar('teacher_id'),
            'academic_year_id' => $academicYearId,
            'title'       => $this->request->getVar('title'),
            'type'        => $this->request->getVar('type'),
            'description' => $this->request->getVar('description'),
            'file_path'   => $filePath,
            'deadline'    => date('Y-m-d H:i:s', strtotime($this->request->getVar('deadline'))),
        ];

        if (!$this->assignmentModel->save($saveData)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . implode(', ', $this->assignmentModel->errors()));
        }

        // Notify Students
        $db = \Config\Database::connect();
        $classId = $this->request->getVar('class_id');
        $students = $db->table('students')->where('class_id', $classId)->get()->getResultArray();
        $studentUserIds = array_filter(array_column($students, 'user_id'));

        if (!empty($studentUserIds)) {
            $notifModel = new \App\Models\NotificationModel();
            $subject = $db->table('subjects')->where('id', $this->request->getVar('subject_id'))->get()->getRowArray();
            $subjectName = $subject ? $subject['name'] : 'Mata Pelajaran';
            
            $notifModel->notifyUsers(
                $studentUserIds,
                'Pembelajaran Baru: ' . $this->request->getVar('title'),
                'Pembelajaran baru untuk mata pelajaran ' . $subjectName . ' telah diunggah. Deadline: ' . date('d M Y, H:i', strtotime($this->request->getVar('deadline'))),
                base_url('assignments'),
                'assignment'
            );
        }

        return redirect()->to('/assignments')->with('message', 'Pembelajaran berhasil diunggah.');
    }

    public function edit($id)
    {
        if (session()->get('role') == 'ortu') {
            return redirect()->to('/parent/assignments');
        }
        $assignment = $this->assignmentModel->find($id);
        if (!$assignment) {
            throw new PageNotFoundException('Data tidak ditemukan.');
        }

        $role      = session()->get('role');
        $userId    = session()->get('id');
        $db        = \Config\Database::connect();
        $teacherId = null;

        if ($role == 'guru') {
            $teacher = $db->table('teachers')->where('user_id', $userId)->get()->getRowArray();
            $teacherId = $teacher ? $teacher['id'] : null;

            // Ownership check
            if ($assignment['teacher_id'] != $teacherId) {
                return redirect()->to('/assignments')->with('error', 'Anda tidak memiliki akses untuk mengubah pembelajaran ini.');
            }
        }

        $data = [
            'title'       => 'Edit Pembelajaran',
            'assignment'  => $assignment,
            'classes'     => $this->classModel->findAll(),
            'subjects'    => $this->subjectModel->findAll(),
            'teachers'    => ($role == 'admin') ? $db->table('teachers')->select('id, full_name')->get()->getResultArray() : [],
            'teacherId'   => $teacherId,
        ];

        return view('admin/assignments/edit', $data);
    }

    public function update($id)
    {
        if (session()->get('role') == 'ortu') {
            return redirect()->to('/parent/assignments');
        }
        $assignment = $this->assignmentModel->find($id);
        if (!$assignment) {
            throw new PageNotFoundException('Data tidak ditemukan.');
        }

        $role = session()->get('role');
        if ($role == 'guru') {
            $userId = session()->get('id');
            $db = \Config\Database::connect();
            $teacher = $db->table('teachers')->where('user_id', $userId)->get()->getRowArray();
            $teacherId = $teacher ? $teacher['id'] : null;

            if ($assignment['teacher_id'] != $teacherId) {
                return redirect()->to('/assignments')->with('error', 'Anda tidak memiliki akses untuk mengubah pembelajaran ini.');
            }
        }

        $rules = $this->assignmentModel->getValidationRules();
        unset($rules['academic_year_id']);
        $rules['file_upload'] = 'max_size[file_upload,5120]|ext_in[file_upload,pdf,doc,docx,ppt,pptx,jpg,png,zip]';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal.');
        }

        $file = $this->request->getFile('file_upload');
        $filePath = $assignment['file_path'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old file if exists
            if ($filePath && file_exists(ROOTPATH . 'public/uploads/assignments/' . $filePath)) {
                unlink(ROOTPATH . 'public/uploads/assignments/' . $filePath);
            }
            $newName = $file->getRandomName();

            // Ensure directory exists
            if (!is_dir(ROOTPATH . 'public/uploads/assignments')) {
                mkdir(ROOTPATH . 'public/uploads/assignments', 0777, true);
            }

            $file->move(ROOTPATH . 'public/uploads/assignments', $newName);
            $filePath = $newName;
        }

        $activeYear = get_active_academic_year();
        $academicYearId = $activeYear ? $activeYear['id'] : $assignment['academic_year_id'];

        $updateData = [
            'class_id'    => $this->request->getVar('class_id'),
            'subject_id'  => $this->request->getVar('subject_id'),
            'teacher_id'  => $this->request->getVar('teacher_id'),
            'academic_year_id' => $academicYearId,
            'title'       => $this->request->getVar('title'),
            'type'        => $this->request->getVar('type'),
            'description' => $this->request->getVar('description'),
            'file_path'   => $filePath,
            'deadline'    => date('Y-m-d H:i:s', strtotime($this->request->getVar('deadline'))),
        ];

        if (!$this->assignmentModel->update($id, $updateData)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data: ' . implode(', ', $this->assignmentModel->errors()));
        }

        // Notify Students about update
        $db = \Config\Database::connect();
        $classId = $this->request->getVar('class_id');
        $students = $db->table('students')->where('class_id', $classId)->get()->getResultArray();
        $studentUserIds = array_filter(array_column($students, 'user_id'));

        if (!empty($studentUserIds)) {
            $notifModel = new \App\Models\NotificationModel();
            $subject = $db->table('subjects')->where('id', $this->request->getVar('subject_id'))->get()->getRowArray();
            $subjectName = $subject ? $subject['name'] : 'Mata Pelajaran';
            
            $notifModel->notifyUsers(
                $studentUserIds,
                'Update Pembelajaran: ' . $this->request->getVar('title'),
                'Ada perubahan pada pembelajaran ' . $subjectName . '. Silakan periksa detail dan deadline terbaru.',
                base_url('assignments'),
                'assignment'
            );
        }

        return redirect()->to('/assignments')->with('message', 'Pembelajaran berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') == 'ortu') {
            return redirect()->to('/parent/assignments');
        }
        $assignment = $this->assignmentModel->find($id);
        if (!$assignment) {
            return redirect()->to('/assignments')->with('error', 'Data tidak ditemukan.');
        }

        $role = session()->get('role');
        if ($role == 'guru') {
            $userId = session()->get('id');
            $db = \Config\Database::connect();
            $teacher = $db->table('teachers')->where('user_id', $userId)->get()->getRowArray();
            $teacherId = $teacher ? $teacher['id'] : null;

            if ($assignment['teacher_id'] != $teacherId) {
                return redirect()->to('/assignments')->with('error', 'Anda tidak memiliki akses untuk menghapus pembelajaran ini.');
            }
        }

        if ($assignment['file_path']) {
            if (file_exists(ROOTPATH . 'public/uploads/assignments/' . $assignment['file_path'])) {
                unlink(ROOTPATH . 'public/uploads/assignments/' . $assignment['file_path']);
            }
        }
        // Get affected students before deleting
        $db = \Config\Database::connect();
        $submissions = $db->table('submissions')->where('assignment_id', $id)->get()->getResultArray();
        $studentIds = array_unique(array_column($submissions, 'student_id'));

        // Store assignment info for sync after deletion
        $assignmentInfo = $assignment;

        $this->assignmentModel->delete($id);

        // Re-sync each affected student
        foreach ($studentIds as $studentId) {
            $this->syncToGrades($studentId, $id, $assignmentInfo); 
        }

        return redirect()->to('/assignments')->with('message', 'Pembelajaran berhasil dihapus.');
    }

    public function download($id)
    {
        $assignment = $this->assignmentModel->find($id);
        if (!$assignment || !$assignment['file_path']) {
            throw new PageNotFoundException('File tidak ditemukan.');
        }

        $file = ROOTPATH . 'public/uploads/assignments/' . $assignment['file_path'];
        if (!file_exists($file)) {
            throw new PageNotFoundException('File fisik tidak ditemukan di server.');
        }

        return $this->response->download($file, null)->setFileName($assignment['title'] . '.' . pathinfo($file, PATHINFO_EXTENSION));
    }

    public function submissions($id)
    {
        if (session()->get('role') == 'ortu') {
            return redirect()->to('/parent/assignments');
        }
        $assignment = $this->assignmentModel->find($id);
        if (!$assignment) {
            throw new PageNotFoundException('Pembelajaran tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $submissions = $db->table('submissions')
                           ->select('submissions.*, students.full_name as student_name, students.nis')
                           ->join('students', 'students.id = submissions.student_id')
                           ->where('assignment_id', $id)
                           ->orderBy('created_at', 'DESC')
                           ->get()->getResultArray();

        $data = [
            'title'      => 'Peninjauan Pembelajaran: ' . $assignment['title'],
            'assignment' => $assignment,
            'submissions' => $submissions,
            'class'      => $db->table('classes')->where('id', $assignment['class_id'])->get()->getRowArray()
        ];

        return view('admin/assignments/submissions', $data);
    }

    public function report($id)
    {
        if (session()->get('role') == 'ortu') {
            return redirect()->to('/parent/assignments');
        }

        $assignment = $this->assignmentModel->find($id);
        if (!$assignment) {
            throw new PageNotFoundException('Data tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        
        // Use model method to get relations
        $assignment = $this->assignmentModel->getAssignmentsWithRelations()->find($id);

        // Get all students in the class
        $students = $db->table('students')
                       ->select('id, full_name, nis')
                       ->where('class_id', $assignment['class_id'])
                       ->orderBy('full_name', 'ASC')
                       ->get()->getResultArray();

        // Get submissions for this assignment
        $submissionsRaw = $db->table('submissions')
                             ->where('assignment_id', $id)
                             ->get()->getResultArray();
        
        $submissionsMap = [];
        foreach ($submissionsRaw as $sub) {
            $submissionsMap[$sub['student_id']] = $sub;
        }

        // Categorize
        $reportData = [
            'sudah' => [],
            'belum' => [],
            'terlambat' => []
        ];

        $deadline = strtotime($assignment['deadline']);

        foreach ($students as $student) {
            $sub = $submissionsMap[$student['id']] ?? null;
            
            if ($sub) {
                $student['submit_time'] = $sub['created_at'];
                $student['grade']       = $sub['grade'];
                $student['status_sub']  = $sub['status'];

                $submitTime = strtotime($sub['created_at']);
                if ($submitTime > $deadline) {
                    $reportData['terlambat'][] = $student;
                } else {
                    $reportData['sudah'][] = $student;
                }
            } else {
                $student['submit_time'] = null;
                $student['grade']       = null;
                $student['status_sub']  = null;
                $reportData['belum'][]  = $student;
            }
        }

        $data = [
            'title'      => 'Laporan Penyerahan – ' . $assignment['title'],
            'assignment' => $assignment,
            'reportData' => $reportData,
            'stats'      => [
                'total' => count($students),
                'sudah' => count($reportData['sudah']),
                'terlambat' => count($reportData['terlambat']),
                'belum' => count($reportData['belum']),
            ]
        ];

        return view('admin/assignments/report', $data);
    }

    public function downloadReportPdf($id)
    {
        if (session()->get('role') == 'ortu') {
            return redirect()->to('/parent/assignments');
        }

        $assignment = $this->assignmentModel->getAssignmentsWithRelations()->find($id);
        if (!$assignment) {
            throw new PageNotFoundException('Data tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        
        // Get all students in the class
        $students = $db->table('students')
                       ->select('id, full_name, nis')
                       ->where('class_id', $assignment['class_id'])
                       ->orderBy('full_name', 'ASC')
                       ->get()->getResultArray();

        // Get submissions
        $submissionsRaw = $db->table('submissions')
                             ->where('assignment_id', $id)
                             ->get()->getResultArray();
        
        $submissionsMap = [];
        foreach ($submissionsRaw as $sub) {
            $submissionsMap[$sub['student_id']] = $sub;
        }

        $reportData = ['sudah' => [], 'belum' => [], 'terlambat' => []];
        $deadline = strtotime($assignment['deadline']);

        foreach ($students as $student) {
            $sub = $submissionsMap[$student['id']] ?? null;
            if ($sub) {
                $student['submit_time'] = $sub['created_at'];
                $student['grade']       = $sub['grade'];
                $student['status_sub']  = $sub['status'];

                if (strtotime($sub['created_at']) > $deadline) {
                    $reportData['terlambat'][] = $student;
                } else {
                    $reportData['sudah'][] = $student;
                }
            } else {
                $student['submit_time'] = null;
                $student['grade']       = null;
                $student['status_sub']  = null;
                $reportData['belum'][]  = $student;
            }
        }

        $brand = school_branding();
        $data = [
            'title'      => 'LAPORAN PENYERAHAN ' . strtoupper($assignment['type']),
            'assignment' => $assignment,
            'reportData' => $reportData,
            'brand'      => $brand,
            'stats'      => [
                'total'     => count($students),
                'sudah'     => count($reportData['sudah']),
                'terlambat' => count($reportData['terlambat']),
                'belum'     => count($reportData['belum']),
            ]
        ];

        // Ensure logo path is absolute for DomPDF
        if($data['brand']['logo_raw'] && file_exists(FCPATH . $data['brand']['logo_raw'])) {
            $data['brand']['logo'] = FCPATH . $data['brand']['logo_raw'];
        }

        $dompdf = new \Dompdf\Dompdf([
            'isRemoteEnabled' => true,
            'chroot' => FCPATH,
            'isHtml5ParserEnabled' => true,
        ]);

        $html = view('admin/assignments/report_pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Laporan_Pembelajaran_' . str_replace(' ', '_', $assignment['title']) . '_' . date('YmdHis') . '.pdf';
        return $this->response->download($filename, $dompdf->output())->setContentType('application/pdf');
    }

    public function grade_submission($id)
    {
        if (session()->get('role') == 'ortu') {
            return redirect()->to('/parent/assignments');
        }
        $db = \Config\Database::connect();
        $submission = $db->table('submissions')->where('id', $id)->get()->getRowArray();
        
        if (!$submission) {
            return redirect()->back()->with('error', 'Data pengiriman tidak ditemukan.');
        }

        $grade = $this->request->getPost('grade');
        $feedback = $this->request->getPost('feedback');

        $db->table('submissions')->where('id', $id)->update([
            'grade'      => $grade,
            'feedback'   => $feedback,
            'status'     => 'reviewed',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Send Notification to Student/Parent
        $student = $db->table('students')->where('id', $submission['student_id'])->get()->getRowArray();
        if ($student && $student['user_id']) {
            $notifModel = new \App\Models\NotificationModel();
            $assignment = $this->assignmentModel->find($submission['assignment_id']);
            
            $notifModel->notifyUsers(
                [$student['user_id']],
                'Pembelajaran Dinilai: ' . $assignment['title'],
                'Pembelajaran Anda telah dinilai oleh guru. Nilai: ' . $grade,
                base_url('parent/assignments/view/' . $assignment['id']),
                'grade'
            );
        }

        // Sync to central grades table (Ledger)
        $this->syncToGrades($submission['student_id'], $submission['assignment_id']);

        return redirect()->back()->with('message', 'Nilai dan feedback berhasil disimpan.');
    }

    private function syncToGrades($studentId, $assignmentId, $providedAssignment = null)
    {
        $db = \Config\Database::connect();
        $academicYearModel = new \App\Models\AcademicYearModel();
        $gradesModel = new \App\Models\GradesModel();
        
        // Use provided info or fetch if assignment still exists
        $assignment = $providedAssignment ?? $this->assignmentModel->find($assignmentId);
        if (!$assignment) return;

        $subjectId = $assignment['subject_id'];
        
        $activeYear = $academicYearModel->getActiveYear();
        if (!$activeYear) return;
        
        $semester = $activeYear['semester'] == 'Ganjil' ? '1' : '2';
        $academicYearId = $activeYear['id'];

        // Define ledger categories
        $categories = [
            'Tugas' => ['Tugas', 'Ulangan', 'Sikap', 'Materi'], 
            'UTS'   => ['UTS'],
            'UAS'   => ['UAS']
        ];

        // Determine which category to sync based on assignments type
        $targetCategory = null;
        foreach ($categories as $cat => $types) {
            if (in_array($assignment['type'], $types)) {
                $targetCategory = $cat;
                break;
            }
        }

        if (!$targetCategory) return;

        // Calculate average for this student, subject, semester, and target category
        $builder = $db->table('submissions');
        $builder->selectAvg('grade');
        $builder->join('assignments', 'assignments.id = submissions.assignment_id');
        $builder->where('submissions.student_id', $studentId);
        $builder->where('assignments.subject_id', $subjectId);
        $builder->whereIn('assignments.type', $categories[$targetCategory]);
        $builder->where('submissions.status', 'reviewed');
        
        $result = $builder->get()->getRowArray();
        $average = $result['grade'] ?? 0;

        // Update or Insert into central grades table
        $exist = $gradesModel->where([
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'type'       => $targetCategory,
            'semester'   => $semester
        ])->first();

        $gradeData = [
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'type'       => $targetCategory,
            'score'      => $average,
            'semester'   => $semester,
            'academic_year_id' => $academicYearId,
            'status'     => 'Submitted',
            'description' => 'Sinkronisasi otomatis dari modul pembelajaran'
        ];

        if ($exist) {
            $gradesModel->update($exist['id'], $gradeData);
        } else {
            $gradesModel->save($gradeData);
        }
    }

    public function download_submission($id)
    {
        if (session()->get('role') == 'ortu') {
            return redirect()->to('/parent/assignments');
        }
        $db = \Config\Database::connect();
        $submission = $db->table('submissions')->where('id', $id)->get()->getRowArray();

        if (!$submission || !$submission['file_path']) {
            throw new PageNotFoundException('File tidak ditemukan.');
        }

        $file = ROOTPATH . 'public/uploads/submissions/' . $submission['file_path'];
        if (!file_exists($file)) {
            throw new PageNotFoundException('File fisik tidak ditemukan.');
        }

        $student = $db->table('students')->where('id', $submission['student_id'])->get()->getRowArray();
        $assignment = $this->assignmentModel->find($submission['assignment_id']);
        
        $fileName = 'Jawaban_' . ($student ? $student['full_name'] : 'Siswa') . '_' . $assignment['title'] . '.' . pathinfo($file, PATHINFO_EXTENSION);

        return $this->response->download($file, null)->setFileName($fileName);
    }
}
