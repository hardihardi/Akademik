<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\ClassModel;
use App\Models\AttendanceModel;
use App\Models\AcademicYearModel;

class AttendanceRecap extends BaseController
{
    protected $studentModel;
    protected $classModel;
    protected $attendanceModel;
    protected $academicYearModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->studentModel = new StudentModel();
        $this->classModel = new ClassModel();
        $this->attendanceModel = new AttendanceModel();
        $this->academicYearModel = new AcademicYearModel();
    }

    public function index()
    {
        $search = $this->request->getVar('search');
        $activeYear = get_active_academic_year();
        $query = $this->classModel;
        
        if ($activeYear) {
            $query->where('academic_year_id', $activeYear['id']);
        }

        if ($search) {
            $query->like('name', $search);
        }

        $data = [
            'title' => 'Rekap Absensi Kelas',
            'classes' => $query->findAll(),
            'activeYear' => $activeYear,
            'filters' => [
                'search' => $search
            ]
        ];
        return view('academic/attendance/recap_index', $data);
    }

    public function view($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class) {
            return redirect()->to('/attendance-recap')->with('error', 'Kelas tidak ditemukan.');
        }
        $academicYearId = $class['academic_year_id'] ?? null;
        $activeYear = $academicYearId ? $this->academicYearModel->find($academicYearId) : $this->academicYearModel->getActiveYear();

        if (!$activeYear) {
            return redirect()->back()->with('error', 'Tahun Akademik Aktif belum diset.');
        }

        $students = $this->studentModel->where('class_id', $classId)->orderBy('full_name', 'ASC')->findAll();
        
        // Fetch all attendance for this class in this semester/year? 
        // Attendance table doesn't have 'semester' column explicitly, strictly speaking it's by date.
        // But for this MVP we can filter by date range if we had semester dates.
        // For now, we will fetch ALL attendance for these students. 
        // In a real app, we would filter by the start/end date of the Academic Year.
        // Let's assume we fetch all for now or maybe just filter by current active year if we had dates.
        
        $totalClassH = 0;
        $totalClassI = 0;
        $totalClassS = 0;
        $totalClassA = 0;

        foreach ($students as $student) {
            $stats = $this->attendanceModel->where('student_id', $student['id'])
                                          ->where('academic_year_id', $activeYear['id'])
                                          ->findAll();
            $summary = ['H' => 0, 'I' => 0, 'S' => 0, 'A' => 0];
            foreach ($stats as $s) {
                 if (isset($summary[$s['status']])) {
                     $summary[$s['status']]++;
                 }
            }
            
            $totalClassH += $summary['H'];
            $totalClassI += $summary['I'];
            $totalClassS += $summary['S'];
            $totalClassA += $summary['A'];

            // Calculate percentage?
            $total = array_sum($summary);
            $percentage = $total > 0 ? round(($summary['H'] / $total) * 100, 1) : 0;
            
            $attendanceStats[$student['id']] = [
                'summary' => $summary,
                'total' => $total,
                'percentage' => $percentage
            ];
        }

        $data = [
            'title' => 'Rekap Absensi - Kelas ' . $class['name'],
            'class' => $class,
            'year' => $activeYear,
            'students' => $students,
            'attendanceStats' => $attendanceStats,
            'totalClassH' => $totalClassH,
            'totalClassI' => $totalClassI,
            'totalClassS' => $totalClassS,
            'totalClassA' => $totalClassA
        ];

        return view('academic/attendance/recap_view', $data);
    }

    public function pdf($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class) {
            return redirect()->to('/attendance-recap')->with('error', 'Kelas tidak ditemukan.');
        }
        $academicYearId = $class['academic_year_id'] ?? null;
        $activeYear = $academicYearId ? $this->academicYearModel->find($academicYearId) : $this->academicYearModel->getActiveYear();

        if (!$activeYear) {
            return redirect()->back()->with('error', 'Tahun Akademik Aktif belum diset.');
        }

        $students = $this->studentModel->where('class_id', $classId)->orderBy('full_name', 'ASC')->findAll();
        
        $totalClassH = 0; $totalClassI = 0; $totalClassS = 0; $totalClassA = 0;
        $attendanceStats = [];

        foreach ($students as $student) {
            $stats = $this->attendanceModel->where('student_id', $student['id'])
                                          ->where('academic_year_id', $activeYear['id'])
                                          ->findAll();
            $summary = ['H' => 0, 'I' => 0, 'S' => 0, 'A' => 0];
            foreach ($stats as $s) {
                 if (isset($summary[$s['status']])) {
                     $summary[$s['status']]++;
                 }
            }
            
            $totalClassH += $summary['H'];
            $totalClassI += $summary['I'];
            $totalClassS += $summary['S'];
            $totalClassA += $summary['A'];

            $total = array_sum($summary);
            $percentage = $total > 0 ? round(($summary['H'] / $total) * 100, 1) : 0;
            
            $attendanceStats[$student['id']] = [
                'summary' => $summary,
                'total' => $total,
                'percentage' => $percentage
            ];
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
            'title' => 'Laporan Rekapitulasi Absensi',
            'class' => $class,
            'year' => $activeYear,
            'students' => $students,
            'attendanceStats' => $attendanceStats,
            'totalClassH' => $totalClassH, 'totalClassI' => $totalClassI, 'totalClassS' => $totalClassS, 'totalClassA' => $totalClassA,
            'school_name' => $brand['name'],
            'school_address' => $brand['address'],
            'school_city' => $brand['city'],
            'school_logo' => ($brand['logo_raw'] && file_exists(FCPATH . $brand['logo_raw'])) ? str_replace('\\', '/', FCPATH . $brand['logo_raw']) : null,
            'headmaster' => $brand['headmaster'],
            'headmaster_nip' => $brand['headmaster_nip'],
            'headmaster_signature' => ($brand['signature_raw'] && file_exists(FCPATH . $brand['signature_raw'])) ? str_replace('\\', '/', FCPATH . $brand['signature_raw']) : null,
            'homeroom' => $homeroom['full_name'] ?? '____________________',
            'homeroom_nip' => $homeroom['nip'] ?? '-'
        ];

        $html = view('academic/attendance/pdf_template', $data);
        $dompdf = new \Dompdf\Dompdf([
            'isRemoteEnabled' => false,
            'chroot' => str_replace('\\', '/', FCPATH),
            'isHtml5ParserEnabled' => true,
            'isFontSubsettingEnabled' => true,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $this->response->setHeader('Content-Type', 'application/pdf')
                              ->setBody($dompdf->output());
    }
}
