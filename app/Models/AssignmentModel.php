<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentModel extends Model
{
    protected $table            = 'assignments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['class_id', 'subject_id', 'teacher_id', 'academic_year_id', 'title', 'type', 'description', 'file_path', 'deadline'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'class_id'   => 'required|integer',
        'subject_id' => 'required|integer',
        'teacher_id' => 'required|integer',
        'academic_year_id' => 'required|integer',
        'title'      => 'required|min_length[3]|max_length[255]',
        'type'       => 'required|in_list[Materi,Tugas,Ulangan,UTS,UAS,Sikap]',
        'deadline'   => 'required',
    ];
    protected $validationMessages  = [];
    protected $skipValidation      = false;
    protected $cleanValidationRules = true;
    
    public $pendingSubquery = "(SELECT COUNT(*) FROM submissions WHERE submissions.assignment_id = assignments.id AND submissions.status = 'submitted')";

    public function getAssignmentsWithRelations(?int $classId = null, ?int $teacherId = null, ?string $search = null, ?string $type = null)
    {
        $this->select('assignments.*, classes.name as class_name, subjects.name as subject_name, teachers.full_name as teacher_name')
             ->select($this->pendingSubquery . ' as pending_count')
             ->join('classes', 'classes.id = assignments.class_id', 'left')
             ->join('subjects', 'subjects.id = assignments.subject_id', 'left')
             ->join('teachers', 'teachers.id = assignments.teacher_id', 'left');

        if ($classId) {
            $this->where('assignments.class_id', $classId);
        }
        if ($teacherId) {
            $this->where('assignments.teacher_id', $teacherId);
        }
        if ($search) {
            $this->groupStart()
                 ->like('assignments.title', $search)
                 ->orLike('teachers.full_name', $search)
                 ->orLike('subjects.name', $search)
                 ->groupEnd();
        }
        if ($type) {
            $this->where('assignments.type', $type);
        }

        return $this->orderBy('deadline', 'ASC');
    }
}
