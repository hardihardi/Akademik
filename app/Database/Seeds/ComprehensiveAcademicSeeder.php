<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ComprehensiveAcademicSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // 1. Get Active Academic Year
        $activeYear = $db->table('academic_years')->where('status', 'Active')->get()->getRowArray();
        if (!$activeYear) {
            echo "No active academic year found.\n";
            return;
        }
        $academicYearId = $activeYear['id'];
        $semesterCode = ($activeYear['semester'] == 'Ganjil') ? '1' : '2';

        echo "Targeting Academic Year: {$activeYear['year']} ({$activeYear['semester']}) - ID: {$academicYearId}\n";

        $classes = $db->table('classes')->get()->getResultArray();
        $subjects = $db->table('subjects')->get()->getResultArray();
        $teachers = $db->table('teachers')->get()->getResultArray();

        // 2. Ensure Teacher Assignments exist for this year
        echo "Updating teacher assignments...\n";
        foreach ($classes as $class) {
            foreach ($subjects as $subject) {
                $exists = $db->table('teacher_assignments')
                            ->where('class_id', $class['id'])
                            ->where('subject_id', $subject['id'])
                            ->where('academic_year_id', $academicYearId)
                            ->countAllResults();
                
                if ($exists == 0) {
                    // Find a teacher (deterministic or random)
                    $teacherIndex = ($class['id'] + $subject['id']) % count($teachers);
                    $teacher = $teachers[$teacherIndex];
                    
                    $db->table('teacher_assignments')->insert([
                        'teacher_id' => $teacher['id'],
                        'class_id' => $class['id'],
                        'subject_id' => $subject['id'],
                        'academic_year_id' => $academicYearId,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }

        // 3. Clear existing assignments for this year to avoid duplicates if re-run
        echo "Clearing existing assignments for this year...\n";
        // $db->table('assignments')->where('academic_year_id', $academicYearId)->delete();

        // 4. Create Detailed Data
        $assignmentTypes = ['Materi', 'Tugas', 'Ulangan', 'Sikap', 'UTS', 'UAS'];
        
        foreach ($classes as $class) {
            echo "Processing {$class['name']}...\n";
            $students = $db->table('students')->where('class_id', $class['id'])->get()->getResultArray();
            
            foreach ($subjects as $subject) {
                // Get teacher
                $tAss = $db->table('teacher_assignments')
                          ->where('class_id', $class['id'])
                          ->where('subject_id', $subject['id'])
                          ->where('academic_year_id', $academicYearId)
                          ->get()->getRowArray();
                
                $teacherId = $tAss['teacher_id'];

                foreach ($assignmentTypes as $type) {
                    $title = "";
                    $desc = "";
                    switch ($type) {
                        case 'Materi':
                            $title = "Materi: Pendalaman " . $subject['name'] . " Bab 1";
                            $desc = "Silahkan pelajari materi ini dengan seksama untuk persiapan kuis.";
                            break;
                        case 'Tugas':
                            $title = "Tugas Mandiri: " . $subject['name'];
                            $desc = "Kerjakan latihan soal di buku paket halaman 12-15.";
                            break;
                        case 'Ulangan':
                            $title = "Ulangan Harian 1: " . $subject['name'];
                            $desc = "Ulangan materi bab 1. Kerjakan dengan jujur.";
                            break;
                        case 'Sikap':
                            $title = "Penilaian Sikap: " . $subject['name'];
                            $desc = "Observasi kedisiplinan dan keaktifan di kelas.";
                            break;
                        case 'UTS':
                            $title = "Ujian Tengah Semester: " . $subject['name'];
                            $desc = "Pastikan membawa kartu ujian.";
                            break;
                        case 'UAS':
                            $title = "Ujian Akhir Semester: " . $subject['name'];
                            $desc = "Persiapkan diri dengan baik.";
                            break;
                    }

                    $assignmentId = $db->table('assignments')->insert([
                        'class_id' => $class['id'],
                        'subject_id' => $subject['id'],
                        'teacher_id' => $teacherId,
                        'academic_year_id' => $academicYearId,
                        'title' => $title,
                        'type' => $type,
                        'description' => $desc,
                        'deadline' => date('Y-m-d H:i:s', strtotime('+7 days')),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    
                    // 5. Create Submissions and Grades
                    if ($type != 'Materi') {
                        foreach ($students as $student) {
                            $score = rand(70, 95);
                            
                            // Insert Submission
                            $db->table('submissions')->insert([
                                'assignment_id' => $assignmentId,
                                'student_id' => $student['id'],
                                'file_path' => null,
                                'grade' => $score,
                                'status' => 'reviewed',
                                'feedback' => 'Bagus, teruskan prestasimu!',
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                            
                            // If it's UTS or UAS, insert directly into grades
                            if (in_array($type, ['UTS', 'UAS'])) {
                                $db->table('grades')->insert([
                                    'student_id' => $student['id'],
                                    'subject_id' => $subject['id'],
                                    'academic_year_id' => $academicYearId,
                                    'semester' => $semesterCode,
                                    'type' => $type,
                                    'score' => $score,
                                    'description' => 'Hasil ' . $type,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                            }
                        }
                    }
                }

                // 6. Calculate and insert "Tugas" grade (average of Tugas, Ulangan, Sikap)
                foreach ($students as $student) {
                    $avgGrade = $db->table('submissions')
                                  ->join('assignments', 'assignments.id = submissions.assignment_id')
                                  ->where('submissions.student_id', $student['id'])
                                  ->where('assignments.subject_id', $subject['id'])
                                  ->whereIn('assignments.type', ['Tugas', 'Ulangan', 'Sikap'])
                                  ->where('assignments.academic_year_id', $academicYearId)
                                  ->selectAvg('grade')
                                  ->get()->getRowArray();
                    
                    if ($avgGrade['grade']) {
                        $db->table('grades')->insert([
                            'student_id' => $student['id'],
                            'subject_id' => $subject['id'],
                            'academic_year_id' => $academicYearId,
                            'semester' => $semesterCode,
                            'type' => 'Tugas',
                            'score' => round($avgGrade['grade']),
                            'description' => 'Rata-rata Tugas, Ulangan, dan Sikap',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
            }
        }

        echo "Comprehensive academic data population completed successfully.\n";
    }
}
