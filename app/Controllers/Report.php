<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use App\Models\GradesModel;
use App\Models\AttendanceModel;
use App\Models\SettingsModel;
use App\Models\AcademicYearModel;

class Report extends BaseController
{
    protected $classModel;
    protected $studentModel;
    protected $subjectModel;
    protected $gradesModel;
    protected $attendanceModel;
    protected $academicYearModel;
    protected $settingsModel;
    protected $reportCardModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->studentModel = new StudentModel();
        $this->subjectModel = new SubjectModel();
        $this->gradesModel = new GradesModel();
        $this->attendanceModel = new AttendanceModel();
        $this->academicYearModel = new AcademicYearModel();
        $this->settingsModel = new SettingsModel();
        $this->reportCardModel = new \App\Models\ReportCardModel();
        $this->homeroomModel = new \App\Models\HomeroomAssignmentModel();
        $this->teacherModel = new \App\Models\TeacherModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('id');
        $classes = [];

        if ($role == 'admin') {
            $classes = $this->classModel->findAll();
        } elseif (has_permission('report.view')) {
            // Get teacher record for this user
            $teacher = $this->teacherModel->where('user_id', $userId)->first();
            if ($teacher) {
                $activeYear = get_active_academic_year();
                if ($activeYear) {
                    // Get classes assigned to this teacher as Wali Kelas
                    $assignments = $this->homeroomModel->where([
                        'teacher_id' => $teacher['id'],
                        'academic_year_id' => $activeYear['id']
                    ])->findAll();
                    
                    $classIds = array_column($assignments, 'class_id');
                    if (!empty($classIds)) {
                        $classes = $this->classModel->whereIn('id', $classIds)->findAll();
                    }
                }
            }
        }

        $data = [
            'title' => 'Cetak Rapor',
            'classes' => $classes,
            'activeYear' => get_active_academic_year()
        ];
        return view('academic/report/index', $data);
    }

    public function students($classId)
    {
        $role = session()->get('role');
        $userId = session()->get('id');

        // Security check for Wali Kelas
        if ($role != 'admin' && has_permission('report.view')) {
            $teacher = $this->teacherModel->where('user_id', $userId)->first();
            $activeYear = get_active_academic_year();
            
            if (!$teacher || !$activeYear) {
                return redirect()->to('/report')->with('error', 'Akses ditolak. Data guru atau tahun akademik tidak ditemukan.');
            }

            $isAssigned = $this->homeroomModel->where([
                'teacher_id' => $teacher['id'],
                'class_id' => $classId,
                'academic_year_id' => $activeYear['id']
            ])->countAllResults() > 0;

            if (!$isAssigned) {
                return redirect()->to('/report')->with('error', 'Akses ditolak. Anda bukan wali kelas untuk kelas ini.');
            }
        }

        $class = $this->classModel->find($classId);
        if (!$class) {
            return redirect()->to('/report')->with('error', 'Kelas tidak ditemukan');
        }

        $students = $this->studentModel->where('class_id', $classId)->orderBy('full_name', 'ASC')->findAll();
        
        $data = [
            'title' => 'Daftar Siswa - ' . $class['name'],
            'class' => $class,
            'students' => $students,
            'activeYear' => get_active_academic_year()
        ];

        return view('academic/report/class_detail', $data);
    }

    public function print($studentId)
    {
        $data = $this->getReportData($studentId);
        if (isset($data['error'])) {
            return redirect()->back()->with('error', $data['error']);
        }

        return view('academic/report/print', $data);
    }

    public function downloadPdf($studentId)
    {
        $data = $this->getReportData($studentId);
        if (isset($data['error'])) {
            return redirect()->back()->with('error', $data['error']);
        }

        // Local path mapping for DomPDF
        if($data['school']['logo_raw'] && file_exists(FCPATH . $data['school']['logo_raw'])) {
            $data['school']['logo'] = str_replace('\\', '/', FCPATH . $data['school']['logo_raw']);
        }

        if($data['school']['signature_raw'] && file_exists(FCPATH . $data['school']['signature_raw'])) {
            $data['school']['headmaster_signature'] = str_replace('\\', '/', FCPATH . $data['school']['signature_raw']);
        }

        $dompdf = new \Dompdf\Dompdf([
            'isRemoteEnabled' => false,
            'chroot' => str_replace('\\', '/', FCPATH),
            'isHtml5ParserEnabled' => true,
            'isFontSubsettingEnabled' => true,
        ]);

        $html = view('academic/report/pdf_template', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Rapor_' . str_replace(' ', '_', $data['student']['full_name']) . '_S' . $data['semester'] . '.pdf';
        
        return $this->response->download($filename, $dompdf->output())->setContentType('application/pdf');
    }

    public function sync($classId)
    {
        $activeYear = get_active_academic_year();
        if (!$activeYear) return redirect()->back()->with('error', 'Tahun Akademik Aktif belum diset.');
        
        $semester = get_semester_id($activeYear['semester']);
        $students = $this->studentModel->where('class_id', $classId)->findAll();
        $db = \Config\Database::connect();

        $categories = [
            'Tugas' => ['Tugas', 'Ulangan', 'Sikap', 'Materi'],
            'UTS'   => ['UTS'],
            'UAS'   => ['UAS']
        ];

        foreach ($students as $student) {
            foreach ($categories as $ledgerType => $assignmentTypes) {
                // Get all subjects
                $subjects = $this->subjectModel->findAll();

                foreach ($subjects as $subj) {
                    $sid = $subj['id'];
                    
                    // Calculate average
                    $avg = $db->table('submissions')
                              ->join('assignments', 'assignments.id = submissions.assignment_id')
                              ->where('submissions.student_id', $student['id'])
                              ->where('assignments.subject_id', $sid)
                              ->whereIn('assignments.type', $assignmentTypes)
                              ->where('submissions.status', 'reviewed')
                              ->selectAvg('grade')
                              ->get()->getRowArray();
                    
                    if ($avg['grade'] !== null) {
                        $exist = $this->gradesModel->where([
                            'student_id' => $student['id'],
                            'subject_id' => $sid,
                            'type'       => $ledgerType,
                            'semester'   => $semester,
                            'academic_year_id' => $activeYear['id']
                        ])->first();

                        $gradeData = [
                            'student_id' => $student['id'],
                            'subject_id' => $sid,
                            'type'       => $ledgerType,
                            'score'      => $avg['grade'],
                            'semester'   => $semester,
                            'academic_year_id' => $activeYear['id'],
                            'status'     => 'Submitted',
                            'description' => 'Sinkronisasi massal dari Tugas & Materi'
                        ];

                        if ($exist) {
                            $this->gradesModel->update($exist['id'], $gradeData);
                        } else {
                            $this->gradesModel->save($gradeData);
                        }
                    }
                }
            }
        }

        return redirect()->back()->with('message', 'Data rapor berhasil disinkronkan dengan Tugas & Materi.');
    }

    private function getReportData($studentId)
    {
        $activeYear = get_active_academic_year();
        $semester = $this->request->getVar('semester') ?? get_semester_id($activeYear['semester']);
        $student = $this->studentModel->find($studentId);
        
        if (!$student) {
            return ['error' => 'Siswa tidak ditemukan'];
        }

        $class = $this->classModel->find($student['class_id']);
        $subjects = $this->subjectModel->findAll();
        
        $school = school_branding();

        // Fetch Grades with academic_year_id filter
        $gradesRaw = $this->gradesModel->where([
            'student_id' => $studentId,
            'semester' => $semester,
            'academic_year_id' => $activeYear['id']
        ])->findAll();
        
        // Process Grades into [subject_id => ['Tugas' => X, 'UTS' => Y, ...]]
        $grades = [];
        foreach ($gradesRaw as $getRow) {
            $grades[$getRow['subject_id']][$getRow['type']] = $getRow['score'];
        }

        // Calculate Final Scores
        $reportData = [];
        foreach ($subjects as $subject) {
            $tugas = $grades[$subject['id']]['Tugas'] ?? 0;
            $uts = $grades[$subject['id']]['UTS'] ?? 0;
            $uas = $grades[$subject['id']]['UAS'] ?? 0;

            $weights = get_assessment_weights();
            // Formula: (Tugas * PH%) + (UTS * UTS%) + (UAS * UAS%)
            $finalScore = ($tugas * $weights['tugas']) + ($uts * $weights['uts']) + ($uas * $weights['uas']);
            
            $reportData[] = [
                'subject' => $subject['name'],
                'kkm' => $subject['kkm'] ?? 70,
                'score' => round($finalScore),
                'description' => $this->getPredicate($finalScore)
            ];
        }

        // Attendance Summary: Scoped to active academic year + semester date range
        $db = \Config\Database::connect();
        
        // Build semester date range from academic year
        $yearParts = explode('/', $activeYear['year']); // e.g. "2025/2026"
        $yearStart = $yearParts[0] ?? date('Y');
        $yearEnd = $yearParts[1] ?? ($yearStart + 1);
        
        if ($semester == '1') {
            // Ganjil: Juli - Desember
            $semesterStart = $yearStart . '-07-01';
            $semesterEnd = $yearStart . '-12-31';
        } else {
            // Genap: Januari - Juni
            $semesterStart = $yearEnd . '-01-01';
            $semesterEnd = $yearEnd . '-06-30';
        }

        $attendanceQuery = $db->table('attendance')
                              ->where('student_id', $studentId);
        
        // Try with academic_year_id first
        $attendanceSummary = (clone $attendanceQuery)
                              ->where('academic_year_id', $activeYear['id'])
                              ->where('date >=', $semesterStart)
                              ->where('date <=', $semesterEnd)
                              ->get()->getResultArray();
        
        // Fallback: if no results with academic_year_id, try date range only
        if (empty($attendanceSummary)) {
            $attendanceSummary = (clone $attendanceQuery)
                                  ->where('date >=', $semesterStart)
                                  ->where('date <=', $semesterEnd)
                                  ->get()->getResultArray();
        }
        
        // Final fallback: if still empty, get ALL attendance for this academic year
        if (empty($attendanceSummary)) {
            $attendanceSummary = $db->table('attendance')
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

        $activeYear = get_active_academic_year();
        $reportCard = $this->reportCardModel->getStudentReport($studentId, $activeYear['id'], $semester);

        // Fetch Homeroom Teacher Info
        $homeroomInfo = null;
        if ($class) {
            $assignment = $this->homeroomModel->where([
                'class_id' => $class['id'],
                'academic_year_id' => $activeYear['id']
            ])->first();

            if ($assignment) {
                $homeroomInfo = $this->teacherModel->find($assignment['teacher_id']);
            }
        }

        return [
            'student' => $student,
            'class' => $class,
            'reportData' => $reportData,
            'attendance' => $attendance,
            'semester' => $semester,
            'year' => $activeYear['year'] ?? date('Y'),
            'date' => date('d F Y'),
            'school' => $school,
            'school_city' => $school['city'] ?? 'Ditetapkan',
            'reportCard' => $reportCard,
            'homeroom' => $homeroomInfo ? $homeroomInfo['full_name'] : (session()->get('username')),
            'homeroom_nip' => $homeroomInfo ? $homeroomInfo['nip'] : '-'
        ];
    }

    private function getPredicate($score)
    {
        if ($score >= 90) return 'Sangat Baik';
        if ($score >= 80) return 'Baik';
        if ($score >= 70) return 'Cukup';
        return 'Perlu Bimbingan';
    }

    public function inputNotes($studentId)
    {
        $activeYear = get_active_academic_year();
        $semester = get_semester_id($activeYear['semester']);
        $student = $this->studentModel->find($studentId);
        
        if (!$student) {
            return redirect()->back()->with('error', 'Siswa tidak ditemukan');
        }

        $reportCard = $this->reportCardModel->getStudentReport($studentId, $activeYear['id'], $semester);

        $data = [
            'title' => 'Input Catatan Wali Kelas',
            'student' => $student,
            'activeYear' => $activeYear,
            'semester' => $semester,
            'reportCard' => $reportCard
        ];

        return view('academic/report/input_notes', $data);
    }

    public function saveNotes()
    {
        $studentId = $this->request->getVar('student_id');
        $academicYearId = $this->request->getVar('academic_year_id');
        $semester = $this->request->getVar('semester');
        $notes = $this->request->getVar('homeroom_notes');

        $reportCard = $this->reportCardModel->getStudentReport($studentId, $academicYearId, $semester);

        $data = [
            'student_id' => $studentId,
            'academic_year_id' => $academicYearId,
            'semester' => $semester,
            'homeroom_notes' => $notes,
            'promotion_status' => $this->request->getVar('promotion_status'),
            'status' => 'Draft'
        ];

        if ($reportCard) {
            $this->reportCardModel->update($reportCard['id'], $data);
        } else {
            $this->reportCardModel->save($data);
        }

        // Phase 3.3: Capture History for Semester 2 (Promotion Phase)
        if ($semester == '2' && !empty($this->request->getVar('promotion_status'))) {
            $historyModel = new \App\Models\StudentClassHistoryModel();
            
            // Check if record already exists for this student + academic year
            $existing = $historyModel->where('student_id', $studentId)
                                     ->where('academic_year_id', $academicYearId)
                                     ->first();
            
            $historyData = [
                'student_id' => $studentId,
                'class_id' => $this->request->getVar('class_id'),
                'academic_year_id' => $academicYearId,
                'promotion_status' => $this->request->getVar('promotion_status')
            ];

            if ($existing) {
                $historyModel->update($existing['id'], $historyData);
            } else {
                $historyModel->save($historyData);
            }
        }

        // Send Notification to Parent/Student
        $student = $this->studentModel->find($studentId);
        if ($student && $student['user_id']) {
            $notifModel = new \App\Models\NotificationModel();
            $notifYear = $this->academicYearModel->find($academicYearId);
            $yearName = $notifYear ? $notifYear['year'] : '';
            
            $notifModel->notify(
                $student['user_id'],
                'Catatan Wali Kelas Baru',
                "Wali Kelas telah memperbarui catatan pada rapor Ananda " . $student['full_name'] . " untuk Semester " . $semester . " (" . $yearName . ").",
                base_url('parent/reports'),
                'report'
            );
        }

        return redirect()->to('/report/students/' . $this->request->getVar('class_id'))->with('message', 'Catatan wali kelas berhasil disimpan');
    }
}
