<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ParentStudentSeeder extends Seeder
{
    public function run()
    {
        // Get the 'ortu' user
        $userModel = new \App\Models\UserModel();
        $ortu = $userModel->where('username', 'ortu')->first();

        // Get the first student
        $studentModel = new \App\Models\StudentModel();
        $student = $studentModel->first();

        if ($ortu && $student) {
            $studentModel->update($student['id'], ['user_id' => $ortu['id']]);
        }
    }
}
