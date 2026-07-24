<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GradesModel;
use App\Models\StudentModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\AcademicYearModel;

class Grades extends BaseController
{
    protected $gradesModel;
    protected $studentModel;
    protected $classModel;
    protected $subjectModel;
    protected $academicYearModel;

    public function __construct()
    {
        $this->gradesModel = new GradesModel();
        $this->studentModel = new StudentModel();
        $this->classModel = new ClassModel();
        $this->subjectModel = new SubjectModel();
        $this->academicYearModel = new AcademicYearModel();
    }


    public function list()
    {
        $db = \Config\Database::connect();
        $activeYear = $db->table('academic_years')->where('status', 'Active')->get()->getRowArray();
        $academicYearId = $activeYear ? $activeYear['id'] : null;

        $builder = $this->gradesModel->select('grades.*, students.full_name as student_name, students.nis, classes.name as class_name, subjects.name as subject_name')
                                     ->join('students', 'students.id = grades.student_id')
                                     ->join('classes', 'classes.id = students.class_id')
                                     ->join('subjects', 'subjects.id = grades.subject_id');

        if ($academicYearId) {
            $builder->where('grades.academic_year_id', $academicYearId);
        }

        if ($classId) {
            $builder->where('students.class_id', $classId);
        }
        if ($subjectId) {
            $builder->where('grades.subject_id', $subjectId);
        }

        $grades = $builder->orderBy('grades.created_at', 'DESC')->paginate(20, 'grades');

        $data = [
            'title' => 'Data Nilai Siswa',
            'grades' => $grades,
            'pager' => $this->gradesModel->pager,
            'classes' => $this->classModel->findAll(),
            'subjects' => $this->subjectModel->findAll(),
            'selectedClass' => $classId,
            'selectedSubject' => $subjectId
        ];

        return view('academic/grades/list', $data);
    }

    // --- CRUD Methods removed in favor of Task & Material integrated assessment flow ---
}
