<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentClassHistoryModel extends Model
{
    protected $table            = 'student_class_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['student_id', 'class_id', 'academic_year_id', 'promotion_status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getHistoryByStudent($studentId)
    {
        return $this->select('student_class_history.*, classes.name as class_name, academic_years.year as academic_year')
                    ->join('classes', 'classes.id = student_class_history.class_id')
                    ->join('academic_years', 'academic_years.id = student_class_history.academic_year_id')
                    ->where('student_id', $studentId)
                    ->orderBy('academic_years.year', 'DESC')
                    ->findAll();
    }
}
