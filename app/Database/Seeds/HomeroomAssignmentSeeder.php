<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HomeroomAssignmentSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // 1. Get Active Academic Year
        $activeYear = $db->table('academic_years')->where('status', 'Active')->get()->getRow();
        if (!$activeYear) {
            $activeYear = $db->table('academic_years')->get()->getRow();
        }
        
        if (!$activeYear) {
            echo "No academic year found. Please run AcademicYearSeeder first.\n";
            return;
        }

        // 2. Get All Classes
        $classes = $db->table('classes')->get()->getResultArray();
        
        // 3. Get Teachers (If < classes count, create more)
        $teachers = $db->table('teachers')->get()->getResultArray();
        $needed = count($classes) - count($teachers);
        
        if ($needed > 0) {
            echo "Creating $needed additional teachers...\n";
            $faker = \Faker\Factory::create('id_ID');
            for ($i = 0; $i < $needed; $i++) {
                $gender = $faker->randomElement(['male', 'female']);
                $name = $faker->name($gender);
                $username = strtolower(str_replace([' ', '.', '\''], '', $name)) . $faker->numberBetween(100, 999);
                
                $db->table('users')->insert([
                    'username'      => $username,
                    'password_hash' => password_hash('guru123', PASSWORD_BCRYPT),
                    'email'         => $username . '@sekolah.id',
                    'role'          => 'guru',
                    'active'        => 1,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
                $userId = $db->insertID();

                $db->table('teachers')->insert([
                    'user_id'    => $userId,
                    'nip'        => $faker->unique()->numberBetween(20000000, 20999999), 
                    'full_name'  => $name . ($gender == 'male' ? ', S.Pd.' : ', M.Pd.'),
                    'phone'      => $faker->phoneNumber,
                    'address'    => $faker->address,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
            // Refresh teachers list
            $teachers = $db->table('teachers')->get()->getResultArray();
        }

        // 4. Assign Homerooms
        echo "Assigning homerooms...\n";
        $db->table('homeroom_assignments')->truncate(); // Clear existing
        
        foreach ($classes as $index => $class) {
            $teacher = $teachers[$index]; // One to one mapping
            
            $db->table('homeroom_assignments')->insert([
                'teacher_id'       => $teacher['id'],
                'class_id'         => $class['id'],
                'academic_year_id' => $activeYear->id,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ]);
            echo "Class {$class['name']} assigned to {$teacher['full_name']}\n";
        }
        
        echo "Homeroom assignments completed.\n";
    }
}
