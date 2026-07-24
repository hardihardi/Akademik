<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ParentAccountSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $students = $db->table('students')->get()->getResultArray();
        $roleId = 3; // ortu

        foreach ($students as $student) {
            if (empty($student['user_id'])) {
                // Create a username based on student name or parent name
                $baseUsername = strtolower(str_replace(' ', '', $student['parent_name'] ?: $student['full_name']));
                $username = $baseUsername;
                
                // Ensure uniqueness
                $count = 1;
                while($db->table('users')->where('username', $username)->countAllResults() > 0) {
                    $username = $baseUsername . $count;
                    $count++;
                }

                $userData = [
                    'username' => $username,
                    'email'    => $username . '@example.com',
                    'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                    'role'     => 'ortu', // Legacy field
                    'active'   => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $db->table('users')->insert($userData);
                $userId = $db->insertID();

                // Link role
                $db->table('users_roles')->insert([
                    'user_id' => $userId,
                    'role_id' => $roleId
                ]);

                // Link to student
                $db->table('students')->where('id', $student['id'])->update(['user_id' => $userId]);
                
                echo "Created parent account for {$student['full_name']}: {$username}\n";
            }
        }
    }
}
