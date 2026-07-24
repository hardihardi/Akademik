<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/auth/loginProcess', 'Auth::loginProcess');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Home::index', ['filter' => 'authGuard']);
// Teacher Routes
$routes->get('teachers/exportCsv', 'Teacher::exportCsv', ['filter' => 'authGuard']);
$routes->get('teachers/exportPdf', 'Teacher::exportPdf', ['filter' => 'authGuard']);
$routes->resource('teachers', ['controller' => 'Teacher', 'filter' => 'authGuard']);
// Class Routes
$routes->get('classes/exportCsv', 'Classes::exportCsv', ['filter' => 'authGuard']);
$routes->get('classes/exportPdf', 'Classes::exportPdf', ['filter' => 'authGuard']);
$routes->resource('classes', ['controller' => 'Classes', 'filter' => 'authGuard']);

// Subject Routes (Explicit to match methods)
$routes->get('subjects/exportCsv', 'Subjects::exportCsv', ['filter' => 'authGuard']);
$routes->get('subjects/exportPdf', 'Subjects::exportPdf', ['filter' => 'authGuard']);
$routes->get('subjects', 'Subjects::index', ['filter' => 'authGuard']);
$routes->get('subjects/create', 'Subjects::create', ['filter' => 'authGuard']);
$routes->post('subjects/store', 'Subjects::store', ['filter' => 'authGuard']);
$routes->get('subjects/edit/(:num)', 'Subjects::edit/$1', ['filter' => 'authGuard']);
$routes->post('subjects/update/(:num)', 'Subjects::update/$1', ['filter' => 'authGuard']);
$routes->post('subjects/delete/(:num)', 'Subjects::delete/$1', ['filter' => 'authGuard']);

// Student Import & Export Routes
$routes->get('students/import', 'StudentImport::index', ['filter' => 'authGuard']);
$routes->post('students/import/process', 'StudentImport::process', ['filter' => 'authGuard']);
$routes->get('students/import/template', 'StudentImport::downloadTemplate', ['filter' => 'authGuard']);
$routes->get('students/exportCsv', 'Student::exportCsv', ['filter' => 'authGuard']);
$routes->get('students/exportPdf', 'Student::exportPdf', ['filter' => 'authGuard']);

$routes->resource('students', ['controller' => 'Student', 'filter' => 'authGuard']);

$routes->get('academic-years', 'AcademicYear::index', ['filter' => 'authGuard']);
$routes->get('academic-years/create', 'AcademicYear::create', ['filter' => 'authGuard']);
$routes->post('academic-years/store', 'AcademicYear::store', ['filter' => 'authGuard']);
$routes->get('academic-years/edit/(:num)', 'AcademicYear::edit/$1', ['filter' => 'authGuard']);
$routes->post('academic-years/update/(:num)', 'AcademicYear::update/$1', ['filter' => 'authGuard']);
$routes->post('academic-years/delete/(:num)', 'AcademicYear::delete/$1', ['filter' => 'authGuard']);

// Profile Routes
$routes->get('profile', 'Profile::index', ['filter' => 'authGuard']);
$routes->post('profile/update', 'Profile::update', ['filter' => 'authGuard']);


// Parent Dashboard Routes
$routes->group('parent', ['filter' => 'authGuard'], function($routes) {
    $routes->get('attendance', 'ParentDashboard::attendance');
    $routes->get('attendance/permission', 'ParentDashboard::permission');
    $routes->post('attendance/submit_permission', 'ParentDashboard::submit_permission');
    $routes->get('grades', 'ParentDashboard::grades');
    $routes->get('schedule', 'ParentDashboard::schedule');
    $routes->get('announcements', 'ParentDashboard::announcements');
    $routes->get('announcements/view/(:num)', 'ParentDashboard::view_announcement/$1');
    $routes->get('assignments', 'ParentDashboard::assignments');
    $routes->get('assignments/view/(:num)', 'ParentDashboard::view_assignment/$1');
    $routes->post('assignments/submit/(:num)', 'ParentDashboard::submit_assignment/$1');
    $routes->get('reports', 'ParentDashboard::reports');
    $routes->get('reports/download/(:num)', 'ParentDashboard::download_report/$1');
});

// Kepala Sekolah Routes
$routes->group('kepsek', ['filter' => 'authGuard'], function($routes) {
    $routes->get('dashboard', 'KepalaSekolah::dashboard');
    $routes->get('monitoring/grades', 'KepalaSekolah::monitoringGrades');
    $routes->get('monitoring/attendance', 'KepalaSekolah::monitoringAttendance');
    $routes->get('monitoring/teachers', 'KepalaSekolah::monitoringTeachers');
});

// User Routes
$routes->get('users/exportCsv', 'User::exportCsv', ['filter' => 'authGuard']);
$routes->get('users/exportPdf', 'User::exportPdf', ['filter' => 'authGuard']);
// User Routes (Already defined in group below)

// Academic Year Routes
$routes->get('academic-years/exportCsv', 'AcademicYear::exportCsv', ['filter' => 'authGuard']);
$routes->get('academic-years/exportPdf', 'AcademicYear::exportPdf', ['filter' => 'authGuard']);
$routes->get('academic-years', 'AcademicYear::index', ['filter' => 'authGuard']);

// ... (existing routes)

$routes->get('audit-logs/exportCsv', 'AuditLog::exportCsv', ['filter' => 'authGuard']);
$routes->get('audit-logs/exportPdf', 'AuditLog::exportPdf', ['filter' => 'authGuard']);
$routes->get('audit-logs', 'AuditLog::index', ['filter' => 'authGuard']);
$routes->get('homerooms', 'HomeroomAssignment::index', ['filter' => 'authGuard']);
$routes->get('homerooms/create', 'HomeroomAssignment::create', ['filter' => 'authGuard']);
$routes->post('homerooms/store', 'HomeroomAssignment::store', ['filter' => 'authGuard']);
$routes->get('homerooms/edit/(:num)', 'HomeroomAssignment::edit/$1', ['filter' => 'authGuard']);
$routes->post('homerooms/update/(:num)', 'HomeroomAssignment::update/$1', ['filter' => 'authGuard']);
$routes->post('homerooms/delete/(:num)', 'HomeroomAssignment::delete/$1', ['filter' => 'authGuard']);

$routes->get('announcements', 'Announcement::index', ['filter' => 'authGuard']);
$routes->get('announcements/create', 'Announcement::create', ['filter' => 'authGuard']);
$routes->post('announcements/store', 'Announcement::store', ['filter' => 'authGuard']);
$routes->get('announcements/edit/(:num)', 'Announcement::edit/$1', ['filter' => 'authGuard']);
$routes->post('announcements/update/(:num)', 'Announcement::update/$1', ['filter' => 'authGuard']);
$routes->post('announcements/delete/(:num)', 'Announcement::delete/$1', ['filter' => 'authGuard']);
$routes->resource('teacher-assignments', ['controller' => 'TeacherAssignment', 'filter' => 'authGuard']);

// Class Announcement Routes (Guru)
$routes->get('class-announcements', 'ClassAnnouncement::index', ['filter' => 'authGuard']);
$routes->get('class-announcements/create', 'ClassAnnouncement::create', ['filter' => 'authGuard']);
$routes->post('class-announcements/store', 'ClassAnnouncement::store', ['filter' => 'authGuard']);
$routes->post('class-announcements/delete/(:num)', 'ClassAnnouncement::delete/$1', ['filter' => 'authGuard']);

// Teacher Monitoring Routes
$routes->get('attendance-recap', 'TeacherMonitoring::attendanceRecap', ['filter' => 'authGuard']);

// RBAC Routes
$routes->group('roles', ['filter' => 'authGuard'], function($routes) {
    $routes->get('/', 'Role::index');
    $routes->get('create', 'Role::create');
    $routes->post('store', 'Role::store');
    $routes->get('edit/(:num)', 'Role::edit/$1');
    $routes->post('update/(:num)', 'Role::update/$1');
    $routes->post('delete/(:num)', 'Role::delete/$1');
});

$routes->group('permissions', ['filter' => 'authGuard'], function($routes) {
    $routes->get('/', 'Permission::index');
    $routes->get('create', 'Permission::create');
    $routes->post('store', 'Permission::store');
    $routes->get('edit/(:num)', 'Permission::edit/$1');
    $routes->post('update/(:num)', 'Permission::update/$1');
    $routes->post('delete/(:num)', 'Permission::delete/$1');
});

$routes->group('users', ['filter' => 'authGuard'], function($routes) {
    $routes->get('/', 'User::index');
    $routes->get('create', 'User::create');
    $routes->post('store', 'User::store');
    $routes->get('edit/(:num)', 'User::edit/$1');
    $routes->post('update/(:num)', 'User::update/$1');
    $routes->post('delete/(:num)', 'User::delete/$1');
});
$routes->get('academic-years/activate/(:num)', 'AcademicYear::activate/$1', ['filter' => 'authGuard']);
$routes->get('academic-years/lock/(:num)', 'AcademicYear::lock/$1', ['filter' => 'authGuard']);

// Schedule Routes
$routes->get('schedules', 'Schedule::index', ['filter' => 'authGuard']);
$routes->get('schedules/create', 'Schedule::create', ['filter' => 'authGuard']);
$routes->post('schedules/store', 'Schedule::store', ['filter' => 'authGuard']);
$routes->get('schedules/edit/(:num)', 'Schedule::edit/$1', ['filter' => 'authGuard']);
$routes->post('schedules/update/(:num)', 'Schedule::update/$1', ['filter' => 'authGuard']);
$routes->post('schedules/delete/(:num)', 'Schedule::delete/$1', ['filter' => 'authGuard']);

// Assignment Routes
$routes->get('assignments', 'Assignment::index', ['filter' => 'authGuard']);
$routes->get('assignments/create', 'Assignment::create', ['filter' => 'authGuard']);
$routes->post('assignments/store', 'Assignment::store', ['filter' => 'authGuard']);
$routes->get('assignments/edit/(:num)', 'Assignment::edit/$1', ['filter' => 'authGuard']);
$routes->post('assignments/update/(:num)', 'Assignment::update/$1', ['filter' => 'authGuard']);
$routes->post('assignments/delete/(:num)', 'Assignment::delete/$1', ['filter' => 'authGuard']);
$routes->get('assignments/download/(:num)', 'Assignment::download/$1', ['filter' => 'authGuard']);
$routes->get('assignments/report/(:num)', 'Assignment::report/$1', ['filter' => 'authGuard']);
$routes->get('assignments/report-pdf/(:num)', 'Assignment::downloadReportPdf/$1', ['filter' => 'authGuard']);
$routes->get('assignments/submissions/(:num)', 'Assignment::submissions/$1', ['filter' => 'authGuard']);
$routes->post('assignments/grade/(:num)', 'Assignment::grade_submission/$1', ['filter' => 'authGuard']);
$routes->get('assignments/download-submission/(:num)', 'Assignment::download_submission/$1', ['filter' => 'authGuard']);

// Notification Routes
$routes->get('notifications', 'Notification::index', ['filter' => 'authGuard']);
$routes->get('notifications/read/(:num)', 'Notification::read/$1', ['filter' => 'authGuard']);
$routes->get('notifications/read-all', 'Notification::readAll', ['filter' => 'authGuard']);
$routes->post('notifications/delete/(:num)', 'Notification::delete/$1', ['filter' => 'authGuard']);

// Teacher Dedicated Schedule 
$routes->get('guru/schedule', 'TeacherSchedule::index', ['filter' => 'authGuard']);


$routes->get('attendance/recap/(:num)', 'Attendance::recap/$1', ['filter' => 'authGuard']); // Detailed monthly recap
$routes->get('attendance', 'Attendance::index', ['filter' => 'authGuard']);
$routes->get('attendance/submissions', 'Attendance::submissions', ['filter' => 'authGuard']);
$routes->post('attendance/verify_submission/(:num)', 'Attendance::verify_submission/$1', ['filter' => 'authGuard']);
$routes->get('attendance/input/(:num)', 'Attendance::input/$1', ['filter' => 'authGuard']);
$routes->post('attendance/store', 'Attendance::store', ['filter' => 'authGuard']);
$routes->get('grades', 'Grades::list', ['filter' => 'authGuard']);

// Grades View Routes
$routes->get('grades/list', 'Grades::list', ['filter' => 'authGuard']);
$routes->get('report', 'Report::index', ['filter' => 'authGuard']);
$routes->get('report/students/(:num)', 'Report::students/$1', ['filter' => 'authGuard']);
$routes->get('report/print/(:num)', 'Report::print/$1', ['filter' => 'authGuard']);
$routes->get('report/notes/(:num)', 'Report::inputNotes/$1', ['filter' => 'authGuard']);
$routes->get('report/sync/(:num)', 'Report::sync/$1', ['filter' => 'authGuard']);
$routes->get('report/download-pdf/(:num)', 'Report::downloadPdf/$1', ['filter' => 'authGuard']);
$routes->post('report/save-notes', 'Report::saveNotes', ['filter' => 'authGuard']);
$routes->get('settings', 'Settings::index', ['filter' => 'authGuard']);
$routes->post('settings/update', 'Settings::update', ['filter' => 'authGuard']);
$routes->get('backup/download', 'Backup::download', ['filter' => 'authGuard']);
$routes->get('ledger', 'Ledger::index', ['filter' => 'authGuard']);
$routes->get('ledger/view/(:num)', 'Ledger::view/$1', ['filter' => 'authGuard']);
$routes->get('ledger/pdf/(:num)', 'Ledger::pdf/$1', ['filter' => 'authGuard']);
$routes->get('ledger/sync/(:num)', 'Ledger::sync/$1', ['filter' => 'authGuard']);
$routes->get('attendance-recap', 'AttendanceRecap::index', ['filter' => 'authGuard']);
$routes->get('attendance-recap/view/(:num)', 'AttendanceRecap::view/$1', ['filter' => 'authGuard']);
$routes->get('attendance-recap/pdf/(:num)', 'AttendanceRecap::pdf/$1', ['filter' => 'authGuard']);
$routes->get('attendance/attendance-recap/(:num)', 'AttendanceRecap::view/$1', ['filter' => 'authGuard']);

