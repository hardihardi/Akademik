<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HomeroomRoleSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // 1. Create Role
        $roleName = 'wali_kelas';
        $role = $db->table('roles')->where('name', $roleName)->get()->getRow();
        if (!$role) {
            $db->table('roles')->insert([
                'name'        => $roleName,
                'description' => 'Guru yang ditugaskan sebagai Wali Kelas (Memiliki akses ke Rapor & Ledger)',
            ]);
            $roleId = $db->insertID();
        } else {
            $roleId = $role->id;
        }

        // 2. Create Permissions
        $permissions = [
            ['name' => 'report.view', 'description' => 'Dapat melihat daftar siswa dan cetak rapor'],
            ['name' => 'report.input_notes', 'description' => 'Dapat menginput catatan wali kelas'],
            ['name' => 'report.sync', 'description' => 'Dapat melakukan sinkronisasi nilai rapor'],
            ['name' => 'ledger.view', 'description' => 'Dapat melihat ledger nilai kelas'],
            ['name' => 'attendance.recap', 'description' => 'Dapat melihat dan download rekap kehadiran'],
        ];

        foreach ($permissions as $perm) {
            $exists = $db->table('permissions')->where('name', $perm['name'])->get()->getRow();
            if (!$exists) {
                $db->table('permissions')->insert($perm);
            }
        }

        // 3. Link Permissions to Role
        $rolePerms = [];
        foreach ($permissions as $perm) {
            $p = $db->table('permissions')->where('name', $perm['name'])->get()->getRow();
            if ($p) {
                $assigned = $db->table('role_permissions')
                               ->where('role_id', $roleId)
                               ->where('permission_id', $p->id)
                               ->countAllResults();
                if (!$assigned) {
                    $db->table('role_permissions')->insert([
                        'role_id'       => $roleId,
                        'permission_id' => $p->id
                    ]);
                }
            }
        }

        // 4. Assign a sample teacher to this role
        // We look for a user who already has the 'guru' role
        $teacherUser = $db->table('users')->where('role', 'guru')->get()->getRow();
        if ($teacherUser) {
            // Assign to users_roles table
            $alreadyHasRole = $db->table('users_roles')
                                 ->where('user_id', $teacherUser->id)
                                 ->where('role_id', $roleId)
                                 ->countAllResults();
            if (!$alreadyHasRole) {
                $db->table('users_roles')->insert([
                    'user_id' => $teacherUser->id,
                    'role_id' => $roleId
                ]);
            }

            // Ensure they are also in homeroom_assignments for a specific class
            $teacherRecord = $db->table('teachers')->where('user_id', $teacherUser->id)->get()->getRow();
            $classRecord = $db->table('classes')->get()->getRow();
            $activeYear = $db->table('academic_years')->where('status', 'Active')->get()->getRow();

            if ($teacherRecord && $classRecord && $activeYear) {
                $hasAssignment = $db->table('homeroom_assignments')
                                    ->where('teacher_id', $teacherRecord->id)
                                    ->where('class_id', $classRecord->id)
                                    ->where('academic_year_id', $activeYear->id)
                                    ->countAllResults();
                if (!$hasAssignment) {
                    $db->table('homeroom_assignments')->insert([
                        'teacher_id'       => $teacherRecord->id,
                        'class_id'         => $classRecord->id,
                        'academic_year_id' => $activeYear->id
                    ]);
                }
            }
        }
    }
}
