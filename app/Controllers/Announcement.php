<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;
use App\Models\ClassModel;

class Announcement extends BaseController
{
    protected $announcementModel;
    protected $classModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
        $this->classModel = new ClassModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pengumuman',
            'announcements' => $this->announcementModel->orderBy('created_at', 'DESC')->paginate(5, 'announcements'),
            'pager' => $this->announcementModel->pager
        ];
        return view('admin/announcements/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Buat Pengumuman Baru',
            'classes' => $this->classModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/announcements/create', $data);
    }

    public function store()
    {
        if (!$this->validate($this->announcementModel->validationRules)) {
            return redirect()->back()->withInput();
        }

        $this->announcementModel->save([
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'target_role' => $this->request->getPost('target_role'),
            'class_id' => $this->request->getPost('class_id') ?: null,
            'author_id' => session()->get('id'),
        ]);

        // Notify Users based on target_role
        $targetRole = $this->request->getPost('target_role');
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        
        if ($targetRole !== 'all') {
            $builder->where('role', $targetRole);
        }
        
        $users = $builder->select('id')->get()->getResultArray();
        $userIds = array_column($users, 'id');

        if (!empty($userIds)) {
            $notifModel = new \App\Models\NotificationModel();
            $notifModel->notifyUsers(
                $userIds,
                'Pengumuman Baru: ' . $this->request->getPost('title'),
                'Ada pengumuman baru untuk Anda. Silakan cek detailnya.',
                base_url('announcements'),
                'announcement'
            );
        }

        return redirect()->to('/announcements')->with('message', 'Pengumuman berhasil dibuat');
    }

    public function edit($id)
    {
        $announcement = $this->announcementModel->find($id);
        if (!$announcement) {
            return redirect()->to('/announcements')->with('error', 'Pengumuman tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pengumuman',
            'announcement' => $announcement,
            'classes' => $this->classModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/announcements/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate($this->announcementModel->validationRules)) {
            return redirect()->back()->withInput();
        }

        $this->announcementModel->update($id, [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'target_role' => $this->request->getPost('target_role'),
            'class_id' => $this->request->getPost('class_id') ?: null,
        ]);

        // Notify Users about update
        $targetRole = $this->request->getPost('target_role');
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        if ($targetRole !== 'all') {
            $builder->where('role', $targetRole);
        }
        $users = $builder->select('id')->get()->getResultArray();
        $userIds = array_column($users, 'id');

        if (!empty($userIds)) {
            $notifModel = new \App\Models\NotificationModel();
            $notifModel->notifyUsers(
                $userIds,
                'Update Pengumuman: ' . $this->request->getPost('title'),
                'Ada perubahan pada pengumuman. Silakan cek informasi terbaru.',
                base_url('announcements'),
                'announcement'
            );
        }

        return redirect()->to('/announcements')->with('message', 'Pengumuman berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->announcementModel->delete($id);
        return redirect()->to('/announcements')->with('message', 'Pengumuman berhasil dihapus');
    }
}
