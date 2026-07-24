<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Settings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('settings');
        
        // Seed default values
        $data = [
            ['key' => 'school_name', 'value' => 'SD Al-Ukhuwah Citarik'],
            ['key' => 'school_address', 'value' => 'Jl. Citarik Raya No. 123, Desa Citarik, Kec. Pelabuhan Ratu'],
            ['key' => 'headmaster_name', 'value' => 'Nama Kepala Sekolah'],
            ['key' => 'headmaster_nip', 'value' => '1234567890'],
        ];
        $this->db->table('settings')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
