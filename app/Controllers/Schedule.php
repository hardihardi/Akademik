<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ScheduleModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\AcademicYearModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Schedule extends BaseController
{
    protected $scheduleModel;
    protected $classModel;
    protected $subjectModel;
    protected $academicYearModel;

    public function __construct()
    {
        $this->scheduleModel     = new ScheduleModel();
        $this->classModel        = new ClassModel();
        $this->subjectModel      = new SubjectModel();
        $this->academicYearModel = new AcademicYearModel();
    }

    public function index()
    {
        $classId        = $this->request->getGet('class_id');
        $academicYearId = $this->request->getGet('academic_year_id');
        $activeYear     = $this->academicYearModel->where('status', 'Active')->first();

        if (!$academicYearId && $activeYear) {
            $academicYearId = $activeYear['id'];
        }

        // Full list for Timetable Roster view
        $allSchedules = $this->scheduleModel->getSchedulesWithRelations(
            $classId ? (int) $classId : null,
            $academicYearId ? (int) $academicYearId : null
        );

        // Paginated list for Manage Table view
        $schedules = $this->scheduleModel->getSchedulesWithRelationsBuilder(
            $classId ? (int) $classId : null,
            $academicYearId ? (int) $academicYearId : null
        )->paginate(10);

        // Group schedules by day for timetable view
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $groupedSchedules = [];
        foreach ($days as $day) {
            $groupedSchedules[$day] = array_filter($allSchedules, fn($s) => $s['day'] === $day);
        }

        $data = [
            'title'            => 'Jadwal Pelajaran',
            'schedules'        => $schedules,
            'groupedSchedules' => $groupedSchedules,
            'days'             => $days,
            'classes'          => $this->classModel->findAll(),
            'academicYears'    => $this->academicYearModel->findAll(),
            'selectedClass'    => $classId,
            'selectedYear'     => $academicYearId,
            'activeYear'       => $activeYear,
            'pager'            => $this->scheduleModel->pager,
        ];

        return view('admin/schedules/index', $data);
    }

    public function create()
    {
        $activeYear = $this->academicYearModel->where('status', 'Active')->first();

        // Get teachers from db
        $db = \Config\Database::connect();
        $teachers = $db->table('teachers')->select('id, full_name')->get()->getResultArray();

        $data = [
            'title'         => 'Tambah Jadwal',
            'classes'       => $this->classModel->findAll(),
            'subjects'      => $this->subjectModel->findAll(),
            'teachers'      => $teachers,
            'academicYears' => $this->academicYearModel->findAll(),
            'activeYear'    => $activeYear,
            'validation'    => \Config\Services::validation(),
        ];

        return view('admin/schedules/create', $data);
    }

    public function store()
    {
        if (!$this->validate($this->scheduleModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Periksa kembali data yang diinput.');
        }

        $classId   = $this->request->getVar('class_id');
        $day       = $this->request->getVar('day');
        $startTime = $this->request->getVar('start_time');
        $endTime   = $this->request->getVar('end_time');

        // Check for time conflicts
        if ($this->scheduleModel->hasConflict((int) $classId, $day, $startTime, $endTime)) {
            return redirect()->back()->withInput()->with('error', 'Jadwal bentrok! Sudah ada pelajaran pada jam tersebut di kelas yang sama.');
        }

        $this->scheduleModel->save([
            'class_id'         => $classId,
            'subject_id'       => $this->request->getVar('subject_id'),
            'teacher_id'       => $this->request->getVar('teacher_id'),
            'academic_year_id' => $this->request->getVar('academic_year_id'),
            'day'              => $day,
            'start_time'       => $startTime,
            'end_time'         => $endTime,
            'room'             => $this->request->getVar('room'),
        ]);

        return redirect()->to('/schedules')->with('message', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $schedule = $this->scheduleModel->find($id);
        if (!$schedule) {
            throw new PageNotFoundException('Data jadwal tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $teachers = $db->table('teachers')->select('id, full_name')->get()->getResultArray();

        $data = [
            'title'         => 'Edit Jadwal',
            'schedule'      => $schedule,
            'classes'       => $this->classModel->findAll(),
            'subjects'      => $this->subjectModel->findAll(),
            'teachers'      => $teachers,
            'academicYears' => $this->academicYearModel->findAll(),
            'validation'    => \Config\Services::validation(),
        ];

        return view('admin/schedules/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate($this->scheduleModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal.');
        }

        $classId   = $this->request->getVar('class_id');
        $day       = $this->request->getVar('day');
        $startTime = $this->request->getVar('start_time');
        $endTime   = $this->request->getVar('end_time');

        if ($this->scheduleModel->hasConflict((int) $classId, $day, $startTime, $endTime, (int) $id)) {
            return redirect()->back()->withInput()->with('error', 'Jadwal bentrok! Sudah ada pelajaran pada jam tersebut di kelas yang sama.');
        }

        $this->scheduleModel->update($id, [
            'class_id'         => $classId,
            'subject_id'       => $this->request->getVar('subject_id'),
            'teacher_id'       => $this->request->getVar('teacher_id'),
            'academic_year_id' => $this->request->getVar('academic_year_id'),
            'day'              => $day,
            'start_time'       => $startTime,
            'end_time'         => $endTime,
            'room'             => $this->request->getVar('room'),
        ]);

        return redirect()->to('/schedules')->with('message', 'Jadwal berhasil diupdate.');
    }

    public function delete($id)
    {
        $this->scheduleModel->delete($id);
        return redirect()->to('/schedules')->with('message', 'Jadwal berhasil dihapus.');
    }
}
