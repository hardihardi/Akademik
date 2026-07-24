<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TeacherModel;
use App\Models\ClassModel;
use App\Models\AcademicYearModel;
use App\Models\HomeroomAssignmentModel;

class HomeroomAssignment extends BaseController
{
    protected $teacherModel;
    protected $classModel;
    protected $academicYearModel;
    protected $assignmentModel;

    public function __construct()
    {
        $this->teacherModel = new TeacherModel();
        $this->classModel = new ClassModel();
        $this->academicYearModel = new AcademicYearModel();
        $this->assignmentModel = new HomeroomAssignmentModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Penugasan Wali Kelas',
            'assignments' => $this->assignmentModel->getAssignments()
        ];
        return view('admin/homerooms/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Wali Kelas',
            'teachers' => $this->teacherModel->findAll(),
            'classes' => $this->classModel->findAll(),
            'academic_years' => $this->academicYearModel->orderBy('year', 'DESC')->findAll(),
            'active_year' => $this->academicYearModel->getActiveYear(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/homerooms/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'teacher_id' => 'required',
            'class_id' => 'required',
            'academic_year_id' => 'required',
        ])) {
            return redirect()->back()->withInput();
        }

        // Check unique constraint (simplified check)
        $existing = $this->assignmentModel->where('class_id', $this->request->getPost('class_id'))
                                          ->where('academic_year_id', $this->request->getPost('academic_year_id'))
                                          ->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Kelas ini sudah memiliki Wali Kelas untuk tahun akademik terpilih.');
        }

        $this->assignmentModel->save([
            'teacher_id' => $this->request->getPost('teacher_id'),
            'class_id' => $this->request->getPost('class_id'),
            'academic_year_id' => $this->request->getPost('academic_year_id'),
        ]);

        return redirect()->to('/homerooms')->with('message', 'Wali Kelas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $assignment = $this->assignmentModel->find($id);
        if (!$assignment) {
            return redirect()->to('/homerooms')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Wali Kelas',
            'assignment' => $assignment,
            'teachers' => $this->teacherModel->findAll(),
            'classes' => $this->classModel->findAll(),
            'academic_years' => $this->academicYearModel->orderBy('year', 'DESC')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/homerooms/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'teacher_id' => 'required',
            'class_id' => 'required',
            'academic_year_id' => 'required',
        ])) {
            return redirect()->back()->withInput();
        }

        // Constraints check logic could be added here similar to store

        $this->assignmentModel->update($id, [
            'teacher_id' => $this->request->getPost('teacher_id'),
            'class_id' => $this->request->getPost('class_id'),
            'academic_year_id' => $this->request->getPost('academic_year_id'),
        ]);

        return redirect()->to('/homerooms')->with('message', 'Data Wali Kelas berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->assignmentModel->delete($id);
        return redirect()->to('/homerooms')->with('message', 'Data Wali Kelas berhasil dihapus');
    }
}
