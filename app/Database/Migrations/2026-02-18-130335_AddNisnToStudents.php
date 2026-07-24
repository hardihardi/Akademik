<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNisnToStudents extends Migration
{
    public function up()
    {
        $fields = [
            'nisn' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
                'after'      => 'nis',
                'null'       => true,
            ],
        ];
        $this->forge->addColumn('students', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('students', 'nisn');
    }
}
