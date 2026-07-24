<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuditLogModel;

class AuditLog extends BaseController
{
    protected $auditLogModel;

    public function __construct()
    {
        $this->auditLogModel = new AuditLogModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Audit Logs (Riwayat Aktivitas)',
            'logs'  => $this->auditLogModel->select('audit_logs.*, users.username')
                                           ->join('users', 'users.id = audit_logs.user_id', 'left')
                                           ->orderBy('audit_logs.created_at', 'DESC')
                                           ->paginate(50),
            'pager' => $this->auditLogModel->pager,
        ];

        return view('admin/audit_logs/index', $data);
    }

    public function exportCsv()
    {
        helper('export');
        $logs = $this->auditLogModel->select('audit_logs.*, users.username')
                                    ->join('users', 'users.id = audit_logs.user_id', 'left')
                                    ->orderBy('audit_logs.created_at', 'DESC')
                                    ->findAll();
        
        $header = ['Waktu', 'Pengguna', 'Aksi', 'Detail'];
        $data = [];
        
        foreach ($logs as $row) {
            $data[] = [
                $row['created_at'],
                $row['username'] ?: 'System',
                $row['action'],
                $row['details']
            ];
        }
        
        return export_to_csv('Audit_Logs_' . date('Ymd') . '.csv', $header, $data);
    }

    public function exportPdf()
    {
        helper(['export', 'branding']);
        $logs = $this->auditLogModel->select('audit_logs.*, users.username')
                                    ->join('users', 'users.id = audit_logs.user_id', 'left')
                                    ->orderBy('audit_logs.created_at', 'DESC')
                                    ->findAll();
        
        $data = [
            'title' => 'Riwayat Aktivitas Sistem',
            'logs' => $logs,
            'school' => school_branding()
        ];
        
        return export_to_pdf('exports/audit_log_list', $data, 'Audit_Logs_' . date('Ymd') . '.pdf');
    }
}
