<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusAndPhotoToTeachers extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Aktif', 'Tidak Aktif'],
                'default'    => 'Aktif',
                'after'      => 'full_name'
            ],
            'photo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'address'
            ],
        ];
        $this->forge->addColumn('teachers', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('teachers', ['status', 'photo']);
    }
}
