<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table            = 'attendance';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['student_id', 'class_id', 'academic_year_id', 'date', 'status', 'note', 'evidence_path', 'is_verified'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'student_id' => 'required',
        'date'       => 'required',
        'status'     => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getAttendanceByClassAndDate($classId, $date)
    {
        return $this->select('attendance.*, students.full_name, students.nis')
                    ->join('students', 'students.id = attendance.student_id')
                    ->where('attendance.class_id', $classId)
                    ->where('attendance.date', $date)
                    ->findAll();
    }
}
