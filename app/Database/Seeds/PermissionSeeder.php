<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // 1. Define Default Permissions
        $permissions = [
            // User Management
            ['name' => 'user.view', 'description' => 'Can view users'],
            ['name' => 'user.create', 'description' => 'Can create users'],
            ['name' => 'user.edit', 'description' => 'Can edit users'],
            ['name' => 'user.delete', 'description' => 'Can delete users'],
            
            // Student Management
            ['name' => 'student.view', 'description' => 'Can view students'],
            ['name' => 'student.create', 'description' => 'Can create students'],
            ['name' => 'student.edit', 'description' => 'Can edit students'],
            ['name' => 'student.delete', 'description' => 'Can delete students'],
            
            // Teacher Management
            ['name' => 'teacher.view', 'description' => 'Can view teachers'],
            ['name' => 'teacher.create', 'description' => 'Can create teachers'],
            ['name' => 'teacher.edit', 'description' => 'Can edit teachers'],
            ['name' => 'teacher.delete', 'description' => 'Can delete teachers'],

            // Academic
            ['name' => 'class.manage', 'description' => 'Can manage classes'],
            ['name' => 'subject.manage', 'description' => 'Can manage subjects'],
            ['name' => 'schedule.manage', 'description' => 'Can manage schedule'],
            ['name' => 'attendance.input', 'description' => 'Can input attendance'],
            ['name' => 'grade.input', 'description' => 'Can input grades'],
            
            // Settings & RBAC
            ['name' => 'setting.manage', 'description' => 'Can manage settings'],
            ['name' => 'role.manage', 'description' => 'Can manage roles and permissions'],
        ];

        // Insert Permissions
        foreach ($permissions as $perm) {
            // Check if exists
            $exists = $db->table('permissions')->where('name', $perm['name'])->countAllResults();
            if (!$exists) {
                $db->table('permissions')->insert($perm);
            }
        }

        // 2. Assign All Permissions to Admin
        $adminRole = $db->table('roles')->where('name', 'admin')->get()->getRow();
        if ($adminRole) {
            $allPerms = $db->table('permissions')->get()->getResult();
            $rolePerms = [];
            foreach ($allPerms as $p) {
                // Check if already assigned
                $assigned = $db->table('role_permissions')
                               ->where('role_id', $adminRole->id)
                               ->where('permission_id', $p->id)
                               ->countAllResults();
                if (!$assigned) {
                    $rolePerms[] = [
                        'role_id' => $adminRole->id,
                        'permission_id' => $p->id
                    ];
                }
            }
            if (!empty($rolePerms)) {
                $db->table('role_permissions')->insertBatch($rolePerms);
            }
        }

        // 3. Assign Specific Permissions to Guru
        $guruRole = $db->table('roles')->where('name', 'guru')->get()->getRow();
        if ($guruRole) {
            $guruPerms = ['attendance.input', 'grade.input', 'student.view'];
            foreach ($guruPerms as $pName) {
                $p = $db->table('permissions')->where('name', $pName)->get()->getRow();
                if ($p) {
                    $assigned = $db->table('role_permissions')
                                   ->where('role_id', $guruRole->id)
                                   ->where('permission_id', $p->id)
                                   ->countAllResults();
                    if (!$assigned) {
                        $db->table('role_permissions')->insert([
                            'role_id' => $guruRole->id,
                            'permission_id' => $p->id
                        ]);
                    }
                }
            }
        }
    }
}
