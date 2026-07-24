<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Notification extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $notifications = $this->notificationModel->where('user_id', $userId)
                                                 ->orderBy('created_at', 'DESC')
                                                 ->findAll();

        $data = [
            'title'         => 'Notifikasi',
            'notifications' => $notifications,
        ];

        return view('admin/notifications/index', $data);
    }

    public function read($id)
    {
        $userId = session()->get('id');
        $notification = $this->notificationModel->where('id', $id)
                                                ->where('user_id', $userId)
                                                ->first();

        if (!$notification) {
            throw new PageNotFoundException('Notifikasi tidak ditemukan.');
        }

        $this->notificationModel->update($id, ['is_read' => 1]);

        if ($notification['link']) {
            return redirect()->to($notification['link']);
        }

        return redirect()->to('/notifications');
    }

    public function readAll()
    {
        $userId = session()->get('id');
        $this->notificationModel->where('user_id', $userId)
                                ->where('is_read', 0)
                                ->set(['is_read' => 1])
                                ->update();

        return redirect()->to('/notifications')->with('message', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    public function delete($id)
    {
        $userId = session()->get('id');
        $this->notificationModel->where('id', $id)
                                ->where('user_id', $userId)
                                ->delete();

        return redirect()->to('/notifications')->with('message', 'Notifikasi berhasil dihapus.');
    }
}
