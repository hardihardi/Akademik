<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRoleModel extends Model
{
    protected $table            = 'users_roles';
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'role_id'];
    
    protected $primaryKey       = null;
    protected $useAutoIncrement = false;
    protected $useTimestamps    = false;

    public function getRolesByUser($userId)
    {
        return $this->select('roles.*')
                    ->join('roles', 'roles.id = users_roles.role_id')
                    ->where('users_roles.user_id', $userId)
                    ->findAll();
    }

    public function updateUserRoles($userId, $roleIds)
    {
         // Use Query Builder to avoid Model's Primary Key requirement for pivot tables
         $builder = $this->builder();

         // Delete existing
         $builder->where('user_id', $userId)->delete();
        
         // Insert new
         if (!empty($roleIds)) {
             $data = [];
             foreach ($roleIds as $roleId) {
                 $data[] = [
                     'user_id' => $userId,
                     'role_id' => $roleId
                 ];
             }
             $builder->insertBatch($data);
         }
    }
}
