<?php $brand = school_branding(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SIAkad' ?> - <?= $brand['name'] ?></title>
    
    <!-- Favicon -->
    <?php if ($brand['favicon']): ?>
        <link rel="icon" type="image/x-icon" href="<?= $brand['favicon'] ?>">
    <?php endif; ?>
    
    <!-- DNS Prefetch & Preconnect -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Fonts (swap to prevent render-blocking) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet"></noscript>
    
    <!-- Local CSS (Tailwind Compiled + cache-bust) -->
    <?php $cssVersion = filemtime(FCPATH . 'css/style.css') ?: time(); ?>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>?v=<?= $cssVersion ?>">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8fafc;
        }
        /* Custom Scrollbar untuk Sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="antialiased text-slate-800" x-data="{ mobileSidebarOpen: false }">

    <div class="flex h-screen overflow-hidden bg-[#f8f9fc]">
        
        <!-- =========================================================================================
             SIDEBAR BACKDROP (Mobile Only)
             ========================================================================================= -->
        <div x-show="mobileSidebarOpen" 
             x-transition:enter="transition opacity-100 duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition opacity-100 duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileSidebarOpen = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] lg:hidden" x-cloak></div>

        <!-- =========================================================================================
             SIDEBAR
             ========================================================================================= -->
        <aside class="fixed inset-y-0 left-0 z-[70] w-64 bg-[#232659] transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 no-print flex flex-col shadow-2xl"
               :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'" x-cloak>
            
            <div class="h-full flex flex-col overflow-hidden">
                <!-- Sidebar Header -->
                <div class="px-6 py-6 border-b border-indigo-900/50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg overflow-hidden p-1.5">
                            <?php if ($brand['logo']): ?>
                                <img src="<?= $brand['logo'] ?>" class="w-full h-full object-contain" alt="Logo">
                            <?php else: ?>
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <?php endif; ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h2 class="font-extrabold text-white text-[11px] lg:text-xs tracking-tight leading-tight uppercase line-clamp-2"><?= $brand['name'] ?></h2>
                        </div>
                    </div>
                    <!-- Close Button (Mobile) -->
                    <button @click="mobileSidebarOpen = false" class="lg:hidden p-2 rounded-lg hover:bg-white/10 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto sidebar-scroll px-3 space-y-1 py-6">
                    
                    <!-- Dashboard Link -->
                    <?php 
                    $dashboardUrl = session()->get('role') == 'kepsek' ? 'kepsek/dashboard' : 'dashboard';
                    $isDashboardActive = current_url() == base_url($dashboardUrl) || current_url() == base_url('dashboard');
                    ?>
                    <a href="<?= base_url($dashboardUrl) ?>" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group <?= $isDashboardActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-200 hover:bg-white/10 hover:text-white' ?>">
                        <svg class="w-5 h-5 <?= $isDashboardActive ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?php if (session()->get('role') == 'kepsek'): ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            <?php else: ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            <?php endif; ?>
                        </svg>
                        <span class="ml-3 text-sm font-semibold tracking-wide">
                            <?= session()->get('role') == 'kepsek' ? 'Dashboard' : 'Dashboard' ?>
                        </span>
                    </a>

                    <?php if (session()->get('role') == 'admin'): ?>
                    <!-- ==================== MASTER DATA ==================== -->
                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-300/50 uppercase tracking-[0.2em]">Master Data</div>
                    
                    <?php 
                    $master_menus = [
                        ['url' => 'students', 'label' => 'Data Siswa', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        ['url' => 'teachers', 'label' => 'Data Guru', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['url' => 'classes', 'label' => 'Data Kelas', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                        ['url' => 'schedules', 'label' => 'Jadwal Pelajaran', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['url' => 'subjects', 'label' => 'Mata Pelajaran', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        ['url' => 'academic-years', 'label' => 'Tahun Akademik', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['url' => 'teacher-assignments', 'label' => 'Penugasan Guru', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                        ['url' => 'homerooms', 'label' => 'Wali Kelas', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ];
                    foreach ($master_menus as $menu): 
                        $isActive = strpos(current_url(), $menu['url']) !== false;
                    ?>
                    <a href="<?= base_url($menu['url']) ?>" 
                       class="flex items-center px-4 py-2.5 rounded-xl transition-all group <?= $isActive ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-200 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-5 h-5 <?= $isActive ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $menu['icon'] ?>"></path></svg>
                        <span class="ml-3 text-sm font-medium"><?= $menu['label'] ?></span>
                    </a>
                    <?php endforeach; ?>

                    <!-- ==================== AKADEMIK & NILAI ==================== -->
                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-300/50 uppercase tracking-[0.2em]">Akademik & Nilai</div>
                    
                    <?php 
                    $akademik_menus = [
                        ['url' => 'assignments', 'label' => 'Pembelajaran', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['url' => 'attendance', 'label' => 'Kehadiran Siswa', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                        ['url' => 'ledger', 'label' => 'Rekap Nilai', 'icon' => 'M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['url' => 'report', 'label' => 'Rapor Siswa', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    ];
                    foreach ($akademik_menus as $menu): 
                        $isActive = strpos(current_url(), $menu['url']) !== false;
                    ?>
                    <a href="<?= base_url($menu['url']) ?>" 
                       class="flex items-center px-4 py-2.5 rounded-xl transition-all group <?= $isActive ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-200 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-5 h-5 <?= $isActive ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $menu['icon'] ?>"></path></svg>
                        <span class="ml-3 text-sm font-medium"><?= $menu['label'] ?></span>
                    </a>
                    <?php endforeach; ?>

                    <!-- ==================== KOMUNIKASI ==================== -->
                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-300/50 uppercase tracking-[0.2em]">Komunikasi</div>
                    
                    <?php 
                    $isAnnouncements = strpos(current_url(), 'announcements') !== false;
                    ?>
                    <a href="<?= base_url('announcements') ?>" 
                       class="flex items-center px-4 py-2.5 rounded-xl transition-all group <?= $isAnnouncements ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-200 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-5 h-5 <?= $isAnnouncements ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        <span class="ml-3 text-sm font-medium">Pengumuman</span>
                    </a>

                    <!-- ==================== SISTEM & AKSES ==================== -->
                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-300/50 uppercase tracking-[0.2em]">Sistem & Akses</div>
                    
                    <?php 
                    $system_menus = [
                        ['url' => 'users', 'label' => 'Data Pengguna', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        ['url' => 'roles', 'label' => 'Roles (Peran)', 'icon' => 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z'],
                        ['url' => 'permissions', 'label' => 'Permissions', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                        ['url' => 'settings', 'label' => 'Pengaturan Sekolah', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                        ['url' => 'audit-logs', 'label' => 'Log Aktivitas', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ];
                    foreach ($system_menus as $menu): 
                        $isActive = strpos(current_url(), $menu['url']) !== false;
                    ?>
                    <a href="<?= base_url($menu['url']) ?>" 
                       class="flex items-center px-4 py-2.5 rounded-xl transition-all group <?= $isActive ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-200 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-5 h-5 <?= $isActive ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $menu['icon'] ?>"></path></svg>
                        <span class="ml-3 text-sm font-medium"><?= $menu['label'] ?></span>
                    </a>
                    <?php endforeach; ?>

                    <?php endif; ?>

                    <!-- ==================== GURU TOOLS (RBAC) ==================== -->
                    <?php 
                    $guru_menus = [
                        ['url' => 'guru/schedule', 'label' => 'Jadwal Mengajar', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'permission' => 'student.view'],
                        ['url' => 'assignments', 'label' => 'Pembelajaran', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'permission' => 'assignment.manage'],
                        ['url' => 'attendance', 'label' => 'Input Kehadiran', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'permission' => 'attendance.input'],
                        ['url' => 'students', 'label' => 'Data Siswa Kelas', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'permission' => 'student.view'],
                        ['url' => 'announcements', 'label' => 'Pengumuman', 'icon' => 'M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z', 'permission' => 'announcement.view'],
                    ];
                    
                    $visible_guru_menus = array_filter($guru_menus, function($m) {
                        return has_permission($m['permission']);
                    });

                    if ((session()->get('role') == 'guru' || session()->get('role') == 'wali_kelas') && !empty($visible_guru_menus)):
                    ?>
                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-300/50 uppercase tracking-[0.2em]">Menu Guru</div>
                    
                    <?php 
                    foreach ($visible_guru_menus as $menu): 
                        $isActive = strpos(current_url(), $menu['url']) !== false;
                    ?>
                    <a href="<?= base_url($menu['url']) ?>" 
                       class="flex items-center px-4 py-2.5 rounded-xl transition-all group <?= $isActive ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-200 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-5 h-5 <?= $isActive ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $menu['icon'] ?>"></path></svg>
                        <span class="ml-3 text-sm font-medium"><?= $menu['label'] ?></span>
                    </a>
                    <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- ==================== WALI KELAS TOOLS (RBAC) ==================== -->
                    <?php 
                    $wali_menus = [
                        ['url' => 'ledger', 'label' => 'Rekap Nilai', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'permission' => 'ledger.view'],
                        ['url' => 'report', 'label' => 'Cetak Rapor', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'permission' => 'report.view'],
                    ];
                    
                    $visible_wali_menus = array_filter($wali_menus, function($m) {
                        return has_permission($m['permission']);
                    });

                    if (session()->get('role') != 'admin' && !empty($visible_wali_menus)):
                    ?>
                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-300/50 uppercase tracking-[0.2em]">Menu Wali Kelas</div>
                    
                    <?php 
                    foreach ($visible_wali_menus as $menu): 
                        $isActive = strpos(current_url(), $menu['url']) !== false;
                    ?>
                    <a href="<?= base_url($menu['url']) ?>" 
                       class="flex items-center px-4 py-2.5 rounded-xl transition-all group <?= $isActive ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-200 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-5 h-5 <?= $isActive ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $menu['icon'] ?>"></path></svg>
                        <span class="ml-3 text-sm font-medium"><?= $menu['label'] ?></span>
                    </a>
                    <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- ==================== KEPALA SEKOLAH (EXECUTIVE) ==================== -->
                    <?php 
                    $kepsek_menus = [
                        ['url' => 'kepsek/monitoring/teachers', 'label' => 'Monitoring Guru', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'permission' => 'academic.monitor'],
                        ['url' => 'kepsek/monitoring/grades', 'label' => 'Monitoring Nilai', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 3h3m-3 4h3m-6-4h.01M9 16h.01', 'permission' => 'academic.monitor'],
                        ['url' => 'kepsek/monitoring/attendance', 'label' => 'Monitoring Kehadiran', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'permission' => 'academic.monitor'],
                        ['url' => 'announcements', 'label' => 'Pengumuman', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z', 'permission' => 'announcement.view'],
                    ];
                    
                    $visible_kepsek_menus = array_filter($kepsek_menus, function($m) {
                        return has_permission($m['permission']);
                    });

                    if (session()->get('role') == 'kepsek' && !empty($visible_kepsek_menus)):
                    ?>
                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-300/50 uppercase tracking-[0.2em]">Menu Kepala Sekolah</div>
                    
                    <?php 
                    foreach ($visible_kepsek_menus as $menu): 
                        $isActive = strpos(current_url(), $menu['url']) !== false;
                    ?>
                    <a href="<?= base_url($menu['url']) ?>" 
                       class="flex items-center px-4 py-2.5 rounded-xl transition-all group <?= $isActive ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-200 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-5 h-5 <?= $isActive ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $menu['icon'] ?>"></path></svg>
                        <span class="ml-3 text-sm font-medium"><?= $menu['label'] ?></span>
                    </a>
                    <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (session()->get('role') == 'ortu'): 
                        $ortu_menus = [
                            ['url' => 'parent/schedule', 'label' => 'Jadwal Pelajaran', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ['url' => 'parent/assignments', 'label' => 'Pembelajaran Anak', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['url' => 'parent/attendance', 'label' => 'Kehadiran Anak', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                            ['url' => 'parent/grades', 'label' => 'Nilai Anak', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                            ['url' => 'parent/reports', 'label' => 'Rapor Siswa', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                            ['url' => 'parent/announcements', 'label' => 'Pusat Informasi', 'icon' => 'M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z'],
                        ];
                    ?>
                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-300/50 uppercase tracking-[0.2em]">Menu Orang Tua</div>
                    <?php foreach ($ortu_menus as $menu): 
                        $isActive = strpos(current_url(), $menu['url']) !== false;
                    ?>
                    <a href="<?= base_url($menu['url']) ?>" 
                       class="flex items-center px-4 py-2.5 rounded-xl transition-all group <?= $isActive ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-200 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-5 h-5 <?= $isActive ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $menu['icon'] ?>"></path></svg>
                        <span class="ml-3 text-sm font-medium"><?= $menu['label'] ?></span>
                    </a>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </nav>

                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-indigo-900/50 bg-[#1e214d]">
                    <a href="<?= base_url('logout') ?>" class="flex items-center justify-center w-full px-4 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl transition-all duration-300 font-bold text-sm shadow-lg shadow-rose-900/20">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar Aplikasi
                    </a>
                </div>
            </div>
        </aside>

        <!-- =========================================================================================
             MAIN CONTENT WRAPPER
             ========================================================================================= -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#f8f9fc] relative overflow-hidden">
            
            <!-- TOP NAVBAR -->
            <header class="h-16 bg-white border-b border-slate-200 flex-shrink-0 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-40 no-print">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Menu (Mobile) -->
                    <button @click="mobileSidebarOpen = true" class="p-2 -ml-2 text-slate-500 hover:bg-slate-100 rounded-xl lg:hidden transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                    
                    <div class="hidden sm:flex items-center gap-4 text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <span class="text-indigo-600 font-bold uppercase tracking-wider">SIAkad</span>
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="text-slate-600 font-semibold"><?= $title ?? 'Dashboard' ?></span>
                        </div>
                        
                        <!-- Global Academic Year Display -->
                        <div class="flex items-center px-3 py-1 bg-indigo-50 border border-indigo-100 rounded-full">
                            <svg class="w-3.5 h-3.5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest whitespace-nowrap">
                                <?= get_academic_year_display() ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- User Profile & Dropdown -->
                <div class="flex items-center gap-3">
                    <!-- Notifications -->
                    <?php $notifData = unread_notifications(); ?>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="relative p-2 text-slate-500 hover:bg-slate-50 hover:text-indigo-600 rounded-xl transition-all group" title="Notifikasi">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <?php if ($notifData['count'] > 0): ?>
                                <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-rose-500 text-white text-[10px] font-black flex items-center justify-center rounded-full border-2 border-white animate-pulse">
                                    <?= $notifData['count'] > 9 ? '9+' : $notifData['count'] ?>
                                </span>
                            <?php endif; ?>
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="transform opacity-0 scale-95 translate-y-[-10px]"
                             x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="transform opacity-0 scale-95 translate-y-[-10px]"
                             class="absolute right-[-4.5rem] sm:right-0 mt-3 w-[calc(100vw-2.5rem)] sm:w-96 py-3 bg-white rounded-[2rem] shadow-2xl border border-slate-100 z-50 overflow-hidden focus:outline-none" x-cloak>
                            
                            <div class="px-6 py-3 border-b border-slate-50 flex items-center justify-between">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Notifikasi</h3>
                                <?php if ($notifData['count'] > 0): ?>
                                    <a href="<?= base_url('notifications/read-all') ?>" class="text-[10px] font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-wider transition-colors">Baca Semua</a>
                                <?php endif; ?>
                            </div>

                            <div class="max-h-[400px] overflow-y-auto sidebar-scroll">
                                <?php if (empty($notifData['recent'])): ?>
                                    <div class="p-12 text-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-inner ring-4 ring-white">
                                            <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8"></path></svg>
                                        </div>
                                        <p class="text-[11px] text-slate-400 font-black uppercase tracking-widest mt-2">Belum ada kabar baru</p>
                                    </div>
                                <?php else: ?>
                                    <div class="divide-y divide-slate-50">
                                        <?php foreach ($notifData['recent'] as $notif): ?>
                                            <a href="<?= base_url('notifications/read/' . $notif['id']) ?>" class="block px-6 py-4 hover:bg-slate-50 transition-all group <?= !$notif['is_read'] ? 'bg-indigo-50/20' : '' ?>">
                                                <div class="flex gap-4">
                                                    <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center transition-all group-hover:scale-110 <?= !$notif['is_read'] ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-slate-100 text-slate-400' ?>">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-black text-slate-700 truncate group-hover:text-indigo-600 transition-colors"><?= $notif['title'] ?></p>
                                                        <p class="text-[11px] text-slate-500 line-clamp-2 mt-1 leading-relaxed font-medium"><?= $notif['message'] ?></p>
                                                        <div class="flex items-center gap-2 mt-2">
                                                            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest"><?= date('H:i', strtotime($notif['created_at'])) ?> • <?= date('d M', strtotime($notif['created_at'])) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <a href="<?= base_url('notifications') ?>" class="block px-4 py-3 text-center text-[10px] font-black text-slate-400 hover:text-indigo-600 hover:bg-slate-50 transition-all uppercase tracking-[0.3em] border-t border-slate-50">Tampilkan Semua</a>
                        </div>
                    </div>

                    <?php 
                    $displayName = session()->get('full_name');
                    if (!$displayName) {
                        $db = \Config\Database::connect();
                        $userId = session()->get('id');
                        $userRole = session()->get('role');
                        if ($userId) {
                            $user = $db->table('users')->where('id', $userId)->get()->getRowArray();
                            $displayName = $user['full_name'];
                            
                            if (!$displayName) {
                                if ($userRole == 'guru' || $userRole == 'kepsek') {
                                    $teacher = $db->table('teachers')->where('user_id', $userId)->get()->getRowArray();
                                    $displayName = $teacher ? $teacher['full_name'] : $user['username'];
                                } elseif ($userRole == 'ortu') {
                                    $student = $db->table('students')->where('user_id', $userId)->get()->getRowArray();
                                    $displayName = $student ? ($student['parent_name'] ?: $student['full_name']) : $user['username'];
                                } else {
                                    $displayName = $user['username'];
                                }
                            }
                            session()->set('full_name', $displayName);
                        }
                    }
                    ?>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 p-1.5 pl-3 hover:bg-slate-50 rounded-2xl transition-all border border-transparent hover:border-slate-200 group">
                            <div class="text-right hidden md:block leading-tight">
                                <p class="text-xs font-bold text-slate-700 truncate max-w-[150px]"><?= session()->get('full_name') ?: session()->get('username') ?></p>
                                <p class="text-[10px] font-medium text-slate-400 uppercase tracking-widest mt-0.5"><?= session()->get('role') ?></p>
                            </div>
                            <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 border border-indigo-200 group-hover:scale-105 transition-transform overflow-hidden">
                                <?php if(session()->get('photo')): ?>
                                    <img src="<?= get_photo_url(session()->get('photo')) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <?php endif; ?>
                            </div>
                        </button>
                        
                        <!-- Profile Dropdown -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-52 py-2 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden" x-cloak>
                            <a href="<?= base_url('profile') ?>" class="flex items-center px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>
                            <hr class="my-1 border-slate-50">
                            <a href="<?= base_url('logout') ?>" class="flex items-center px-4 py-2.5 text-sm text-rose-500 hover:bg-rose-50 font-bold transition-colors">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- PAGE CONTENT AREA -->
            <div class="flex-1 overflow-y-auto bg-[#f8f9fc] pb-12">
                <div class="max-w-[1680px] mx-auto p-3 sm:p-5 lg:p-6">
                    
                    <!-- Flash Messages -->
                    <div class="no-print">
                        <?php if(session()->getFlashdata('message')): ?>
                            <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center text-white shadow-md shadow-emerald-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-emerald-800 tracking-tight"><?= session()->getFlashdata('message') ?></p>
                                </div>
                                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                            </div>
                        <?php endif; ?>

                        <?php if(session()->getFlashdata('error')): ?>
                            <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-rose-500 rounded-lg flex items-center justify-center text-white shadow-md shadow-rose-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-rose-800 tracking-tight"><?= session()->getFlashdata('error') ?></p>
                                </div>
                                <button @click="show = false" class="text-rose-400 hover:text-rose-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Main Content Render -->
                    <div class="animate-in">
                        <?= $this->renderSection('content') ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Global Delete Confirmation Modal -->
    <div x-data="{ 
            isOpen: false, 
            message: '', 
            formToSubmit: null,
            openModal(customEvent) {
                const originalEvent = customEvent.detail;
                const target = originalEvent.target.closest('form, a');
                if (!target) return;

                this.formToSubmit = target;
                this.message = target.getAttribute('data-confirm-message') || 'Apakah Anda yakin ingin menghapus data ini?';
                this.isOpen = true;
            },
            confirm() {
                if(this.formToSubmit) {
                    if (this.formToSubmit.tagName === 'FORM') {
                        this.formToSubmit.submit();
                    } else if (this.formToSubmit.tagName === 'A') {
                        window.location.href = this.formToSubmit.href;
                    }
                }
            }
         }" 
         @open-delete-modal.window="openModal($event)"
         class="no-print">
        
        <div x-show="isOpen" 
             x-transition:enter="transition opacity-100 duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition opacity-100 duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4" x-cloak>
            
            <div @click.away="isOpen = false" 
                 x-show="isOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="scale-95 opacity-0"
                 x-transition:enter-end="scale-100 opacity-100"
                 class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden">
                
                <!-- Decoration -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-rose-50 rounded-full opacity-50"></div>
                
                <div class="relative">
                    <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </div>

                    <h3 class="text-2xl font-black text-slate-800 tracking-tighter mb-2">Konfirmasi Hapus</h3>
                    <p class="text-slate-500 text-sm font-medium leading-relaxed mb-8" x-text="message"></p>

                    <div class="flex gap-3">
                        <button @click="isOpen = false" class="flex-1 py-4 text-[10px] font-black text-slate-400 tracking-widest uppercase hover:bg-slate-50 rounded-2xl transition-all">Batal</button>
                        <button @click="confirm()" class="flex-[1.5] py-4 bg-rose-600 text-white rounded-2xl text-[10px] font-black tracking-[0.2em] shadow-lg shadow-rose-100 transition-all hover:bg-rose-700 hover:scale-[1.02] active:scale-[0.98]">HAPUS DATA</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(event, message = '') {
            event.preventDefault();
            const target = event.target.closest('form, a');
            if(target && message) target.setAttribute('data-confirm-message', message);
            window.dispatchEvent(new CustomEvent('open-delete-modal', { detail: event }));
        }
    </script>

    <!-- Page Transition Style -->
    <style>
        .animate-in {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
