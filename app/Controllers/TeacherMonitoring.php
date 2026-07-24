<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AttendanceModel;
use App\Models\TeacherModel;
use App\Models\HomeroomAssignmentModel;
use App\Models\StudentModel;
use App\Models\AcademicYearModel;

class TeacherMonitoring extends BaseController
{
    protected $attendanceModel;
    protected $teacherModel;
    protected $homeroomModel;
    protected $studentModel;
    protected $academicYearModel;

    public function __construct()
    {
        $this->attendanceModel = new AttendanceModel();
        $this->teacherModel = new TeacherModel();
        $this->homeroomModel = new HomeroomAssignmentModel();
        $this->studentModel = new StudentModel();
        $this->academicYearModel = new AcademicYearModel();
    }

    public function attendanceRecap()
    {
        $userId = session()->get('id');
        $teacher = $this->teacherModel->where('user_id', $userId)->first();
        
        if (!$teacher) {
            return redirect()->to('/dashboard')->with('error', 'Hanya Guru yang dapat mengakses fitur ini.');
        }

        // Get the class where this teacher is a homeroom teacher
        $homeroom = $this->homeroomModel->select('classes.id, classes.name')
                                          ->join('classes', 'classes.id = homeroom_assignments.class_id')
                                          ->where('teacher_id', $teacher['id'])
                                          ->first();

        if (!$homeroom) {
            return view('guru/monitoring/no_homeroom', ['title' => 'Rekap Absensi']);
        }

        $month = $this->request->getGet('month') ?: date('m');
        $year = $this->request->getGet('year') ?: date('Y');

        // Fetch students in this class
        $students = $this->studentModel->where('class_id', $homeroom['id'])->orderBy('full_name', 'ASC')->findAll();

        // Fetch attendance for the selected month
        $attendanceData = $this->attendanceModel->where('class_id', $homeroom['id'])
                                                ->where('MONTH(date)', $month)
                                                ->where('YEAR(date)', $year)
                                                ->findAll();

        // Organize attendance for easier display: [student_id][day] = status
        $mappedAttendance = [];
        foreach ($attendanceData as $att) {
            $day = (int)date('d', strtotime($att['date']));
            $mappedAttendance[$att['student_id']][$day] = $att['status'];
        }

        $data = [
            'title' => 'Rekap Absensi - ' . $homeroom['name'],
            'homeroom' => $homeroom,
            'students' => $students,
            'mappedAttendance' => $mappedAttendance,
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'daysInMonth' => cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year)
        ];

        return view('guru/monitoring/attendance_recap', $data);
    }
}
