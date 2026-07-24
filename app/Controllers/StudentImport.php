<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\ClassModel;
use App\Models\UserModel;
use App\Models\AuditLogModel;

class StudentImport extends BaseController
{
    protected $studentModel;
    protected $classModel;
    protected $userModel;
    protected $auditLogModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->classModel = new ClassModel();
        $this->userModel = new UserModel();
        $this->auditLogModel = new AuditLogModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Import Data Siswa',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/students/import', $data);
    }

    public function downloadTemplate()
    {
        $filename = 'template_import_siswa.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        // CSV Header
        fputcsv($output, ['nis', 'nisn', 'full_name', 'nickname', 'gender', 'birth_place', 'birth_date', 'address', 'parent_name', 'parent_phone', 'class_name']);
        
        // Sample Row
        fputcsv($output, ['12345', '0012345678', 'Budi Santoso', 'Budi', 'L', 'Jakarta', '2015-05-20', 'Jl. Merdeka No. 1', 'Slamet', '08123456789', '1-A']);
        
        fclose($output);
        exit;
    }

    public function process()
    {
        $file = $this->request->getFile('csv_file');

        if (!$file || !$file->isValid() || $file->getExtension() !== 'csv') {
            return redirect()->back()->with('error', 'Silakan unggah file CSV yang valid.');
        }

        $handle = fopen($filePath, 'r');
        
        // Detect delimiter
        $firstLine = fgets($handle);
        $delimiter = (strpos($firstLine, ';') !== false) ? ';' : ',';
        rewind($handle);
        
        // Skip header
        $header = fgetcsv($handle, 1000, $delimiter);
        
        $successCount = 0;
        $errorCount = 0;
        $errors = [];
        $rowNum = 1;

        // Map class names to IDs for efficiency
        $classesRaw = $this->classModel->findAll();
        $classMap = [];
        foreach ($classesRaw as $c) {
            $classMap[strtolower(trim($c['name']))] = $c['id'];
        }

        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
            $rowNum++;
            if (empty(array_filter($row))) continue; // Skip empty rows
            
            if (count($row) < 11) {
                $errors[] = "Baris {$rowNum}: Kolom tidak lengkap (Minimal 11 kolom).";
                $errorCount++;
                continue;
            }

            $data = [
                'nis'          => trim($row[0]),
                'nisn'         => trim($row[1]),
                'full_name'    => trim($row[2]),
                'nickname'     => trim($row[3]),
                'gender'       => trim($row[4]),
                'birth_place'  => trim($row[5]),
                'birth_date'   => trim($row[6]),
                'address'      => trim($row[7]),
                'parent_name'  => trim($row[8]),
                'parent_phone' => trim($row[9]),
                'status'       => 'Aktif'
            ];

            $className = strtolower(trim($row[10]));
            $classId = $classMap[$className] ?? null;

            if (!$classId) {
                $errors[] = "Baris {$rowNum}: Kelas '{$row[10]}' tidak ditemukan.";
                $errorCount++;
                continue;
            }

            $data['class_id'] = $classId;

            // Simple validation
            if (empty($data['nis']) || empty($data['full_name'])) {
                $errors[] = "Baris {$rowNum}: NIS dan Nama Lengkap wajib diisi.";
                $errorCount++;
                continue;
            }

            // Check if student already exists
            if ($this->studentModel->where('nis', $data['nis'])->countAllResults() > 0) {
                $errors[] = "Baris {$rowNum}: Siswa dengan NIS {$data['nis']} sudah terdaftar.";
                $errorCount++;
                continue;
            }

            if ($this->studentModel->save($data)) {
                $successCount++;
            } else {
                $errorCount++;
                $dbErrors = $this->studentModel->errors();
                $errors[] = "Baris {$rowNum}: " . implode(', ', $dbErrors);
            }
        }

        fclose($handle);

        if ($successCount > 0) {
            $this->auditLogModel->log('import_students', "Berhasil import {$successCount} data siswa via CSV.");
        }

        $msg = "Import selesai. Berhasil: {$successCount}, Gagal: {$errorCount}.";
        return redirect()->to('/students')->with('message', $msg)->with('import_errors', $errors);
    }
}
