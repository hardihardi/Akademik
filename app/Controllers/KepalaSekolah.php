<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\TeacherModel;
use App\Models\ClassModel;
use App\Models\GradesModel;
use App\Models\AttendanceModel;
use App\Models\AcademicYearModel;
use App\Models\TeacherAssignmentModel;

class KepalaSekolah extends BaseController
{
    protected $studentModel;
    protected $teacherModel;
    protected $classModel;
    protected $gradesModel;
    protected $attendanceModel;
    protected $academicYearModel;
    protected $teacherAssignmentModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->teacherModel = new TeacherModel();
        $this->classModel = new ClassModel();
        $this->gradesModel = new GradesModel();
        $this->attendanceModel = new AttendanceModel();
        $this->academicYearModel = new AcademicYearModel();
        $this->teacherAssignmentModel = new TeacherAssignmentModel();
    }

    public function dashboard()
    {
        $activeYear = $this->academicYearModel->where('status', 'Active')->first();
        
        $data = [
            'title' => 'Dashboard Kepala Sekolah',
            'stats' => [
                'total_students' => $this->studentModel->countAllResults(),
                'total_teachers' => $this->teacherModel->countAllResults(),
                'total_classes'  => $this->classModel->countAllResults(),
                'avg_grade'      => number_format($this->gradesModel->selectAvg('score')->first()['score'] ?? 0, 1),
            ],
            'activeYear' => $activeYear,
            // Data for charts
            'classGrades' => $this->getClassGradeAverages(),
            'attendanceStats' => $this->getAttendanceStats(),
        ];

        return view('kepala_sekolah/dashboard', $data);
    }

    protected function getClassGradeAverages()
    {
        return $this->classModel->select('classes.name, COALESCE(AVG(grades.score), 0) as avg_score', false)
            ->join('students', 'students.class_id = classes.id', 'left')
            ->join('grades', 'grades.student_id = students.id', 'left')
            ->groupBy('classes.id')
            ->findAll();
    }

    protected function getAttendanceStats()
    {
        $stats = $this->attendanceModel->select('status, COUNT(*) as count')
            ->groupBy('status')
            ->findAll();
        
        $results = ['Hadir' => 0, 'Sakit' => 0, 'Izin' => 0, 'Alfa' => 0];
        $map = ['H' => 'Hadir', 'S' => 'Sakit', 'I' => 'Izin', 'A' => 'Alfa'];
        
        foreach ($stats as $s) {
            $label = $map[$s['status']] ?? $s['status'];
            if (isset($results[$label])) {
                $results[$label] = (int)$s['count'];
            }
        }
        return $results;
    }

    public function monitoringGrades()
    {
        $activeYear = $this->academicYearModel->where('status', 'Active')->first();
        
        // Monitoring logic: Show classes, their subject count, and how many have entries in grades
        $semesterCode = ($activeYear['semester'] == 'Ganjil') ? '1' : '2';
        $gradeProgress = $this->classModel->select('classes.id, classes.name, COUNT(DISTINCT grades.subject_id) as subjects_graded')
            ->join('students', 'students.class_id = classes.id', 'left')
            ->join('grades', 'grades.student_id = students.id AND grades.semester = "' . $semesterCode . '"', 'left')
            ->groupBy('classes.id')
            ->findAll();

        $data = [
            'title' => 'Monitoring Input Nilai',
            'gradeProgress' => $gradeProgress,
            'activeYear' => $activeYear
        ];
        return view('kepala_sekolah/monitoring_grades', $data);
    }

    public function monitoringAttendance()
    {
        $date = $this->request->getVar('date') ?: date('Y-m-d');
        
        $attendanceData = $this->classModel->select('classes.id, classes.name')
            ->findAll();

        foreach ($attendanceData as &$class) {
            $stats = $this->attendanceModel->select('status, COUNT(*) as count')
                ->where('class_id', $class['id'])
                ->where('date', $date)
                ->groupBy('status')
                ->findAll();
            
            $formattedStats = ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0];
            foreach ($stats as $s) {
                if (isset($formattedStats[$s['status']])) {
                    $formattedStats[$s['status']] = $s['count'];
                }
            }
            $class['stats'] = $formattedStats;
            $class['total_present'] = $formattedStats['H'];
            $class['total_students'] = $this->studentModel->where('class_id', $class['id'])->countAllResults();
        }

        $data = [
            'title' => 'Monitoring Absensi Harian',
            'attendanceData' => $attendanceData,
            'selectedDate' => $date
        ];
        return view('kepala_sekolah/monitoring_attendance', $data);
    }

    public function monitoringTeachers()
    {
        $activeYear = $this->academicYearModel->where('status', 'Active')->first();
        if (!$activeYear) {
            return redirect()->to('kepsek/dashboard')->with('error', 'Tidak ada tahun akademik aktif.');
        }

        $teachers = $this->teacherModel->orderBy('full_name', 'ASC')->findAll();
        
        foreach ($teachers as &$teacher) {
            $teacher['assignments'] = $this->teacherAssignmentModel
                ->select('teacher_assignments.*, classes.name as class_name, subjects.name as subject_name')
                ->join('classes', 'classes.id = teacher_assignments.class_id')
                ->join('subjects', 'subjects.id = teacher_assignments.subject_id')
                ->where('teacher_assignments.teacher_id', $teacher['id'])
                ->where('teacher_assignments.academic_year_id', $activeYear['id'])
                ->findAll();
        }

        $data = [
            'title' => 'Monitoring Guru',
            'teachers' => $teachers,
            'activeYear' => $activeYear
        ];

        return view('kepala_sekolah/monitoring_teachers', $data);
    }
}
