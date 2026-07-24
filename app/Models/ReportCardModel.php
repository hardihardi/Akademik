<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportCardModel extends Model
{
    protected $table            = 'report_cards';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['student_id', 'academic_year_id', 'semester', 'homeroom_notes', 'promotion_status', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getStudentReport($studentId, $academicYearId, $semester)
    {
        return $this->where('student_id', $studentId)
                    ->where('academic_year_id', $academicYearId)
                    ->where('semester', $semester)
                    ->first();
    }
}
