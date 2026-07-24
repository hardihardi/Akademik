<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherAssignmentModel extends Model
{
    protected $table            = 'teacher_assignments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['teacher_id', 'class_id', 'subject_id', 'academic_year_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getFilteredAssignments($search = null, $classFilter = null, $yearFilter = null)
    {
        $builder = $this->select('teacher_assignments.*, teachers.full_name as teacher_name, classes.name as class_name, subjects.name as subject_name, academic_years.year as academic_year, academic_years.semester')
                    ->join('teachers', 'teachers.id = teacher_assignments.teacher_id')
                    ->join('classes', 'classes.id = teacher_assignments.class_id')
                    ->join('subjects', 'subjects.id = teacher_assignments.subject_id')
                    ->join('academic_years', 'academic_years.id = teacher_assignments.academic_year_id');

        if ($search) {
            $builder->groupStart()
                    ->like('teachers.full_name', $search)
                    ->orLike('subjects.name', $search)
                    ->orLike('classes.name', $search)
                    ->groupEnd();
        }

        if ($classFilter) {
            $builder->where('classes.name', $classFilter);
        }

        if ($yearFilter) {
            $builder->where('academic_years.year', $yearFilter);
        }

        return $builder->orderBy('teacher_assignments.created_at', 'DESC');
    }

    public function getAssignments()
    {
        return $this->getFilteredAssignments()->findAll();
    }
}
