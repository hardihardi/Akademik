<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $admin = $db->table('users')->where('role', 'admin')->get()->getRow();
        
        if (!$admin) {
            // Fallback to any user if no admin exists
            $admin = $db->table('users')->get()->getRow();
        }

        if (!$admin) return;

        $authorId = $admin->id;
        $classes = $db->table('classes')->limit(2)->get()->getResultArray();

        $data = [
            [
                'title'       => 'Selamat Datang di SIAKAD SD Al-Ukhuwah',
                'content'     => 'Kami senang menyambut Anda di Sistem Informasi Akademik (SIAKAD) baru kami. Gunakan platform ini untuk memantau nilai, kehadiran, dan informasi penting lainnya.',
                'target_role' => 'all',
                'author_id'   => $authorId,
                'class_id'    => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'title'       => 'Rapat Kerja Guru Semester Ganjil',
                'content'     => 'Diberitahukan kepada seluruh Bapak/Ibu Guru bahwa rapat koordinasi persiapan semester ganjil akan dilaksanakan pada hari Senin depan pukul 09:00 WIB.',
                'target_role' => 'teacher',
                'author_id'   => $authorId,
                'class_id'    => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'title'       => 'Pengingat Pembayaran Iuran Sekolah',
                'content'     => 'Mohon kerjasamanya kepada seluruh Orang Tua murid untuk menyelesaikan administrasi sebelum pekan ujian dilaksanakan.',
                'target_role' => 'all',
                'author_id'   => $authorId,
                'class_id'    => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'title'       => 'Jadwal Ekstrakurikuler Pramuka',
                'content'     => 'Kegiatan Pramuka untuk kelas 3-6 akan dilaksanakan setiap hari Sabtu mulai pukul 08:00 WIB. Mohon membawa perlengkapan lengkap.',
                'target_role' => 'student',
                'author_id'   => $authorId,
                'class_id'    => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        // Add class specific announcements if available
        if (!empty($classes)) {
            foreach ($classes as $class) {
                $data[] = [
                    'title'       => 'Info Penting Kelas ' . $class['name'],
                    'content'     => 'Ada pembaruan mengenai proyek kelas untuk siswa ' . $class['name'] . '. Silakan cek menu Tugas untuk detail lebih lanjut.',
                    'target_role' => 'student',
                    'author_id'   => $authorId,
                    'class_id'    => $class['id'],
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ];
            }
        }

        foreach ($data as $item) {
            $db->table('announcements')->insert($item);
        }
    }
}
