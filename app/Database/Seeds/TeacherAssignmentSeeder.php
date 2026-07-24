<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TeacherAssignmentSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // 1. Get Active Academic Year
        $activeYear = $db->table('academic_years')->where('status', 'Active')->get()->getRow();
        if (!$activeYear) {
            $activeYear = $db->table('academic_years')->get()->getRow();
        }
        
        if (!$activeYear) {
            echo "No academic year found. Please run AcademicYearSeeder first.\n";
            return;
        }

        // 2. Get All Classes
        $classes = $db->table('classes')->get()->getResultArray();
        
        // 3. Get All Subjects
        $subjects = $db->table('subjects')->get()->getResultArray();
        
        // 4. Get All Teachers
        $teachers = $db->table('teachers')->get()->getResultArray();
        
        if (empty($teachers) || empty($classes) || empty($subjects)) {
            echo "Missing base data (teachers, classes, or subjects). Please run respective seeders first.\n";
            return;
        }

        // 5. Get Homeroom Assignments (to identify homeroom teachers)
        $homerooms = $db->table('homeroom_assignments')
                        ->where('academic_year_id', $activeYear->id)
                        ->get()->getResultArray();
        
        $homeroomMap = [];
        foreach ($homerooms as $hr) {
            $homeroomMap[$hr['class_id']] = $hr['teacher_id'];
        }

        // 6. Define Specialized Roles
        // We'll rotate specialize teachers for specialized subjects
        $specSubjects = [
            'Pendidikan Agama Islam', 
            'Pendidikan Jasmani', 
            'Bahasa Inggris', 
            'Bahasa Arab'
        ];
        
        // Filter teachers who are NOT homeroom teachers if possible, 
        // or just use a revolving pool for specs.
        $specTeachersPool = array_slice($teachers, 0, 4); // First 4 teachers for spec
        $specMapping = [];
        foreach ($specSubjects as $index => $subjectName) {
            $specMapping[$subjectName] = $specTeachersPool[$index % count($specTeachersPool)];
        }

        echo "Populating teacher assignments...\n";
        $db->table('teacher_assignments')->truncate(); // Clear existing

        foreach ($classes as $class) {
            $homeroomTeacherId = $homeroomMap[$class['id']] ?? $teachers[array_rand($teachers)]['id'];
            
            foreach ($subjects as $subject) {
                $teacherId = null;
                
                // If it's a specialized subject, use the spec pool
                if (isset($specMapping[$subject['name']])) {
                    $teacherId = $specMapping[$subject['name']]['id'];
                } else {
                    // Otherwise, use homeroom teacher (Core subjects: Pkn, B.Indo, MTK, IPA, IPS, Seni)
                    $teacherId = $homeroomTeacherId;
                }

                $db->table('teacher_assignments')->insert([
                    'teacher_id'       => $teacherId,
                    'class_id'         => $class['id'],
                    'subject_id'       => $subject['id'],
                    'academic_year_id' => $activeYear->id,
                    'created_at'       => date('Y-m-d H:i:s'),
                    'updated_at'       => date('Y-m-d H:i:s'),
                ]);
            }
            echo "Detailed assignments for {$class['name']} populated.\n";
        }

        echo "Teacher assignments population completed successfully.\n";
    }
}
