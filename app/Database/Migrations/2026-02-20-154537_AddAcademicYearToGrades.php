<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAcademicYearToGrades extends Migration
{
    public function up()
    {
        $fields = [
            'academic_year_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'after'      => 'semester',
                'null'       => true,
            ],
        ];
        $this->forge->addColumn('grades', $fields);
        
        // Add foreign key if possible (optional but good)
        // $this->db->query("ALTER TABLE grades ADD CONSTRAINT fk_grades_academic_year FOREIGN KEY (academic_year_id) REFERENCES academic_years(id) ON DELETE SET NULL ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->forge->dropColumn('grades', 'academic_year_id');
    }
}
