<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeroomAssignmentModel extends Model
{
    protected $table            = 'homeroom_assignments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['teacher_id', 'class_id', 'academic_year_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAssignments()
    {
        return $this->select('homeroom_assignments.*, teachers.full_name as teacher_name, classes.name as class_name, academic_years.year as academic_year, academic_years.semester')
                    ->join('teachers', 'teachers.id = homeroom_assignments.teacher_id')
                    ->join('classes', 'classes.id = homeroom_assignments.class_id')
                    ->join('academic_years', 'academic_years.id = homeroom_assignments.academic_year_id')
                    ->findAll();
    }
}
