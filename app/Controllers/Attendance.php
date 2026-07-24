<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AttendanceModel;
use App\Models\StudentModel;
use App\Models\ClassModel;
use App\Models\AcademicYearModel;

class Attendance extends BaseController
{
    protected $attendanceModel;
    protected $studentModel;
    protected $classModel;
    protected $academicYearModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->attendanceModel = new AttendanceModel();
        $this->studentModel = new StudentModel();
        $this->classModel = new ClassModel();
        $this->academicYearModel = new AcademicYearModel();
    }

    public function index()
    {
        $search = $this->request->getVar('search');
        $academicYearId = $this->request->getVar('academic_year_id');
        
        $query = $this->classModel;

        if ($search) {
            $query->like('name', $search);
        }

        // Default year selection logic
        if (!$academicYearId) {
            $activeYear = get_active_academic_year();
            if ($activeYear) {
                $academicYearId = $activeYear['id'];
                $query->where('academic_year_id', $academicYearId);
            }

            // Fallback: If no active year or active year has no classes, find the year ID that has classes
            if (!$academicYearId) {
                $mostFrequentYear = $this->db->table('classes')
                                            ->select('academic_year_id, COUNT(*) as count')
                                            ->groupBy('academic_year_id')
                                            ->orderBy('count', 'DESC')
                                            ->get()
                                            ->getRowArray();
                
                if ($mostFrequentYear && !empty($mostFrequentYear['academic_year_id'])) {
                    $academicYearId = $mostFrequentYear['academic_year_id'];
                    $query->where('academic_year_id', $academicYearId);
                }
            }
        } else {
            $query->where('academic_year_id', $academicYearId);
        }

        $classes = $query->findAll();
        $academicYears = $this->academicYearModel->orderBy('year', 'DESC')->findAll();

        $data = [
            'title' => 'Kehadiran Siswa',
            'classes' => $classes,
            'academicYears' => $academicYears,
            'filters' => [
                'search' => $search,
                'academic_year_id' => $academicYearId
            ]
        ];
        return view('academic/attendance/index', $data);
    }

    public function input($classId)
    {
        $date = $this->request->getVar('date') ?? date('Y-m-d');
        
        $class = $this->classModel->find($classId);
        if (!$class) {
            return redirect()->to('/attendance')->with('error', 'Kelas tidak ditemukan');
        }

        // Get students sorted by name
        $students = $this->studentModel->where('class_id', $classId)->orderBy('full_name', 'ASC')->findAll();
        
        // Get existing attendance
        $attendanceRaw = $this->attendanceModel->where('class_id', $classId)->where('date', $date)->findAll();
        
        // Map attendance by student_id
        $attendanceMap = [];
        foreach ($attendanceRaw as $row) {
            $attendanceMap[$row['student_id']] = $row;
        }

        $activeYear = get_active_academic_year();

        $data = [
            'title' => 'Input Kehadiran - ' . $class['name'],
            'class' => $class,
            'date' => $date,
            'students' => $students,
            'attendanceMap' => $attendanceMap,
            'activeYear' => $activeYear
        ];
        return view('academic/attendance/input', $data);
    }

    public function store()
    {
        $classId = $this->request->getVar('class_id');
        $date = $this->request->getVar('date');
        $attendanceData = $this->request->getVar('attendance'); // Array of [student_id => status]
        $verifiedData = $this->request->getVar('verified'); // Array of [student_id => 1]

        if ($attendanceData) {
            $activeYear = get_active_academic_year();
            foreach ($attendanceData as $studentId => $status) {
                // Check if exists
                $exist = $this->attendanceModel->where('student_id', $studentId)
                                                ->where('date', $date)
                                                ->first();
                
                $isVerified = isset($verifiedData[$studentId]) ? 1 : 0;
                // If teacher marks as Hadir, auto verify
                if ($status == 'H') {
                    $isVerified = 1;
                }

                $data = [
                    'student_id' => $studentId,
                    'class_id' => $classId,
                    'date' => $date,
                    'status' => $status,
                    'academic_year_id' => $activeYear['id'] ?? null,
                    'is_verified' => $isVerified
                ];

                if ($exist) {
                     $this->attendanceModel->update($exist['id'], $data);
                } else {
                     $this->attendanceModel->insert($data);
                }

                // Send notification for Sakit, Izin, Alpha
                if (in_array($status, ['S', 'I', 'A'])) {
                    $student = $this->studentModel->find($studentId);
                    if ($student && $student['user_id']) {
                        $notifModel = new \App\Models\NotificationModel();
                        $statusText = [
                            'S' => 'Sakit',
                            'I' => 'Izin',
                            'A' => 'Alpha (Tanpa Keterangan)'
                        ];
                        $label = $statusText[$status] ?? $status;
                        
                        $notifModel->notify(
                            $student['user_id'],
                            'Update Kehadiran: ' . $label,
                            "Ananda " . $student['full_name'] . " tercatat " . $label . " pada tanggal " . date('d M Y', strtotime($date)),
                            base_url('parent/attendance'),
                            'attendance'
                        );
                    }
                }
            }
        }

        return redirect()->to('/attendance')->with('message', 'Kehadiran berhasil disimpan');
    }

    public function submissions()
    {
        $activeYear = get_active_academic_year();
        $ayId = $activeYear['id'] ?? 0;

        $classId = $this->request->getVar('class_id');

        $query = $this->attendanceModel
            ->select('attendance.*, students.full_name as student_name, classes.name as class_name, academic_years.year as academic_year_name, academic_years.semester')
            ->join('students', 'students.id = attendance.student_id')
            ->join('classes', 'classes.id = attendance.class_id')
            ->join('academic_years', 'academic_years.id = attendance.academic_year_id', 'left')
            ->where('attendance.evidence_path IS NOT NULL')
            ->where('attendance.evidence_path !=', '')
            ->where('attendance.is_verified', 0);

        if ($classId) {
            $query->where('attendance.class_id', $classId);
        }

        // We show all pending submissions regardless of year, but ordered by date
        $attendance = $query->orderBy('attendance.date', 'DESC')->findAll();

        $activeYear = get_active_academic_year();

        $data = [
            'title' => 'Persetujuan Izin/Sakit',
            'submissions' => $attendance,
            'activeYear' => $activeYear
        ];
        return view('academic/attendance/submissions', $data);
    }

    public function verify_submission($id)
    {
        $att = $this->attendanceModel->find($id);
        if (!$att) {
            return redirect()->to('attendance/submissions')->with('error', 'Data tidak ditemukan');
        }

        $this->attendanceModel->update($id, ['is_verified' => 1]);

        // Send notification to parent
        $student = $this->studentModel->find($att['student_id']);
        if ($student && $student['user_id']) {
            $notifModel = new \App\Models\NotificationModel();
            $notifModel->notify(
                $student['user_id'],
                'Izin Terverifikasi',
                "Pengajuan izin Ananda " . $student['full_name'] . " untuk tanggal " . date('d M Y', strtotime($att['date'])) . " telah diverifikasi oleh sekolah.",
                base_url('parent/attendance'),
                'attendance'
            );
        }

        return redirect()->to('attendance/submissions')->with('message', 'Pengajuan berhasil diverifikasi');
    }

    public function recap($classId)
    {
        $month = $this->request->getVar('month') ?? date('m');
        $year = $this->request->getVar('year') ?? date('Y');

        $class = $this->classModel->find($classId);
        if (!$class) {
            return redirect()->to('/attendance')->with('error', 'Kelas tidak ditemukan');
        }

        $students = $this->studentModel->where('class_id', $classId)->orderBy('full_name', 'ASC')->findAll();
        
        // Fetch attendance for the whole month
        $startDate = "$year-$month-01";
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $attendanceRaw = $this->attendanceModel
            ->where('class_id', $classId)
            ->where("date >=", $startDate)
            ->where("date <=", $endDate)
            ->findAll();

        // Organize data: [student_id][day] = status
        $attendanceMatrix = [];
        // Initialize summaries
        $summary = [];

        foreach ($students as $student) {
            $attendanceMatrix[$student['id']] = [];
            $summary[$student['id']] = ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0];
        }

        foreach ($attendanceRaw as $row) {
            $day = (int)date('d', strtotime($row['date']));
            $attendanceMatrix[$row['student_id']][$day] = $row['status'];
            
            if (isset($summary[$row['student_id']][$row['status']])) {
                $summary[$row['student_id']][$row['status']]++;
            }
        }

        $data = [
            'title' => 'Rekap Kehadiran - ' . $class['name'],
            'class' => $class,
            'month' => $month,
            'year' => $year,
            'students' => $students,
            'attendanceMatrix' => $attendanceMatrix,
            'summary' => $summary,
            'daysInMonth' => date('t', strtotime($startDate))
        ];

        return view('academic/attendance/recap', $data);
    }
}
