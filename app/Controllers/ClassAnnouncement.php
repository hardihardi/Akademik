<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;
use App\Models\TeacherModel;
use App\Models\TeacherAssignmentModel;
use App\Models\ClassModel;
use App\Models\AuditLogModel;

class ClassAnnouncement extends BaseController
{
    protected $announcementModel;
    protected $teacherModel;
    protected $assignmentModel;
    protected $classModel;
    protected $auditLogModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
        $this->teacherModel = new TeacherModel();
        $this->assignmentModel = new TeacherAssignmentModel();
        $this->classModel = new ClassModel();
        $this->auditLogModel = new AuditLogModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $teacher = $this->teacherModel->where('user_id', $userId)->first();
        
        if (!$teacher) {
            return redirect()->to('/dashboard')->with('error', 'Hanya Guru yang dapat mengakses fitur ini.');
        }

        // Get announcements for classes this teacher is assigned to
        $assignments = $this->assignmentModel->where('teacher_id', $teacher['id'])->findAll();
        $classIds = array_column($assignments, 'class_id');

        if (empty($classIds)) {
            $announcements = [];
        } else {
            $announcements = $this->announcementModel->select('announcements.*, classes.name as class_name')
                ->join('classes', 'classes.id = announcements.class_id', 'left')
                ->whereIn('announcements.class_id', $classIds)
                ->orderBy('announcements.created_at', 'DESC')
                ->findAll();
        }

        $data = [
            'title' => 'Pengumuman Kelas',
            'announcements' => $announcements
        ];

        return view('guru/announcements/index', $data);
    }

    public function create()
    {
        $userId = session()->get('id');
        $teacher = $this->teacherModel->where('user_id', $userId)->first();
        
        if (!$teacher) {
            return redirect()->to('/dashboard')->with('error', 'Hanya Guru yang dapat mengakses fitur ini.');
        }

        // Get classes this teacher is assigned to
        $assignments = $this->assignmentModel->select('classes.*')
            ->join('classes', 'classes.id = teacher_assignments.class_id')
            ->where('teacher_id', $teacher['id'])
            ->groupBy('classes.id')
            ->findAll();

        $data = [
            'title' => 'Buat Pengumuman Kelas',
            'classes' => $assignments,
            'validation' => \Config\Services::validation()
        ];

        return view('guru/announcements/create', $data);
    }

    public function store()
    {
        $userId = session()->get('id');
        $teacher = $this->teacherModel->where('user_id', $userId)->first();

        if (!$this->validate($this->announcementModel->validationRules)) {
            return redirect()->back()->withInput();
        }

        $classId = $this->request->getPost('class_id');
        $title = $this->request->getPost('title');

        $this->announcementModel->save([
            'title' => $title,
            'content' => $this->request->getPost('content'),
            'target_role' => 'student', // Targeted at students/parents of that class
            'author_id' => $userId,
            'class_id' => $classId
        ]);

        // Notify Students in this class
        $db = \Config\Database::connect();
        $students = $db->table('students')->where('class_id', $classId)->get()->getResultArray();
        $studentUserIds = array_filter(array_column($students, 'user_id'));

        if (!empty($studentUserIds)) {
            $notifModel = new \App\Models\NotificationModel();
            $className = $db->table('classes')->where('id', $classId)->get()->getRowArray()['name'] ?? 'Kelas';
            
            $notifModel->notifyUsers(
                $studentUserIds,
                'Pengumuman Kelas Baru: ' . $title,
                "Ada pengumuman baru untuk kelas {$className}.",
                base_url('class-announcements'),
                'announcement'
            );
        }

        $this->auditLogModel->log('create_class_announcement', "Dibuat pengumuman untuk kelas ID: {$classId} - {$title}");

        return redirect()->to('/class-announcements')->with('message', 'Pengumuman kelas berhasil dipublikasikan');
    }

    public function delete($id)
    {
        $userId = session()->get('id');
        $announcement = $this->announcementModel->find($id);

        if ($announcement && $announcement['author_id'] == $userId) {
            $this->announcementModel->delete($id);
            $this->auditLogModel->log('delete_class_announcement', "Dihapus pengumuman ID: {$id}");
            return redirect()->to('/class-announcements')->with('message', 'Pengumuman berhasil dihapus');
        }

        return redirect()->to('/class-announcements')->with('error', 'Anda tidak memiliki akses untuk menghapus pengumuman ini.');
    }
}
