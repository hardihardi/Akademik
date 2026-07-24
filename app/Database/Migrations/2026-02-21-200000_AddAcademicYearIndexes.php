<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAcademicYearIndexes extends Migration
{
    public function up()
    {
        // Index for Attendance: Faster year-based filtering
        $this->db->query("CREATE INDEX idx_attendance_academic_year_student ON attendance (academic_year_id, student_id)");
        
        // Index for Grades: Faster report card data retrieval
        $this->db->query("CREATE INDEX idx_grades_academic_year_student_semester ON grades (academic_year_id, student_id, semester)");
    }

    public function down()
    {
        $this->db->query("DROP INDEX idx_attendance_academic_year_student ON attendance");
        $this->db->query("DROP INDEX idx_grades_academic_year_student_semester ON grades");
    }
}
