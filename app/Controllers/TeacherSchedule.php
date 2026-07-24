<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ScheduleModel;
use App\Models\TeacherModel;
use App\Models\AcademicYearModel;

class TeacherSchedule extends BaseController
{
    protected $scheduleModel;
    protected $teacherModel;
    protected $academicYearModel;

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
        $this->teacherModel = new TeacherModel();
        $this->academicYearModel = new AcademicYearModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('id');
        
        // Get teacher record
        $teacher = $this->teacherModel->where('user_id', $userId)->first();
        
        if (!$teacher) {
            return redirect()->to('/dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Get filter from request or active year
        $academicYearId = $this->request->getGet('academic_year_id');
        if (!$academicYearId) {
            $activeYear = $this->academicYearModel->where('status', 'Active')->first();
            $academicYearId = $activeYear ? $activeYear['id'] : null;
        }

        // Fetch all academic years for filter
        $academicYears = $this->academicYearModel->orderBy('year', 'DESC')->orderBy('semester', 'DESC')->findAll();

        // Get Teaching Schedule
        $scheduleQuery = $db->table('schedules')
                                       ->select('schedules.*, classes.name as class_name, subjects.name as subject_name')
                                       ->join('classes', 'classes.id = schedules.class_id')
                                       ->join('subjects', 'subjects.id = schedules.subject_id')
                                       ->where('schedules.teacher_id', $teacher['id']);
        
        if ($academicYearId) {
            $scheduleQuery->where('schedules.academic_year_id', $academicYearId);
        }

        $schedules = $scheduleQuery->orderBy('FIELD(day, "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu")')
                                       ->orderBy('start_time', 'ASC')
                                       ->get()->getResultArray();

        // Group by Day
        $groupedSchedules = [];
        foreach ($schedules as $sch) {
            $groupedSchedules[$sch['day']][] = $sch;
        }

        $data = [
            'title' => 'Jadwal Mengajar Saya',
            'teacher' => $teacher,
            'groupedSchedules' => $groupedSchedules,
            'academicYears' => $academicYears,
            'selectedYearId' => $academicYearId,
            'activeYear' => $this->academicYearModel->where('id', $academicYearId)->first()
        ];

        return view('guru/schedule/index', $data);
    }
}
