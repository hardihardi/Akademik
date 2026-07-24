<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPerformanceIndexes extends Migration
{
    public function up()
    {
        // Index for Grades: Fast report calculation
        $this->db->query("CREATE INDEX idx_grades_student_subject_semester ON grades (student_id, subject_id, semester)");
        
        // Index for Attendance: Fast attendance recap
        $this->db->query("CREATE INDEX idx_attendance_student_date ON attendance (student_id, date)");
        
        // Index for Students: Fast class listing and status filtering
        $this->db->query("CREATE INDEX idx_students_class_status ON students (class_id, status)");
        
        // Index for Teacher Assignments: Fast class assignment lookups
        $this->db->query("CREATE INDEX idx_teacher_assignments_teacher_class ON teacher_assignments (teacher_id, class_id)");
    }

    public function down()
    {
        $this->db->query("DROP INDEX idx_grades_student_subject_semester ON grades");
        $this->db->query("DROP INDEX idx_attendance_student_date ON attendance");
        $this->db->query("DROP INDEX idx_students_class_status ON students");
        $this->db->query("DROP INDEX idx_teacher_assignments_teacher_class ON teacher_assignments");
    }
}
