<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PopulateUserFullNames extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $users = $db->table('users')->get()->getResultArray();

        foreach ($users as $user) {
            $fullName = $user['full_name'];

            if (empty($fullName)) {
                if ($user['role'] == 'guru' || $user['role'] == 'kepsek' || $user['role'] == 'wali_kelas') {
                    // Try to find in teachers table
                    $teacher = $db->table('teachers')->where('user_id', $user['id'])->get()->getRowArray();
                    if ($teacher) {
                        $fullName = $teacher['full_name'];
                    }
                } elseif ($user['role'] == 'ortu') {
                    // Try to find in students table (parent_name)
                    $student = $db->table('students')->where('user_id', $user['id'])->get()->getRowArray();
                    if ($student) {
                        $fullName = $student['parent_name'];
                    }
                }

                // Fallback to username for admin or if not found
                if (empty($fullName)) {
                    $fullName = $user['username'];
                }

                $db->table('users')->where('id', $user['id'])->update(['full_name' => $fullName]);
                echo "Updated user: {$user['username']} -> {$fullName}\n";
            }
        }
    }
}
