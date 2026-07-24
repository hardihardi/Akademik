<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEvidenceToAttendance extends Migration
{
    public function up()
    {
        $fields = [
            'evidence_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'note'
            ],
            'is_verified' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'evidence_path'
            ],
        ];
        $this->forge->addColumn('attendance', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('attendance', ['evidence_path', 'is_verified']);
    }
}
