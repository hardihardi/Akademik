<?php

namespace App\Models;

use CodeIgniter\Model;

class AcademicYearModel extends Model
{
    protected $table            = 'academic_years';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['year', 'semester', 'status', 'is_locked'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'year'     => 'required',
        'semester' => 'required',
        'status'   => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    
    public function setActive($id)
    {
        // Deactivate all
        $this->set('status', 'Inactive')->where('id !=', $id)->update();
        // Activate selected
        $this->set('status', 'Active')->where('id', $id)->update();
    }
    
    public function getActiveYear()
    {
        return $this->where('status', 'Active')->first();
    }
}
