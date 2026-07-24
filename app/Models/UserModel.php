<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; // Assuming no soft delete for now
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'full_name', 'password_hash', 'email', 'photo', 'role', 'active'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getParents()
    {
        return $this->select('users.id, users.username, users.email')
                    ->join('users_roles', 'users_roles.user_id = users.id')
                    ->join('roles', 'roles.id = users_roles.role_id')
                    ->where('roles.name', 'ortu')
                    ->where('users.active', 1)
                    ->findAll();
    }
}
