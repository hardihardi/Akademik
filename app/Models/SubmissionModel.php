<?php

namespace App\Models;

use CodeIgniter\Model;

class SubmissionModel extends Model
{
    protected $table            = 'submissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['assignment_id', 'student_id', 'file_path', 'status', 'grade', 'feedback'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'assignment_id' => 'required|integer',
        'student_id'    => 'required|integer',
        'status'        => 'required|in_list[submitted,reviewed]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getSubmissionWithDetails($assignmentId, $studentId)
    {
        return $this->where('assignment_id', $assignmentId)
                    ->where('student_id', $studentId)
                   ->first();
    }

    public function getSubmissionsByAssignment($assignmentId)
    {
        return $this->select('submissions.*, students.full_name as student_name')
                    ->join('students', 'students.id = submissions.student_id')
                    ->where('assignment_id', $assignmentId)
                    ->findAll();
    }
}
