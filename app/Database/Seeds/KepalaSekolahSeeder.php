<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KepalaSekolahSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // 1. Ensure Kepsek Role exists
        $role = $db->table('roles')->where('name', 'kepsek')->get()->getRow();
        if (!$role) {
            $db->table('roles')->insert([
                'name' => 'kepsek',
                'description' => 'Kepala Sekolah - Monitoring & Executive Oversight',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $roleId = $db->insertID();
        } else {
            $roleId = $role->id;
        }

        // 2. Define Supervisory Permissions
        $permissions = [
            ['name' => 'academic.monitor', 'description' => 'Monitoring input nilai & absensi seluruh sekolah'],
            ['name' => 'report.executive', 'description' => 'Akses laporan eksekutif dan statistik'],
            ['name' => 'announcement.view', 'description' => 'Melihat pengumuman sekolah'],
            ['name' => 'announcement.manage', 'description' => 'Mengelola pengumuman sekolah'],
        ];

        foreach ($permissions as $perm) {
            $exists = $db->table('permissions')->where('name', $perm['name'])->get()->getRow();
            if (!$exists) {
                $db->table('permissions')->insert($perm);
                $permId = $db->insertID();
            } else {
                $permId = $exists->id;
            }

            // Assign to Kepsek Role
            $assigned = $db->table('role_permissions')
                           ->where('role_id', $roleId)
                           ->where('permission_id', $permId)
                           ->countAllResults();
            if (!$assigned) {
                $db->table('role_permissions')->insert([
                    'role_id' => $roleId,
                    'permission_id' => $permId
                ]);
            }
        }

        // Also give Kepsek view-only access to master data
        $viewPerms = ['student.view', 'teacher.view'];
        foreach ($viewPerms as $pName) {
            $p = $db->table('permissions')->where('name', $pName)->get()->getRow();
            if ($p) {
                $assigned = $db->table('role_permissions')
                               ->where('role_id', $roleId)
                               ->where('permission_id', $p->id)
                               ->countAllResults();
                if (!$assigned) {
                    $db->table('role_permissions')->insert([
                        'role_id' => $roleId,
                        'permission_id' => $p->id
                    ]);
                }
            }
        }

        // 3. Create Kepsek User
        $user = $db->table('users')->where('username', 'kepsek')->get()->getRow();
        if (!$user) {
            $db->table('users')->insert([
                'username'      => 'kepsek',
                'password_hash' => password_hash('kepsek123', PASSWORD_BCRYPT),
                'email'         => 'kepsek@sekolah.id',
                'role'          => 'kepsek',
                'active'        => 1,
                'photo'         => 'https://ui-avatars.com/api/?name=Kepala+Sekolah&background=random&color=fff&size=200',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
            $userId = $db->insertID();
        } else {
            $userId = $user->id;
        }

        // Assign role in RBAC table
        $assigned = $db->table('users_roles')
                       ->where('user_id', $userId)
                       ->where('role_id', $roleId)
                       ->countAllResults();
        if (!$assigned) {
            $db->table('users_roles')->insert([
                'user_id' => $userId,
                'role_id' => $roleId,
            ]);
        }
    }
}
