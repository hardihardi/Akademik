<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\GradesModel;
use App\Models\AcademicYearModel;

class Ledger extends BaseController
{
    protected $studentModel;
    protected $classModel;
    protected $subjectModel;
    protected $gradesModel;
    protected $academicYearModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->classModel = new ClassModel();
        $this->subjectModel = new SubjectModel();
        $this->gradesModel = new GradesModel();
        $this->academicYearModel = new AcademicYearModel();
        $this->homeroomModel = new \App\Models\HomeroomAssignmentModel();
        $this->teacherModel = new \App\Models\TeacherModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('id');
        $classes = [];

        if ($role == 'admin' || $role == 'kepsek') {
            $classes = $this->classModel->findAll();
        } elseif (has_permission('ledger.view')) {
            $teacher = $this->teacherModel->where('user_id', $userId)->first();
            if ($teacher) {
                $activeYear = get_active_academic_year();
                if ($activeYear) {
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
            'title' => 'Rekap Nilai',
            'classes' => $classes
        ];
        return view('academic/ledger/index', $data);
    }

    public function view($classId)
    {
        $access = $this->checkClassAccess($classId);
        if ($access !== true) return $access;

        $class = $this->classModel->find($classId);
        $activeYear = get_active_academic_year();

        if (!$activeYear) {
            return redirect()->back()->with('error', 'Tahun Akademik Aktif belum diset.');
        }

        $semester = get_semester_id($activeYear['semester']);

        $students = $this->studentModel->where('class_id', $classId)->orderBy('full_name', 'ASC')->findAll();
        $subjects = $this->subjectModel->findAll();

        $studentIds = array_column($students, 'id');
        
        $gradesRaw = [];
        if (!empty($studentIds)) {
            $gradesRaw = $this->gradesModel->whereIn('student_id', $studentIds)
                                           ->where('semester', $semester)
                                           ->where('academic_year_id', $activeYear['id'])
                                           ->findAll();
        }

        $tempGrades = [];
        foreach ($gradesRaw as $grade) {
            $tempGrades[$grade['student_id']][$grade['subject_id']][strtolower($grade['type'])] = $grade['score'];
        }

        $ledger = [];
        $studentAverages = [];

        $weights = get_assessment_weights();
        foreach ($students as $student) {
            $totalScore = 0;
            $sid = $student['id'];

            foreach ($subjects as $subj) {
                $scores = $tempGrades[$sid][$subj['id']] ?? [];
                $tugas = $scores['tugas'] ?? 0;
                $uts = $scores['uts'] ?? 0;
                $uas = $scores['uas'] ?? 0;
                
                $final = ($tugas * $weights['tugas']) + ($uts * $weights['uts']) + ($uas * $weights['uas']);
                $ledger[$sid][$subj['id']] = number_format($final, 0);
                
                $totalScore += $final;
            }
            
            $avg = $totalScore / (count($subjects) > 0 ? count($subjects) : 1);
            $studentAverages[$sid] = $avg;
        }

        arsort($studentAverages);
        $ranks = [];
        $rank = 1;
        foreach ($studentAverages as $sid => $avg) {
            $ranks[$sid] = $rank++;
        }

        // Fetch Branding & Metadata
        $brand = school_branding();
        $homeroomModel = new \App\Models\HomeroomAssignmentModel();
        $homeroom = $homeroomModel->select('teachers.full_name, teachers.nip')
                                  ->join('teachers', 'teachers.id = homeroom_assignments.teacher_id')
                                  ->where('class_id', $classId)
                                  ->where('academic_year_id', $activeYear['id'])
                                  ->first();

        $data = [
            'title' => 'Leger Nilai - ' . $class['name'],
            'class' => $class,
            'year' => $activeYear,
            'students' => $students,
            'subjects' => $subjects,
            'ledger' => $ledger,
            'averages' => $studentAverages,
            'ranks' => $ranks,
            'school_name' => $brand['name'],
            'homeroom' => $homeroom['full_name'] ?? '____________________',
            'homeroom_nip' => $homeroom['nip'] ?? '-'
        ];

        return view('academic/ledger/view', $data);
    }

    public function sync($classId)
    {
        $access = $this->checkClassAccess($classId);
        if ($access !== true) return $access;

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
                // Get all subjects that have assignments for this student
                $subjectIds = $db->table('assignments')
                                 ->select('subject_id')
                                 ->where('class_id', $classId)
                                 ->groupBy('subject_id')
                                 ->get()->getResultArray();

                foreach ($subjectIds as $subj) {
                    $sid = $subj['subject_id'];
                    
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
                            'description' => 'Sikronisasi massal dari Tugas & Materi'
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

        return redirect()->back()->with('message', 'Data berhasil disinkronkan dengan Tugas & Materi.');
    }

    public function pdf($classId)
    {
        $access = $this->checkClassAccess($classId);
        if ($access !== true) return $access;

        $class = $this->classModel->find($classId);
        $activeYear = get_active_academic_year();
        $semester = get_semester_id($activeYear['semester']);

        $students = $this->studentModel->where('class_id', $classId)->orderBy('full_name', 'ASC')->findAll();
        $subjects = $this->subjectModel->findAll();
        $studentIds = array_column($students, 'id');
        
        $gradesRaw = $this->gradesModel->whereIn('student_id', $studentIds)
                                       ->where('semester', $semester)
                                       ->where('academic_year_id', $activeYear['id'])
                                       ->findAll();

        $tempGrades = [];
        foreach ($gradesRaw as $grade) {
            $tempGrades[$grade['student_id']][$grade['subject_id']][strtolower($grade['type'])] = $grade['score'];
        }

        $ledger = [];
        $studentAverages = [];
        $weights = get_assessment_weights();
        foreach ($students as $student) {
            $totalScore = 0;
            $sid = $student['id'];
            foreach ($subjects as $subj) {
                $scores = $tempGrades[$sid][$subj['id']] ?? [];
                $tugas = $scores['tugas'] ?? 0;
                $uts = $scores['uts'] ?? 0;
                $uas = $scores['uas'] ?? 0;
                $final = ($tugas * $weights['tugas']) + ($uts * $weights['uts']) + ($uas * $weights['uas']);
                $ledger[$sid][$subj['id']] = number_format($final, 0);
                $totalScore += $final;
            }
            $studentAverages[$sid] = $totalScore / (count($subjects) > 0 ? count($subjects) : 1);
        }

        arsort($studentAverages);
        $ranks = [];
        $rank = 1;
        foreach ($studentAverages as $sid => $avg) {
            $ranks[$sid] = $rank++;
        }

        // Fetch Branding & Metadata
        $brand = school_branding();
        $homeroomModel = new \App\Models\HomeroomAssignmentModel();

        $homeroom = $homeroomModel->select('teachers.full_name, teachers.nip')
                                  ->join('teachers', 'teachers.id = homeroom_assignments.teacher_id')
                                  ->where('class_id', $classId)
                                  ->where('academic_year_id', $activeYear['id'])
                                  ->first();

        $data = [
            'class' => $class,
            'year' => $activeYear,
            'students' => $students,
            'subjects' => $subjects,
            'ledger' => $ledger,
            'averages' => $studentAverages,
            'ranks' => $ranks,
            'school_name' => $brand['name'],
            'school_logo' => ($brand['logo_raw'] && file_exists(FCPATH . $brand['logo_raw'])) ? FCPATH . $brand['logo_raw'] : null,
            'headmaster' => $brand['headmaster'],
            'headmaster_nip' => $brand['headmaster_nip'],
            'headmaster_signature' => ($brand['signature_raw'] && file_exists(FCPATH . $brand['signature_raw'])) ? FCPATH . $brand['signature_raw'] : null,
            'homeroom' => $homeroom['full_name'] ?? '____________________',
            'homeroom_nip' => $homeroom['nip'] ?? '-'
        ];

        $html = view('academic/ledger/pdf_template', $data);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        return $this->response->setHeader('Content-Type', 'application/pdf')
                              ->setBody($dompdf->output());
    }
    private function checkClassAccess($classId)
    {
        $role = session()->get('role');
        $userId = session()->get('id');

        if ($role == 'admin' || $role == 'kepsek') return true;

        if (has_permission('ledger.view')) {
            $teacher = $this->teacherModel->where('user_id', $userId)->first();
            $activeYear = get_active_academic_year();
            
            if (!$teacher || !$activeYear) {
                return redirect()->to('/ledger')->with('error', 'Akses ditolak. Data guru atau tahun akademik tidak ditemukan.');
            }

            $isAssigned = $this->homeroomModel->where([
                'teacher_id' => $teacher['id'],
                'class_id' => $classId,
                'academic_year_id' => $activeYear['id']
            ])->countAllResults() > 0;

            if (!$isAssigned) {
                return redirect()->to('/ledger')->with('error', 'Akses ditolak. Anda bukan wali kelas untuk kelas ini.');
            }
            
            return true;
        }

        return redirect()->to('/ledger')->with('error', 'Akses ditolak.');
    }
}
