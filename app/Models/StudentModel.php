<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table            = 'students';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 'class_id', 'nis', 'nisn', 'full_name', 'nickname', 'gender', 'religion',
        'birth_place', 'birth_date', 'address', 'parent_name', 'parent_phone', 'photo', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nis'       => 'required|is_unique[students.nis,id,{id}]',
        'nisn'      => 'permit_empty|is_unique[students.nisn,id,{id}]',
        'full_name' => 'required|min_length[3]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    
    public function getStudentsWithClass()
    {
        return $this->select('students.*, classes.name as class_name')
                    ->join('classes', 'classes.id = students.class_id', 'left')
                    ->findAll();
    }
}
