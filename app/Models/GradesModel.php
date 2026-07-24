<?php

namespace App\Models;

use CodeIgniter\Model;

class GradesModel extends Model
{
    protected $table            = 'grades';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['student_id', 'subject_id', 'type', 'score', 'semester', 'academic_year_id', 'status', 'description'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'student_id' => 'required',
        'subject_id' => 'required',
        'type'       => 'required',
        'score'      => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getGradesByClassSubjectType($classId, $subjectId, $type, $semester)
    {
        return $this->select('grades.*, students.full_name, students.nis')
                    ->join('students', 'students.id = grades.student_id')
                    ->where('students.class_id', $classId)
                    ->where('grades.subject_id', $subjectId)
                    ->where('grades.type', $type)
                    ->where('grades.semester', $semester)
                    ->findAll();
    }
}
