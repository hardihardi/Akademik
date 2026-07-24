<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Fetch existing IDs
        $classes = $db->table('classes')->select('id')->limit(5)->get()->getResultArray();
        $subjects = $db->table('subjects')->select('id')->limit(5)->get()->getResultArray();
        $teachers = $db->table('teachers')->select('id')->limit(5)->get()->getResultArray();

        if (empty($classes) || empty($subjects) || empty($teachers)) {
            return;
        }

        $data = [
            [
                'class_id'    => $classes[0]['id'],
                'subject_id'  => $subjects[0]['id'],
                'teacher_id'  => $teachers[0]['id'],
                'title'       => 'Materi Pengenalan Ekosistem',
                'type'        => 'Materi',
                'description' => 'Materi ini membahas tentang komponen biotik dan abiotik dalam ekosistem darat dan air.',
                'file_path'   => null,
                'deadline'    => date('Y-m-d H:i:s', strtotime('+7 days')),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'class_id'    => $classes[0]['id'],
                'subject_id'  => $subjects[0]['id'],
                'teacher_id'  => $teachers[0]['id'],
                'title'       => 'Tugas Analisis Rantai Makanan',
                'type'        => 'Tugas',
                'description' => 'Siswa diminta membuat diagram rantai makanan di sawah dan menjelaskan peran masing-masing organisme.',
                'file_path'   => null,
                'deadline'    => date('Y-m-d H:i:s', strtotime('+3 days')),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'class_id'    => $classes[1]['id'] ?? $classes[0]['id'],
                'subject_id'  => $subjects[1]['id'] ?? $subjects[0]['id'],
                'teacher_id'  => $teachers[1]['id'] ?? $teachers[0]['id'],
                'title'       => 'Ulangan Harian Kalimat Efektif',
                'type'        => 'Ulangan',
                'description' => 'Evaluasi pemahaman siswa mengenai struktur kalimat efektif dan penggunaan tanda baca yang benar.',
                'file_path'   => null,
                'deadline'    => date('Y-m-d H:i:s', strtotime('+1 day')),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'class_id'    => $classes[1]['id'] ?? $classes[0]['id'],
                'subject_id'  => $subjects[2]['id'] ?? $subjects[0]['id'],
                'teacher_id'  => $teachers[2]['id'] ?? $teachers[0]['id'],
                'title'       => 'Materi Sejarah Kerajaan Majapahit',
                'type'        => 'Materi',
                'description' => 'Pembahasan mendalam mengenai masa kejayaan Majapahit di bawah kepemimpinan Hayam Wuruk dan Gajah Mada.',
                'file_path'   => null,
                'deadline'    => date('Y-m-d H:i:s', strtotime('+10 days')),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'class_id'    => $classes[0]['id'],
                'subject_id'  => $subjects[1]['id'] ?? $subjects[0]['id'],
                'teacher_id'  => $teachers[0]['id'],
                'title'       => 'Tugas Menulis Puisi Bebas',
                'type'        => 'Tugas',
                'description' => 'Buatlah satu bait puisi dengan tema "Lingkungan" dan kumpulkan dalam format PDF.',
                'file_path'   => null,
                'deadline'    => date('Y-m-d H:i:s', strtotime('+5 days')),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        $db->table('assignments')->insertBatch($data);
    }
}
