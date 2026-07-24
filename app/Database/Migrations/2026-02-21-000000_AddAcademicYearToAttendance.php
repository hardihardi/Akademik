<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAcademicYearToAttendance extends Migration
{
    public function up()
    {
        $this->forge->addColumn('attendance', [
            'academic_year_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'class_id'
            ],
        ]);

        $this->db->query("ALTER TABLE attendance ADD CONSTRAINT fk_attendance_academic_year FOREIGN KEY (academic_year_id) REFERENCES academic_years(id) ON DELETE SET NULL ON UPDATE CASCADE");
        $this->db->query("CREATE INDEX idx_attendance_academic_year ON attendance(academic_year_id)");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE attendance DROP FOREIGN KEY fk_attendance_academic_year");
        $this->db->query("DROP INDEX idx_attendance_academic_year ON attendance");
        $this->forge->dropColumn('attendance', 'academic_year_id');
    }
}
