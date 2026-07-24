<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TeacherModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Teacher extends BaseController
{
    protected $teacherModel;
    protected $userModel;

    public function __construct()
    {
        $this->teacherModel = new TeacherModel();
        $this->userModel = new UserModel();
        $this->auditLogModel = new \App\Models\AuditLogModel();
    }

    public function index()
    {
        $search = $this->request->getVar('search');
        $statusFilter = $this->request->getVar('status');

        $query = $this->teacherModel;

        if ($search) {
            $query->groupStart()
                  ->like('full_name', $search)
                  ->orLike('nip', $search)
                  ->orLike('nuptk', $search)
                  ->groupEnd();
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $data = [
            'title' => 'Data Guru',
            'teachers' => $query->paginate(10, 'teachers'),
            'pager' => $this->teacherModel->pager,
            'filters' => [
                'search' => $search,
                'status' => $statusFilter
            ]
        ];
        return view('admin/teachers/index', $data);
    }

    public function show($id = null)
    {
        $teacher = $this->teacherModel->find($id);
        if (!$teacher) {
            throw new PageNotFoundException('Data guru tidak ditemukan: ' . $id);
        }

        $assignmentModel = new \App\Models\TeacherAssignmentModel();
        $academicYearModel = new \App\Models\AcademicYearModel();
        
        $activeYear = $academicYearModel->getActiveYear();
        
        // Current assignments
        $currentAssignments = $assignmentModel->select('teacher_assignments.*, classes.name as class_name, subjects.name as subject_name')
            ->join('classes', 'classes.id = teacher_assignments.class_id')
            ->join('subjects', 'subjects.id = teacher_assignments.subject_id')
            ->where('teacher_assignments.teacher_id', $id)
            ->where('teacher_assignments.academic_year_id', $activeYear['id'] ?? 0)
            ->findAll();

        // Teaching History
        $history = $assignmentModel->select('teacher_assignments.*, classes.name as class_name, subjects.name as subject_name, academic_years.year, academic_years.semester')
            ->join('classes', 'classes.id = teacher_assignments.class_id')
            ->join('subjects', 'subjects.id = teacher_assignments.subject_id')
            ->join('academic_years', 'academic_years.id = teacher_assignments.academic_year_id')
            ->where('teacher_assignments.teacher_id', $id)
            ->orderBy('academic_years.year', 'DESC')
            ->orderBy('academic_years.semester', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Profil Guru - ' . $teacher['full_name'],
            'teacher' => $teacher,
            'currentAssignments' => $currentAssignments,
            'history' => $history,
            'activeYear' => $activeYear
        ];
        
        return view('admin/teachers/show', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Guru',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/teachers/create', $data);
    }

    public function create()
    {
        $rules = $this->teacherModel->getValidationRules();
        $rules['teacher_photo'] = 'if_exist|is_image[teacher_photo]|max_size[teacher_photo,1024]';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Create user account for teacher automatically
        $username = strtolower(str_replace(' ', '', $this->request->getVar('full_name')));
        $password = 'guru123'; // Default password

        $userId = $this->userModel->insert([
            'username' => $username,
            'full_name' => $this->request->getVar('full_name'),
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'role' => 'guru',
            'active' => 1
        ]);

        $data = [
            'user_id' => $userId,
            'nip' => $this->request->getVar('nip'),
            'nuptk' => $this->request->getVar('nuptk'),
            'religion' => $this->request->getVar('religion'),
            'full_name' => $this->request->getVar('full_name'),
            'phone' => $this->request->getVar('phone'),
            'address' => $this->request->getVar('address'),
            'status' => $this->request->getVar('status') ?: 'Aktif',
        ];

        // Handle Photo Upload
        $photo = $this->request->getFile('teacher_photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/teachers', $newName);
            $data['photo'] = 'uploads/teachers/' . $newName;
        }

        if (!$this->teacherModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', ['Gagal menyimpan data guru.']);
        }

        // Audit Log
        $this->auditLogModel->log('create_teacher', "Ditambahkan guru baru: {$data['full_name']} (NIP: {$data['nip']})");

        return redirect()->to('/teachers')->with('message', 'Data guru berhasil ditambahkan. Username: ' . $username . ', Password: ' . $password);
    }

    public function edit($id = null)
    {
        $teacher = $this->teacherModel->find($id);
        if (!$teacher) {
            throw new PageNotFoundException('Data guru tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Edit Guru',
            'teacher' => $teacher,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/teachers/edit', $data);
    }

    public function update($id)
    {
        $rules = $this->teacherModel->getValidationRules();
        $rules['nip'] = str_replace('{id}', $id, $rules['nip']);
        if (isset($rules['nuptk'])) {
            $rules['nuptk'] = str_replace('{id}', $id, $rules['nuptk']);
        }
        $rules['teacher_photo'] = 'if_exist|is_image[teacher_photo]|max_size[teacher_photo,1024]';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nip' => $this->request->getVar('nip'),
            'nuptk' => $this->request->getVar('nuptk'),
            'religion' => $this->request->getVar('religion'),
            'full_name' => $this->request->getVar('full_name'),
            'phone' => $this->request->getVar('phone'),
            'address' => $this->request->getVar('address'),
            'status' => $this->request->getVar('status'),
        ];

        // Handle Photo Upload
        $photo = $this->request->getFile('teacher_photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $teacher = $this->teacherModel->find($id);
            // Delete old photo if exists
            if ($teacher && !empty($teacher['photo'])) {
                if (file_exists(FCPATH . $teacher['photo'])) {
                    @unlink(FCPATH . $teacher['photo']);
                }
            }

            $newName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/teachers', $newName);
            $data['photo'] = 'uploads/teachers/' . $newName;
        }

        if (!$this->teacherModel->skipValidation(true)->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', ['Gagal memperbarui data guru.']);
        }

        // Sync with users table
        $teacher = $this->teacherModel->find($id);
        if ($teacher && $teacher['user_id']) {
            $this->userModel->update($teacher['user_id'], [
                'full_name' => $data['full_name']
            ]);
        }

        // Audit Log
        $this->auditLogModel->log('update_teacher', "Diperbarui data guru ID: {$id} - {$data['full_name']} (NIP: {$data['nip']})");

        return redirect()->to('/teachers')->with('message', 'Data guru berhasil diupdate');
    }

    public function delete($id)
    {
        $teacher = $this->teacherModel->find($id);
        if (!$teacher) {
            throw new PageNotFoundException('Data guru tidak ditemukan: ' . $id);
        }

        if ($teacher['user_id']) {
            $this->userModel->delete($teacher['user_id']); // Delete associated user account
        }

        $this->teacherModel->delete($id);

        // Audit Log
        $this->auditLogModel->log('delete_teacher', "Dihapus data guru: {$teacher['full_name']} (ID: {$id})");

        return redirect()->to('/teachers')->with('message', 'Data guru berhasil dihapus');
    }

    public function exportCsv()
    {
        helper('export');
        $teachers = $this->teacherModel->findAll();
        
        $header = ['NIP', 'NUPTK', 'Agama', 'Nama Lengkap', 'Telepon', 'Alamat', 'Status'];
        $data = [];
        
        foreach ($teachers as $row) {
            $data[] = [
                $row['nip'],
                $row['nuptk'] ?: '-',
                $row['religion'] ?: '-',
                $row['full_name'],
                $row['phone'] ?: '-',
                $row['address'] ?: '-',
                $row['status']
            ];
        }
        
        return export_to_csv('Data_Guru_' . date('Ymd') . '.csv', $header, $data);
    }

    public function exportPdf()
    {
        helper(['export', 'branding']);
        $teachers = $this->teacherModel->findAll();
        
        $data = [
            'title' => 'Daftar Seluruh Guru',
            'teachers' => $teachers,
            'school' => school_branding()
        ];
        
        return export_to_pdf('exports/teacher_list', $data, 'Data_Guru_' . date('Ymd') . '.pdf');
    }
}
