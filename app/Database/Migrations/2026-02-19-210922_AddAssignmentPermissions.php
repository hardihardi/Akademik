<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAssignmentPermissions extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        // 1. New permissions
        $permissions = [
            ['name' => 'assignment.manage', 'description' => 'Can manage assignments'],
            ['name' => 'material.manage', 'description' => 'Can manage materials'],
            ['name' => 'announcement.view', 'description' => 'Can view announcements'],
        ];

        foreach ($permissions as $perm) {
            $exists = $db->table('permissions')->where('name', $perm['name'])->countAllResults();
            if (!$exists) {
                $db->table('permissions')->insert($perm);
            }
        }

        // 2. Assign to roles
        $admin = $db->table('roles')->where('name', 'admin')->get()->getRow();
        $guru = $db->table('roles')->where('name', 'guru')->get()->getRow();

        if ($admin) {
            foreach ($permissions as $perm) {
                $p = $db->table('permissions')->where('name', $perm['name'])->get()->getRow();
                if ($p) {
                    $assigned = $db->table('role_permissions')
                        ->where('role_id', $admin->id)
                        ->where('permission_id', $p->id)
                        ->countAllResults();
                    if (!$assigned) {
                        $db->table('role_permissions')->insert(['role_id' => $admin->id, 'permission_id' => $p->id]);
                    }
                }
            }
        }

        if ($guru) {
            foreach ($permissions as $perm) {
                $p = $db->table('permissions')->where('name', $perm['name'])->get()->getRow();
                if ($p) {
                    $assigned = $db->table('role_permissions')
                        ->where('role_id', $guru->id)
                        ->where('permission_id', $p->id)
                        ->countAllResults();
                    if (!$assigned) {
                        $db->table('role_permissions')->insert(['role_id' => $guru->id, 'permission_id' => $p->id]);
                    }
                }
            }
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        $permissions = ['assignment.manage', 'material.manage', 'announcement.view'];
        
        foreach ($permissions as $permName) {
            $p = $db->table('permissions')->where('name', $permName)->get()->getRow();
            if ($p) {
                $db->table('role_permissions')->where('permission_id', $p->id)->delete();
                $db->table('permissions')->where('id', $p->id)->delete();
            }
        }
    }
}
