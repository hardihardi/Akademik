<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        // 1. Academic Years
        $academicYears = [
            ['year' => '2023/2024', 'semester' => 'Genap', 'status' => 'inactive', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['year' => '2024/2025', 'semester' => 'Ganjil', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        foreach ($academicYears as $ay) {
            if ($this->db->table('academic_years')->where('year', $ay['year'])->countAllResults() == 0) {
                 $this->db->table('academic_years')->insert($ay);
            }
        }
        
        // 2. Classes
        $classesStart = 1;
        $classesEnd = 6;
        $sections = ['A', 'B'];
        $classIds = [];

        foreach (range($classesStart, $classesEnd) as $grade) {
            foreach ($sections as $section) {
                $className = "Kelas $grade$section";
                $existing = $this->db->table('classes')->where('name', $className)->get()->getRow();
                
                if (!$existing) {
                    $this->db->table('classes')->insert([
                        'name' => $className,
                        'academic_year' => '2024/2025',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    $classIds[] = $this->db->insertID();
                } else {
                    $classIds[] = $existing->id;
                }
            }
        }

        // 3. Subjects
        $subjects = [
            ['name' => 'Pendidikan Agama Islam', 'description' => 'Pendidikan ahlak dan akidah'],
            ['name' => 'Pendidikan Kewarganegaraan', 'description' => 'Pendidikan karakter kebangsaan'],
            ['name' => 'Bahasa Indonesia', 'description' => 'Kemampuan berbahasa nasional'],
            ['name' => 'Matematika', 'description' => 'Logika dan berhitung'],
            ['name' => 'Ilmu Pengetahuan Alam', 'description' => 'Sains dan alam sekitar'],
            ['name' => 'Ilmu Pengetahuan Sosial', 'description' => 'Sejarah dan geografi'],
            ['name' => 'Seni Budaya dan Prakarya', 'description' => 'Kesenian dan keterampilan'],
            ['name' => 'Pendidikan Jasmani', 'description' => 'Olahraga dan kesehatan'],
            ['name' => 'Bahasa Inggris', 'description' => 'Bahasa Asing'],
            ['name' => 'Bahasa Arab', 'description' => 'Bahasa Asing'],
        ];

        foreach ($subjects as $subj) {
             if ($this->db->table('subjects')->where('name', $subj['name'])->countAllResults() == 0) {
                $subj['created_at'] = date('Y-m-d H:i:s');
                $subj['updated_at'] = date('Y-m-d H:i:s');
                $this->db->table('subjects')->insert($subj);
             }
        }

        // 4. Students
        foreach ($classIds as $classId) {
            // 5 students per class
            for ($i = 0; $i < 5; $i++) {
                $nis = $faker->unique()->numberBetween(240000, 249999); 
                $gender = $faker->randomElement(['L', 'P']);
                $name = $faker->name($gender == 'L' ? 'male' : 'female');
                
                // Check uniqueness
                if ($this->db->table('students')->where('nis', $nis)->countAllResults() == 0) {
                     $data = [
                        'nis' => (string)$nis,
                        'full_name' => $name,
                        'class_id' => $classId,
                        'birth_place' => $faker->city,
                        'birth_date' => $faker->dateTimeBetween('-12 years', '-6 years')->format('Y-m-d'),
                        'address' => $faker->address,
                        'parent_name' => $faker->name($gender == 'L' ? 'male' : 'female'), // Just a parent name
                        'parent_phone' => $faker->phoneNumber,
                        'gender' => $gender,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    $this->db->table('students')->insert($data);
                }
            }
        }
    }
}
