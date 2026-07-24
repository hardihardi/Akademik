<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhotoToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'photo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'email',
            ],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'photo');
    }
}
