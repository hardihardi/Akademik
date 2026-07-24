<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToGrades extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Draft', 'Submitted', 'Validated'],
                'default'    => 'Draft',
                'after'      => 'score',
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'status',
            ],
        ];
        $this->forge->addColumn('grades', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('grades', 'status');
        $this->forge->dropColumn('grades', 'description');
    }
}
