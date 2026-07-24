<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DetailedAssignmentSeeder extends Seeder
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

        $classes = $db->table('classes')->get()->getResultArray();
        $subjects = $db->table('subjects')->get()->getResultArray();
        
        // Map subject names to detailed content
        $subjectContent = [
            'Pendidikan Agama Islam' => [
                'materials' => [
                    ['title' => 'Adab Terhadap Orang Tua dan Guru', 'desc' => 'Materi tentang pentingnya menghormati orang tua dan guru dalam Islam.'],
                    ['title' => 'Kisah Keteladanan Nabi Muhammad SAW', 'desc' => 'Mempelajari sifat-sifat mulia Rasulullah yang harus dicontoh.'],
                ],
                'tasks' => [
                    ['title' => 'Setoran Hafalan Surat Pendek', 'desc' => 'Siswa diminta merekam hafalan surat Al-Maun dan mengirimkan videonya.'],
                ]
            ],
            'Pendidikan Kewarganegaraan' => [
                'materials' => [
                    ['title' => 'Nilai-Nilai Pancasila dalam Kehidupan', 'desc' => 'Pembahasan penerapan sila-sila Pancasila di lingkungan sekolah.'],
                ],
                'tasks' => [
                    ['title' => 'Tugas Kliping Lambang Negara', 'desc' => 'Buatlah kliping tentang Garuda Pancasila dan maknanya.'],
                ]
            ],
            'Bahasa Indonesia' => [
                'materials' => [
                    ['title' => 'Mengenal Puisi dan Prosa', 'desc' => 'Perbedaan antara teks puisi dan teks deskripsi/prosa.'],
                    ['title' => 'Teknik Menulis Pantun Nasehat', 'desc' => 'Langkah-langkah membuat pantun dengan sajak a-b-a-b.'],
                ],
                'tasks' => [
                    ['title' => 'Menulis Puisi Tema Lingkungan', 'desc' => 'Buatlah satu puisi bebas bertema kebersihan lingkungan sekolah.'],
                ]
            ],
            'Matematika' => [
                'materials' => [
                    ['title' => 'Konsep Dasar Perkalian dan Pembagian', 'desc' => 'Materi visual tentang perkalian sebagai penjumlahan berulang.'],
                ],
                'tasks' => [
                    ['title' => 'Latihan Soal Cerita Matematika', 'desc' => 'Kerjakan soal halaman 45-46 di buku paket dan kumpulkan fotonya.'],
                ]
            ],
            'Ilmu Pengetahuan Alam' => [
                'materials' => [
                    ['title' => 'Siklus Hidup Hewan dan Tumbuhan', 'desc' => 'Penjelasan tentang metamorfosis sempurna dan tidak sempurna.'],
                ],
                'tasks' => [
                    ['title' => 'Pengamatan Kacang Hijau', 'desc' => 'Laporan mingguan pengamatan pertumbuhan biji kacang hijau di kapas basah.'],
                ]
            ],
            'Ilmu Pengetahuan Sosial' => [
                'materials' => [
                    ['title' => 'Keragaman Budaya di Indonesia', 'desc' => 'Mengenal rumah adat, pakaian, dan tarian dari berbagai provinsi.'],
                ],
                'tasks' => [
                    ['title' => 'Menggambar Peta Pulau Jawa', 'desc' => 'Gambarlah peta pulau jawa lengkap dengan batas provinsi dan ibu kotanya.'],
                ]
            ],
            'Seni Budaya dan Prakarya' => [
                'materials' => [
                    ['title' => 'Teknik Menggambar Imajinatif', 'desc' => 'Mengenal gradasi warna dan komposisi dalam menggambar pemandangan.'],
                ],
                'tasks' => [
                    ['title' => 'Prakarya dari Bahan Bekas', 'desc' => 'Membuat tempat pensil kreatif menggunakan botol plastik bekas.'],
                ]
            ],
            'Pendidikan Jasmani' => [
                'materials' => [
                    ['title' => 'Teknik Dasar Gerak Lokomotor', 'desc' => 'Mengenal gerakan lari, lompat, dan jalan yang benar.'],
                ],
                'tasks' => [
                    ['title' => 'Praktik Senam Irama', 'desc' => 'Lakukan gerakan senam sesuai video instruksi dan kirimkan buktinya.'],
                ]
            ],
            'Bahasa Inggris' => [
                'materials' => [
                    ['title' => 'Self Introduction and Greetings', 'desc' => 'How to introduce yourself and greet friends in English professionally.'],
                ],
                'tasks' => [
                    ['title' => 'Writing Task: My Daily Routine', 'desc' => 'Write 5 simple sentences about what you do from morning to night.'],
                ]
            ],
            'Bahasa Arab' => [
                'materials' => [
                    ['title' => 'Kosakata Anggota Keluarga (Usroti)', 'desc' => 'Mengenal sebutan Ayah, Ibu, Kakek, dan Nenek dalam Bahasa Arab.'],
                ],
                'tasks' => [
                    ['title' => 'Menyalin Huruf Hijaiyah Berharokat', 'desc' => 'Salinlah 10 huruf hijaiyah pertama dengan harokat fathah, kasroh, dan dhommah.'],
                ]
            ],
        ];

        echo "Populating detailed materials and assignments...\n";
        $db->query('SET FOREIGN_KEY_CHECKS=0');
        $db->table('assignments')->truncate(); // Pure reset
        $db->query('SET FOREIGN_KEY_CHECKS=1');

        foreach ($classes as $class) {
            foreach ($subjects as $subject) {
                // Get the assigned teacher for this class-subject
                $assignmentInfo = $db->table('teacher_assignments')
                                    ->where('class_id', $class['id'])
                                    ->where('subject_id', $subject['id'])
                                    ->get()->getRowArray();
                
                $teacherId = $assignmentInfo ? $assignmentInfo['teacher_id'] : null;
                
                if (!$teacherId) continue;

                $content = $subjectContent[$subject['name']] ?? null;
                if (!$content) continue;

                // Create Materials
                foreach ($content['materials'] as $m) {
                    $db->table('assignments')->insert([
                        'class_id'    => $class['id'],
                        'subject_id'  => $subject['id'],
                        'teacher_id'  => $teacherId,
                        'title'       => $m['title'],
                        'type'        => 'Materi',
                        'description' => $m['desc'],
                        'file_path'   => null,
                        'deadline'    => date('Y-m-d H:i:s', strtotime('+14 days')),
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s'),
                    ]);
                }

                // Create Tasks
                foreach ($content['tasks'] as $t) {
                    $db->table('assignments')->insert([
                        'class_id'    => $class['id'],
                        'subject_id'  => $subject['id'],
                        'teacher_id'  => $teacherId,
                        'title'       => $t['title'],
                        'type'        => 'Tugas',
                        'description' => $t['desc'],
                        'file_path'   => null,
                        'deadline'    => date('Y-m-d H:i:s', strtotime('+7 days')),
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s'),
                    ]);
                }
            }
            echo "Detailed assignments for {$class['name']} populated.\n";
        }

        echo "Detailed assignment population completed successfully.\n";
    }
}
