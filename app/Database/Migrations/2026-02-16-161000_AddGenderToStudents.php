<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGenderToStudents extends Migration
{
    public function up()
    {
        $fields = [
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['L', 'P'],
                'default'    => 'L',
                'after'      => 'full_name',
            ],
        ];
        $this->forge->addColumn('students', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('students', 'gender');
    }
}
