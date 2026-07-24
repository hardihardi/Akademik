<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (session()->get('role') == 'kepsek') {
            return redirect()->to('/kepsek/dashboard');
        }

        $db = \Config\Database::connect();
        
        $activeYear = $db->table('academic_years')->where('status', 'Active')->get()->getRowArray();
        $academicYearId = $activeYear ? $activeYear['id'] : null;

        $stats = cache()->remember('dashboard_stats_' . ($academicYearId ?? 'default'), 300, function() use ($db, $academicYearId) {
            $baseClasses = $db->table('classes');
            if ($academicYearId) {
                $baseClasses->where('academic_year_id', $academicYearId);
            }

            return [
                'students' => $db->table('students')->countAllResults(),
                'teachers' => $db->table('teachers')->countAllResults(),
                'classes' => $baseClasses->countAllResults(),
                'users' => $db->table('users')->countAllResults(),
                'activeYear' => $db->table('academic_years')->where('status', 'Active')->get()->getRowArray()
            ];
        });
        
        $recentUsers = $db->table('users')
            ->select('users.*, roles.name as role_name')
            ->join('users_roles', 'users_roles.user_id = users.id', 'left')
            ->join('roles', 'roles.id = users_roles.role_id', 'left')
            ->orderBy('users.created_at', 'DESC')
            ->limit(10) // Fetch a bit more for the dashboard table
            ->get()->getResultArray();

        // Admin Specific Analytics
        $adminChartData = [];
        if (session()->get('role') == 'admin') {
            $classStudentsQuery = $db->table('classes')
                ->select('classes.name, COUNT(students.id) as count')
                ->join('students', 'students.class_id = classes.id', 'left');
            
            if ($academicYearId) {
                $classStudentsQuery->where('classes.academic_year_id', $academicYearId);
            }

            $adminChartData['classStudents'] = $classStudentsQuery->groupBy('classes.id')
                ->get()->getResultArray();
            
            $adminChartData['genderStats'] = $db->table('students')
                ->select('gender, COUNT(*) as count')
                ->groupBy('gender')
                ->get()->getResultArray();
        }

        $studentData = null;
        $teacherData = [];
        $parentData = [];
        if (session()->get('role') == 'guru' || session()->get('role') == 'wali_kelas') {
            // Get teacher record
            $teacher = $db->table('teachers')
                          ->where('user_id', session()->get('id'))
                          ->get()->getRowArray();

            if ($teacher) {
                $teacherData['info'] = $teacher;

                // Get assigned classes & subjects
                $assignmentsQuery = $db->table('teacher_assignments')
                                                 ->select('teacher_assignments.*, classes.name as class_name, subjects.name as subject_name')
                                                 ->join('classes', 'classes.id = teacher_assignments.class_id')
                                                 ->join('subjects', 'subjects.id = teacher_assignments.subject_id')
                                                 ->where('teacher_assignments.teacher_id', $teacher['id']);
                
                if ($academicYearId) {
                    $assignmentsQuery->where('teacher_assignments.academic_year_id', $academicYearId);
                }
                
                $teacherData['assignments'] = $assignmentsQuery->get()->getResultArray();
                
                // Get Teaching Schedule
                $scheduleQuery = $db->table('schedules')
                                               ->select('schedules.*, classes.name as class_name, subjects.name as subject_name')
                                               ->join('classes', 'classes.id = schedules.class_id')
                                               ->join('subjects', 'subjects.id = schedules.subject_id')
                                               ->where('schedules.teacher_id', $teacher['id']);
                
                if ($academicYearId) {
                    $scheduleQuery->where('schedules.academic_year_id', $academicYearId);
                }

                $teacherData['schedules'] = $scheduleQuery->orderBy('FIELD(day, "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu")')
                                               ->orderBy('start_time', 'ASC')
                                               ->get()->getResultArray();

                // Get Homeroom Class & Students
                $homeroomClass = $db->table('homeroom_assignments')
                                    ->select('homeroom_assignments.*, classes.name as class_name')
                                    ->join('classes', 'classes.id = homeroom_assignments.class_id')
                                    ->where('homeroom_assignments.teacher_id', $teacher['id'])
                                    ->where('homeroom_assignments.academic_year_id', $academicYearId)
                                    ->get()->getRowArray();

                if ($homeroomClass) {
                    $teacherData['homeroom_class'] = $homeroomClass;
                    $teacherData['homeroom_students'] = $db->table('students')
                                                           ->where('class_id', $homeroomClass['class_id'])
                                                           ->orderBy('full_name', 'ASC')
                                                           ->get()->getResultArray();
                } else {
                    $teacherData['homeroom_class'] = null;
                    $teacherData['homeroom_students'] = [];
                }

                // Get Students by Subjects (Grouped by Class)
                $subjectClasses = $db->table('teacher_assignments')
                                     ->select('classes.id, classes.name')
                                     ->join('classes', 'classes.id = teacher_assignments.class_id')
                                     ->where('teacher_assignments.teacher_id', $teacher['id'])
                                     ->where('teacher_assignments.academic_year_id', $academicYearId)
                                     ->groupBy('classes.id')
                                     ->get()->getResultArray();

                $teacherData['subject_students'] = [];
                foreach ($subjectClasses as $sc) {
                    $students = $db->table('students')
                                   ->where('class_id', $sc['id'])
                                   ->orderBy('full_name', 'ASC')
                                   ->get()->getResultArray();
                    
                    $teacherData['subject_students'][] = [
                        'class_name' => $sc['name'],
                        'students' => $students
                    ];
                }

                // Get Recent Assignments with grading count
                $pendingSubquery = "(SELECT COUNT(*) FROM submissions WHERE submissions.assignment_id = assignments.id AND submissions.status = 'submitted')";
                
                $recentAssignmentsQuery = $db->table('assignments')
                                                       ->select('assignments.*, subjects.name as subject_name, classes.name as class_name')
                                                       ->select($pendingSubquery . ' as pending_count')
                                                       ->join('subjects', 'subjects.id = assignments.subject_id')
                                                       ->join('classes', 'classes.id = assignments.class_id')
                                                       ->where('assignments.teacher_id', $teacher['id']);
                
                if ($academicYearId) {
                    $recentAssignmentsQuery->where('assignments.academic_year_id', $academicYearId);
                }

                $teacherData['recentAssignments'] = $recentAssignmentsQuery->orderBy('assignments.created_at', 'DESC')
                                                       ->limit(5)
                                                       ->get()->getResultArray();

                // Get All Pending Grading Reminders across all types
                $gradingQuery = $db->table('assignments')
                                                      ->select('assignments.id, assignments.title, assignments.type, subjects.name as subject_name, classes.name as class_name')
                                                      ->select($pendingSubquery . ' as pending_count')
                                                      ->join('subjects', 'subjects.id = assignments.subject_id')
                                                      ->join('classes', 'classes.id = assignments.class_id')
                                                      ->where('assignments.teacher_id', $teacher['id'])
                                                      ->where($pendingSubquery . ' > 0', null, false);
                
                if ($academicYearId) {
                    $gradingQuery->where('assignments.academic_year_id', $academicYearId);
                }

                $teacherData['gradingReminders'] = $gradingQuery->orderBy('assignments.deadline', 'ASC')
                                                      ->get()->getResultArray();

                // Get Class Announcements
                $teacherData['announcements'] = $db->table('announcements')
                                                   ->whereIn('target_role', ['all', 'teacher'])
                                                   ->orderBy('created_at', 'DESC')
                                                   ->limit(5)
                                                   ->get()->getResultArray();
            }
        }

        if (session()->get('role') == 'ortu') {
            $student = $db->table('students')
                          ->select('students.*, classes.name as class_name')
                          ->join('classes', 'classes.id = students.class_id', 'left')
                          ->where('user_id', session()->get('id'))
                          ->get()->getRowArray();
            
            if ($student) {
                // Attendance Stats
                $attendanceQuery = $db->table('attendance')
                                 ->where('student_id', $student['id']);
                
                if ($academicYearId) {
                    $attendanceQuery->where('academic_year_id', $academicYearId);
                }

                $attendance = $attendanceQuery->get()->getResultArray();
                
                $totalAttendance = count($attendance);
                $statsCount = ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0];
                foreach ($attendance as $att) {
                    if (isset($statsCount[$att['status']])) {
                        $statsCount[$att['status']]++;
                    }
                }
                
                $presentPerc = $totalAttendance > 0 ? round(($statsCount['H'] / $totalAttendance) * 100) : 0;
                $permissionPerc = $totalAttendance > 0 ? round((($statsCount['I'] + $statsCount['S']) / $totalAttendance) * 100) : 0;
                $alphaPerc = $totalAttendance > 0 ? round(($statsCount['A'] / $totalAttendance) * 100) : 0;
 
                 // Recent Grades (Last 5)
                $recentGradesQuery = $db->table('grades')
                                   ->select('grades.*, subjects.name as subject_name')
                                   ->join('subjects', 'subjects.id = grades.subject_id')
                                   ->where('student_id', $student['id']);
                
                if ($academicYearId) {
                    $recentGradesQuery->where('academic_year_id', $academicYearId);
                }

                $recentGrades = $recentGradesQuery->orderBy('created_at', 'DESC')
                                   ->limit(5)
                                   ->get()->getResultArray();
 
                 // Recent Assignments (Active)
                $recentAssignmentsQuery = $db->table('assignments')
                                        ->select('assignments.*, subjects.name as subject_name, submissions.status as sub_status')
                                        ->join('subjects', 'subjects.id = assignments.subject_id', 'left')
                                        ->join('submissions', 'submissions.assignment_id = assignments.id AND submissions.student_id = ' . $student['id'], 'left')
                                        ->where('assignments.class_id', $student['class_id'])
                                        ->where('assignments.deadline >=', date('Y-m-d H:i:s'));
                
                if ($academicYearId) {
                    $recentAssignmentsQuery->where('assignments.academic_year_id', $academicYearId);
                }

                $recentAssignments = $recentAssignmentsQuery->orderBy('assignments.deadline', 'ASC')
                                        ->limit(3)
                                        ->get()->getResultArray();

                // Performance Summary logic: Weighted Average (Daily 40%, UTS 30%, UAS 30%)
                $activeYearRecord = $db->table('academic_years')->where('status', 'Active')->get()->getRowArray();
                $academicYearId = $activeYearRecord['id'] ?? null;

                $gradesRaw = $db->table('grades')
                               ->select('subject_id, type, score')
                               ->where('student_id', $student['id']);
                
                if ($academicYearId) {
                    $gradesRaw->where('academic_year_id', $academicYearId);
                }
                
                $gradesData = $gradesRaw->get()->getResultArray();
                
                $subjectsGrades = [];
                foreach ($gradesData as $g) {
                    $subjectsGrades[$g['subject_id']][$g['type']] = $g['score'];
                }

                $totalFinalScore = 0;
                $subjectCount = count($subjectsGrades);
                
                foreach ($subjectsGrades as $sid => $types) {
                    $tugas = $types['Tugas'] ?? 0;
                    $uts = $types['UTS'] ?? 0;
                    $uas = $types['UAS'] ?? 0;
                    $weights = get_assessment_weights();
                    $finalScore = ($tugas * $weights['tugas']) + ($uts * $weights['uts']) + ($uas * $weights['uas']);
                    $totalFinalScore += $finalScore;
                }

                $overallAvg = $subjectCount > 0 ? round($totalFinalScore / $subjectCount) : 0;

                // Announcements for Parents
                $announcements = $db->table('announcements')
                                    ->groupStart()
                                        ->whereIn('target_role', ['all', 'ortu'])
                                        ->orWhere('class_id', $student['class_id'])
                                    ->groupEnd()
                                    ->orderBy('created_at', 'DESC')
                                    ->limit(5)
                                    ->get()->getResultArray();

                $summaryText = $student['full_name'] . " menunjukkan perkembangan akademik yang ";
                if ($overallAvg >= 85) { $summaryText .= "sangat baik. "; }
                elseif ($overallAvg >= 75) { $summaryText .= "baik. "; }
                else { $summaryText .= "cukup. "; }

                $summaryText .= "Nilai rata-rata saat ini adalah " . $overallAvg . ", dengan kehadiran " . $presentPerc . "%. ";
                
                $parentData = [
                    'student' => $student,
                    'attendance_stats' => [
                        'total' => $totalAttendance,
                        'present' => $presentPerc,
                        'permission' => $permissionPerc,
                        'alpha' => $alphaPerc,
                    ],
                    'grades' => $recentGrades,
                    'assignments' => $recentAssignments,
                    'announcements' => $announcements,
                    'overall_avg' => $overallAvg,
                    'summary' => $summaryText
                ];
                
                $studentData = $parentData; // Maintain legacy key if needed by view
            }
        }

        $data = [
            'title' => 'Dashboard - SIAkad',
            'user' => session()->get(),
            'stats' => $stats,
            'studentData' => $studentData,
            'recentUsers' => $recentUsers,
            'teacherData' => $teacherData,
            'parentData' => $parentData,
            'adminChartData' => $adminChartData
        ];
        return view('home', $data);
    }
}
