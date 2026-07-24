<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'      => 'admin',
                'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
                'email'         => 'admin@sekolah.id',
                'role'          => 'admin',
                'active'        => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'guru',
                'password_hash' => password_hash('guru123', PASSWORD_BCRYPT),
                'email'         => 'guru@sekolah.id',
                'role'          => 'guru',
                'active'        => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'ortu',
                'password_hash' => password_hash('ortu123', PASSWORD_BCRYPT),
                'email'         => 'ortu@sekolah.id',
                'role'          => 'ortu',
                'active'        => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
