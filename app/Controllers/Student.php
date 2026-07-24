<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\ClassModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Student extends BaseController
{
    protected $studentModel;
    protected $classModel;
    protected $userModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->classModel = new ClassModel();
        $this->userModel = new \App\Models\UserModel();
        $this->auditLogModel = new \App\Models\AuditLogModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('id');
        
        $search = $this->request->getVar('search');
        $classId = $this->request->getVar('class_id');
        $statusFilter = $this->request->getVar('status');
        $type = $this->request->getVar('type') ?: 'subjects'; // Default to subjects for teachers

        $query = $this->studentModel->select('students.*, classes.name as class_name, users.username as parent_account')
                                     ->join('classes', 'classes.id = students.class_id', 'left')
                                     ->join('users', 'users.id = students.user_id', 'left');

        if ($search) {
            $query->groupStart()
                  ->like('students.full_name', $search)
                  ->orLike('students.nis', $search)
                  ->orLike('students.nisn', $search)
                  ->groupEnd();
        }

        if ($classId) {
            $query->where('students.class_id', $classId);
        }

        if ($statusFilter) {
            $query->where('students.status', $statusFilter);
        }

        $teacherInfo = null;
        if ($role == 'guru' || $role == 'wali_kelas') {
            $teacherModel = new \App\Models\TeacherModel();
            $teacherInfo = $teacherModel->where('user_id', $userId)->first();
            
            if ($teacherInfo) {
                $homeroomModel = new \App\Models\HomeroomAssignmentModel();
                $assignmentModel = new \App\Models\TeacherAssignmentModel();
                
                $homeroomClasses = $homeroomModel->where('teacher_id', $teacherInfo['id'])->findAll();
                $subjectClasses = $assignmentModel->where('teacher_id', $teacherInfo['id'])->findAll();
                
                if ($type == 'homeroom') {
                    $classIds = array_column($homeroomClasses, 'class_id');
                } else {
                    $classIds = array_column($subjectClasses, 'class_id');
                }

                if (!empty($classIds)) {
                    $query->whereIn('students.class_id', $classIds);
                } else {
                    $query->where('1=0');
                }
            } else {
                $query->where('1=0');
            }
        }

        $data = [
            'title' => 'Data Siswa',
            'students' => $query->paginate(10, 'students'),
            'pager' => $this->studentModel->pager,
            'classes' => $this->classModel->findAll(),
            'filters' => [
                'search' => $search,
                'class_id' => $classId,
                'status' => $statusFilter,
                'type' => $type
            ],
            'teacherInfo' => $teacherInfo
        ];
        return view('admin/students/index', $data);
    }

    public function show($id = null)
    {
        $student = $this->studentModel->select('students.*, classes.name as class_name, users.username as parent_account')
                                      ->join('classes', 'classes.id = students.class_id', 'left')
                                      ->join('users', 'users.id = students.user_id', 'left')
                                      ->find($id);

        if (!$student) {
            throw new PageNotFoundException('Data siswa tidak ditemukan: ' . $id);
        }

        // Fetch additional data like grades for the profile
        $academicYearModel = new \App\Models\AcademicYearModel();
        $attendanceModel = new \App\Models\AttendanceModel();
        $historyModel = new \App\Models\StudentClassHistoryModel();
        
        $activeYear = $academicYearModel->getActiveYear();

        $data = [
            'title' => 'Profil Siswa - ' . $student['full_name'],
            'student' => $student,
            'activeYear' => $activeYear,
            'attendanceStats' => $attendanceModel
                ->select('status, COUNT(*) as count')
                ->where('student_id', $id)
                ->groupBy('status')
                ->findAll(),
            'history' => $historyModel->getHistoryByStudent($id)
        ];
        
        return view('admin/students/show', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Siswa',
            'classes' => $this->classModel->findAll(), 
            'parents' => $this->userModel->getParents(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/students/create', $data);
    }

    public function create()
    {
        $rules = $this->studentModel->getValidationRules();
        $rules['student_photo'] = 'if_exist|is_image[student_photo]|max_size[student_photo,1024]';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'nis' => $this->request->getVar('nis'),
            'nisn' => $this->request->getVar('nisn'),
            'full_name' => $this->request->getVar('full_name'),
            'gender' => $this->request->getVar('gender'),
            'religion' => $this->request->getVar('religion'),
            'birth_place' => $this->request->getVar('birth_place'),
            'birth_date' => $this->request->getVar('birth_date'),
            'address' => $this->request->getVar('address'),
            'parent_name' => $this->request->getVar('parent_name'),
            'parent_phone' => $this->request->getVar('parent_phone'),
            'class_id' => $this->request->getVar('class_id') ?: null,
            'user_id' => $this->request->getVar('user_id') ?: null,
            'status' => $this->request->getVar('status') ?: 'Aktif',
        ];

        // Handle Photo Upload
        $photo = $this->request->getFile('student_photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/students', $newName);
            $data['photo'] = 'uploads/students/' . $newName;
        }

        if (!$this->studentModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', ['Gagal menambahkan siswa ke database.']);
        }

        // Audit Log
        $this->auditLogModel->log('create_student', "Ditambahkan siswa baru: {$data['full_name']} (NIS: {$data['nis']})");

        return redirect()->to('/students')->with('message', 'Data siswa berhasil ditambahkan');
    }

    public function edit($id = null)
    {
        $student = $this->studentModel->find($id);
        if (!$student) {
            throw new PageNotFoundException('Data siswa tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Edit Siswa',
            'student' => $student,
            'classes' => $this->classModel->findAll(),
            'parents' => $this->userModel->getParents(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/students/edit', $data);
    }

    public function update($id)
    {
        $rules = $this->studentModel->getValidationRules();
        $rules['nis'] = str_replace('{id}', $id, $rules['nis']);
        $rules['nisn'] = str_replace('{id}', $id, $rules['nisn']);
        $rules['student_photo'] = 'if_exist|is_image[student_photo]|max_size[student_photo,1024]';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nis' => $this->request->getVar('nis'),
            'nisn' => $this->request->getVar('nisn'),
            'full_name' => $this->request->getVar('full_name'),
            'gender' => $this->request->getVar('gender'),
            'religion' => $this->request->getVar('religion'),
            'birth_place' => $this->request->getVar('birth_place'),
            'birth_date' => $this->request->getVar('birth_date'),
            'address' => $this->request->getVar('address'),
            'parent_name' => $this->request->getVar('parent_name'),
            'parent_phone' => $this->request->getVar('parent_phone'),
            'class_id' => $this->request->getVar('class_id') ?: null,
            'user_id' => $this->request->getVar('user_id') ?: null,
            'status' => $this->request->getVar('status'),
        ];

        // Handle Photo Upload
        $photo = $this->request->getFile('student_photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $student = $this->studentModel->find($id);
            // Delete old photo if exists
            if ($student && !empty($student['photo'])) {
                if (file_exists(FCPATH . $student['photo'])) {
                    @unlink(FCPATH . $student['photo']);
                }
            }

            $newName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/students', $newName);
            $data['photo'] = 'uploads/students/' . $newName;
        }

        // Use skipValidation(true) because we already validated manually above
        if (!$this->studentModel->skipValidation(true)->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', ['Gagal memperbarui data ke database. Silakan coba lagi.']);
        }

        // Sync with users table (Parent Account)
        if ($data['user_id']) {
            $this->userModel->update($data['user_id'], [
                'full_name' => $data['parent_name']
            ]);
        }

        // Audit Log
        $this->auditLogModel->log('update_student', "Diperbarui data siswa ID: {$id} - {$data['full_name']} (NIS: {$data['nis']})");

        return redirect()->to('/students')->with('message', 'Data siswa berhasil diupdate');
    }

    public function delete($id)
    {
        $student = $this->studentModel->find($id);
        $this->studentModel->delete($id);

        // Audit Log
        if ($student) {
            $this->auditLogModel->log('delete_student', "Dihapus data siswa: {$student['full_name']} (ID: {$id})");
        }

        return redirect()->to('/students')->with('message', 'Data siswa berhasil dihapus');
    }

    public function exportCsv()
    {
        helper('export');
        $students = $this->studentModel->select('students.*, classes.name as class_name')
                                       ->join('classes', 'classes.id = students.class_id', 'left')
                                       ->findAll();
        
        $header = ['NIS', 'NISN', 'Nama Lengkap', 'Jenis Kelamin', 'Agama', 'Tempat Lahir', 'Tanggal Lahir', 'Kelas', 'Alamat', 'Status'];
        $data = [];
        
        foreach ($students as $row) {
            $data[] = [
                $row['nis'],
                $row['nisn'],
                $row['full_name'],
                $row['gender'],
                $row['religion'] ?: '-',
                $row['birth_place'] ?: '-',
                $row['birth_date'] ?: '-',
                $row['class_name'] ?: '-',
                $row['address'],
                $row['status']
            ];
        }
        
        return export_to_csv('Data_Siswa_' . date('Ymd') . '.csv', $header, $data);
    }

    public function exportPdf()
    {
        helper(['export', 'branding']);
        $students = $this->studentModel->select('students.*, classes.name as class_name')
                                       ->join('classes', 'classes.id = students.class_id', 'left')
                                       ->findAll();
        
        $data = [
            'title' => 'Daftar Seluruh Siswa',
            'students' => $students,
            'school' => school_branding()
        ];
        
        return export_to_pdf('exports/student_list', $data, 'Data_Siswa_' . date('Ymd') . '.pdf');
    }
}
