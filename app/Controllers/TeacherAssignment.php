<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TeacherAssignmentModel;
use App\Models\TeacherModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\AcademicYearModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class TeacherAssignment extends BaseController
{
    protected $assignmentModel;
    protected $teacherModel;
    protected $classModel;
    protected $subjectModel;
    protected $academicYearModel;
    protected $auditLogModel;

    public function __construct()
    {
        $this->assignmentModel = new TeacherAssignmentModel();
        $this->teacherModel = new TeacherModel();
        $this->classModel = new ClassModel();
        $this->subjectModel = new SubjectModel();
        $this->academicYearModel = new AcademicYearModel();
        $this->auditLogModel = new \App\Models\AuditLogModel();
    }

    public function index()
    {
        $search = $this->request->getVar('search');
        $classFilter = $this->request->getVar('class');
        $yearFilter = $this->request->getVar('year');

        $assignments = $this->assignmentModel->getFilteredAssignments($search, $classFilter, $yearFilter)
                                             ->paginate(10, 'assignments');

        $data = [
            'title' => 'Penugasan Guru',
            'assignments' => $assignments,
            'pager' => $this->assignmentModel->pager,
            'classes' => $this->classModel->findAll(),
            'academicYears' => $this->academicYearModel->orderBy('year', 'DESC')->findAll(),
            'search' => $search,
            'classFilter' => $classFilter,
            'yearFilter' => $yearFilter
        ];
        return view('admin/teacher_assignments/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Penugasan',
            'teachers' => $this->teacherModel->where('status', 'Aktif')->findAll(),
            'classes' => $this->classModel->findAll(),
            'subjects' => $this->subjectModel->findAll(),
            'academicYears' => $this->academicYearModel->orderBy('year', 'DESC')->findAll(),
            'activeYear' => get_active_academic_year()
        ];
        return view('admin/teacher_assignments/create', $data);
    }

    public function create()
    {
        $data = [
            'teacher_id' => $this->request->getVar('teacher_id'),
            'class_id' => $this->request->getVar('class_id'),
            'subject_id' => $this->request->getVar('subject_id'),
            'academic_year_id' => $this->request->getVar('academic_year_id'),
        ];

        // Check if assignment already exists
        $exists = $this->assignmentModel->where($data)->first();
        if ($exists) {
            return redirect()->back()->withInput()->with('errors', ['Penugasan tersebut sudah ada.']);
        }

        if (!$this->assignmentModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', ['Gagal menyimpan penugasan.']);
        }

        $teacher = $this->teacherModel->find($data['teacher_id']);
        $this->auditLogModel->log('create_assignment', "Menugaskan guru {$teacher['full_name']} (ID: {$data['teacher_id']})");

        return redirect()->to('/teacher-assignments')->with('message', 'Penugasan berhasil ditambahkan');
    }

    public function edit($id = null)
    {
        $assignment = $this->assignmentModel->find($id);
        if (!$assignment) {
            throw new PageNotFoundException('Penugasan tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Edit Penugasan',
            'assignment' => $assignment,
            'teachers' => $this->teacherModel->where('status', 'Aktif')->findAll(),
            'classes' => $this->classModel->findAll(),
            'subjects' => $this->subjectModel->findAll(),
            'academicYears' => $this->academicYearModel->orderBy('year', 'DESC')->findAll(),
        ];
        return view('admin/teacher_assignments/edit', $data);
    }

    public function update($id = null)
    {
        $data = [
            'teacher_id' => $this->request->getVar('teacher_id'),
            'class_id' => $this->request->getVar('class_id'),
            'subject_id' => $this->request->getVar('subject_id'),
            'academic_year_id' => $this->request->getVar('academic_year_id'),
        ];

        // Check if another similar assignment exists
        $exists = $this->assignmentModel->where($data)->where('id !=', $id)->first();
        if ($exists) {
            return redirect()->back()->withInput()->with('errors', ['Penugasan serupa sudah ada.']);
        }

        if (!$this->assignmentModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', ['Gagal memperbarui penugasan.']);
        }

        $teacher = $this->teacherModel->find($data['teacher_id']);
        $this->auditLogModel->log('update_assignment', "Memperbarui penugasan guru {$teacher['full_name']} (ID: {$id})");

        return redirect()->to('/teacher-assignments')->with('message', 'Penugasan berhasil diperbarui');
    }

    public function delete($id = null)
    {
        $assignment = $this->assignmentModel->find($id);
        if (!$assignment) {
            throw new PageNotFoundException('Penugasan tidak ditemukan: ' . $id);
        }

        $this->assignmentModel->delete($id);
        $this->auditLogModel->log('delete_assignment', "Menghapus penugasan (ID: {$id})");

        return redirect()->to('/teacher-assignments')->with('message', 'Penugasan berhasil dihapus');
    }
}
