<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Phase1DataIntegrity extends Migration
{
    public function up()
    {
        // 1. Add KKM and category to subjects
        $this->forge->addColumn('subjects', [
            'kkm' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 70,
                'after'      => 'description',
            ],
            'category' => [
                'type'       => 'ENUM',
                'constraint' => ['Wajib', 'Muatan Lokal'],
                'default'    => 'Wajib',
                'after'      => 'kkm',
            ],
        ]);

        // 2. Add capacity to classes
        $this->forge->addColumn('classes', [
            'capacity' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 30,
                'after'      => 'academic_year',
            ],
        ]);

        // 3. Add is_locked to academic_years
        $this->forge->addColumn('academic_years', [
            'is_locked' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'status',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('subjects', ['kkm', 'category']);
        $this->forge->dropColumn('classes', ['capacity']);
        $this->forge->dropColumn('academic_years', ['is_locked']);
    }
}
