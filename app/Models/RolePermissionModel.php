<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table            = 'role_permissions';
    protected $returnType       = 'array';
    protected $allowedFields    = ['role_id', 'permission_id'];
    
    // No primary key, composite key handled manually or via query builder
    protected $primaryKey       = null; 
    protected $useAutoIncrement = false;
    protected $useTimestamps    = false;

    public function getPermissionsByRole($roleId)
    {
        return $this->select('permissions.*')
                    ->join('permissions', 'permissions.id = role_permissions.permission_id')
                    ->where('role_permissions.role_id', $roleId)
                    ->findAll();
    }
    
    public function updatePermissions($roleId, $permissionIds)
    {
        // Delete existing
        $this->where('role_id', $roleId)->delete();
        
        // Insert new
        if (!empty($permissionIds)) {
            $data = [];
            foreach ($permissionIds as $permId) {
                $data[] = [
                    'role_id' => $roleId,
                    'permission_id' => $permId
                ];
            }
            $this->builder()->insertBatch($data);
        }
    }
}
