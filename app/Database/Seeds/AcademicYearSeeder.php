<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'year'       => '2025/2026',
                'semester'   => 'Ganjil',
                'status'     => 'Active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'year'       => '2025/2026',
                'semester'   => 'Genap',
                'status'     => 'Inactive',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        $this->db->table('academic_years')->insertBatch($data);
    }
}
