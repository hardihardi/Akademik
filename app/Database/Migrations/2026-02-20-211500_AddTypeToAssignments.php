<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTypeToAssignments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('assignments', [
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['Materi', 'Tugas', 'Ulangan', 'UTS', 'UAS', 'Sikap'],
                'default'    => 'Tugas',
                'after'      => 'title'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('assignments', 'type');
    }
}
