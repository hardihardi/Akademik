<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-2 sm:p-3 lg:p-4 space-y-6 sm:space-y-8">
    
    <?php if(session()->get('role') == 'admin'): ?>
    <!-- ADMIN DASHBOARD REDESIGN -->
    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-6 duration-700">
        
        <!-- Header & Breadcrumbs -->
        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-slate-50 rounded-full"></div>
            <div class="relative">
                <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4 ">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <span>Dashboard</span>
                </div>
                <h1 class="text-3xl font-black text-slate-700 tracking-tight leading-none uppercase">Dashboard Admin</h1>
                <p class="text-slate-500 font-bold mt-2">Selamat datang, <span class="font-black text-slate-700"><?= session()->get('username') ?></span>!</p>
                <?php if(isset($stats['activeYear'])): ?>
                <p class="text-slate-500 font-bold mt-1">Tahun Akademik Aktif: <span class="text-indigo-600"><?= $stats['activeYear']['year'] ?> (<?= $stats['activeYear']['semester'] == 1 ? 'Ganjil' : 'Genap' ?>)</span></p>
                <?php endif; ?>
            </div>
            
            <!-- Dashboard Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                <!-- Total Students Card -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-100 flex items-center gap-4 sm:gap-6 group hover:shadow-xl transition-all duration-500">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 shadow-inner">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest leading-none mb-2">Total Siswa</span>
                        <span class="block font-black text-4xl text-slate-700 tracking-tighter"><?= $stats['students'] ?></span>
                    </div>
                </div>

                <!-- Total Teachers Card -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-100 flex items-center gap-4 sm:gap-6 group hover:shadow-xl transition-all duration-500">
                    <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500 shadow-inner">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest leading-none mb-2">Total Guru</span>
                        <span class="block font-black text-4xl text-slate-700 tracking-tighter"><?= $stats['teachers'] ?></span>
                    </div>
                </div>

                <!-- Total Users Card -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-100 flex items-center gap-4 sm:gap-6 group hover:shadow-xl transition-all duration-500">
                    <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all duration-500 shadow-inner">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest leading-none mb-2">Akun Pengguna</span>
                        <span class="block font-black text-4xl text-slate-700 tracking-tighter"><?= $stats['users'] ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHARTS SECTION -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Class Distribution Chart -->
            <div class="bg-white p-6 sm:p-8 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-indigo-50/30 rounded-full"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-black text-slate-700 uppercase tracking-tight">Sebaran Siswa Per Kelas</h3>
                            <p class="text-[10px] text-slate-400 mt-1 font-black uppercase tracking-widest">Kapasitas Rombel Aktif</p>
                        </div>
                    </div>
                    <div class="h-[300px]">
                        <canvas id="classDistChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gender Stats Chart -->
            <div class="bg-white p-6 sm:p-8 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-rose-50/30 rounded-full"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-black text-slate-700 uppercase tracking-tight">Statistik Gender</h3>
                            <p class="text-[10px] text-slate-400 mt-1 font-black uppercase tracking-widest">Rasio Laki-laki & Perempuan</p>
                        </div>
                    </div>
                    <div class="h-[300px] flex items-center justify-center">
                        <canvas id="genderStatsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Quick Actions Section -->
            <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-100 flex flex-col">
                <h3 class="text-lg font-black text-slate-700 uppercase tracking-tight mb-8">Kelola Data Akademik</h3>
                <div class="grid grid-cols-2 lg:grid-cols-2 gap-4 sm:gap-6 flex-1">
                    <a href="<?= base_url('students') ?>" class="group p-6 rounded-2xl bg-blue-50 border border-blue-100 flex flex-col items-center justify-center text-center hover:bg-white hover:shadow-xl hover:shadow-blue-100 transition-all duration-500">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" /></svg>
                        </div>
                        <span class="text-xs font-black text-slate-600 uppercase tracking-widest group-hover:text-blue-600">Data Siswa</span>
                    </a>
                    <a href="<?= base_url('teachers') ?>" class="group p-6 rounded-2xl bg-emerald-50 border border-emerald-100 flex flex-col items-center justify-center text-center hover:bg-white hover:shadow-xl hover:shadow-emerald-100 transition-all duration-500">
                        <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                        </div>
                        <span class="text-xs font-black text-slate-600 uppercase tracking-widest group-hover:text-emerald-600">Data Guru</span>
                    </a>
                    <a href="<?= base_url('classes') ?>" class="group p-6 rounded-2xl bg-amber-50 border border-amber-100 flex flex-col items-center justify-center text-center hover:bg-white hover:shadow-xl hover:shadow-amber-100 transition-all duration-500">
                        <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-all">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                        <span class="text-xs font-black text-slate-600 uppercase tracking-widest group-hover:text-amber-600">Data Kelas</span>
                    </a>
                    <a href="<?= base_url('subjects') ?>" class="group p-6 rounded-2xl bg-teal-50 border border-teal-100 flex flex-col items-center justify-center text-center hover:bg-white hover:shadow-xl hover:shadow-teal-100 transition-all duration-500">
                        <div class="w-12 h-12 bg-teal-600 rounded-xl flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-all">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <span class="text-xs font-black text-slate-600 uppercase tracking-widest group-hover:text-teal-600">Mata Pelajaran</span>
                    </a>
                </div>
            </div>

            <!-- Users Table Section -->
            <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-black text-slate-700 uppercase tracking-tight">Akun Pengguna</h3>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                    <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        Show 
                        <select class="bg-slate-50 border-none rounded-lg text-[10px] py-1 pl-2 pr-6 outline-none focus:ring-2 focus:ring-indigo-100">
                            <option>5</option>
                            <option>10</option>
                        </select>
                        entries
                    </div>
                    <div class="relative w-full sm:w-64">
                        <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 h-10 bg-slate-50 border-none rounded-xl text-xs font-bold outline-none focus:ring-2 focus:ring-indigo-100 placeholder:text-slate-300">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-indigo-50/50 rounded-xl overflow-hidden">
                                <th class="px-4 py-3 text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-100 w-12 text-center">No.</th>
                                <th class="px-4 py-3 text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-100">Nama Pengguna</th>
                                <th class="px-4 py-3 text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-100">Peran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php if(!empty($recentUsers)): ?>
                                <?php $no = 1; foreach(array_slice($recentUsers, 0, 5) as $ru): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-4 text-xs font-black text-slate-400 text-center"><?= $no++ ?></td>
                                    <td class="px-4 py-4">
                                        <p class="text-xs font-extrabold text-slate-700 tracking-tight leading-none mb-1 capitalize"><?= $ru['username'] ?></p>
                                        <p class="text-[9px] font-bold text-slate-300 uppercase leading-none"><?= $ru['email'] ?></p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex px-3 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest">
                                            <?= $ru['role_name'] ?: 'Admin' ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="px-4 py-10 text-center text-xs text-slate-400 font-bold">No data found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6 flex justify-between items-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <span>Showing 1 to <?= min(5, count($recentUsers)) ?> of <?= count($recentUsers) ?> entries</span>
                    <div class="flex items-center gap-1">
                        <button class="px-2 py-1 hover:text-indigo-600 transition-colors opacity-50">Previous</button>
                        <button class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center">1</button>
                        <button class="px-2 py-1 hover:text-indigo-600 transition-colors opacity-50">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php elseif(session()->get('role') == 'guru' || session()->get('role') == 'wali_kelas'): ?>
    <!-- GURU DASHBOARD REDESIGN -->
    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-6 duration-700">
        
        <!-- Welcome Header -->
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-8 shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-48 h-48 sm:w-64 sm:h-64 bg-slate-50 rounded-full"></div>
            <div class="relative">
                <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 sm:mb-4 ">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <span>Dashboard Guru</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-700 tracking-tight leading-none uppercase">Dashboard Guru</h1>
                <p class="text-xs sm:text-sm text-slate-500 font-bold mt-2">Selamat datang, <span class="font-black text-slate-700"><?= $teacherData['info']['full_name'] ?? session()->get('username') ?></span>!</p>
                <?php if(isset($stats['activeYear'])): ?>
                <p class="text-[10px] sm:text-xs text-slate-500 font-bold mt-1">Tahun Akademik Aktif: <span class="text-indigo-600"><?= $stats['activeYear']['year'] ?> (<?= $stats['activeYear']['semester'] == 1 ? 'Ganjil' : 'Genap' ?>)</span></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Action Cards (Previous lines...) -->
        <!-- ... existing Quick Action Cards code ... -->
        
        <!-- NEW: Responsive Grading Reminders Notification -->
        <?php if(!empty($teacherData['gradingReminders'])): ?>
        <div class="animate-in fade-in slide-in-from-top-4 duration-700">
            <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 shadow-sm border border-rose-100 overflow-hidden relative">
                <div class="absolute -right-12 -top-12 w-32 h-32 bg-rose-50 rounded-full opacity-50"></div>
                <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-4 sm:gap-6">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-12 h-12 bg-rose-500 text-white rounded-xl shadow-lg shadow-rose-200 flex items-center justify-center flex-shrink-0 animate-bounce">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-slate-700 tracking-tight uppercase">Pengingat Penilaian</h3>
                            <p class="text-xs sm:text-sm text-slate-500 font-bold mt-0.5">Ada <span class="text-rose-600 font-black"><?= count($teacherData['gradingReminders']) ?></span> item yang memerlukan penilaian segera.</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 sm:gap-3">
                        <?php foreach(array_slice($teacherData['gradingReminders'], 0, 3) as $rem): ?>
                        <a href="<?= base_url('assignments/submissions/' . $rem['id']) ?>" class="group flex items-center gap-3 px-4 py-2.5 bg-slate-50 border border-slate-100 rounded-xl hover:bg-rose-500 hover:border-rose-500 transition-all duration-300">
                            <span class="w-6 h-6 bg-white text-rose-500 rounded-lg flex items-center justify-center text-[10px] font-black group-hover:bg-rose-600 group-hover:text-white"><?= $rem['pending_count'] ?></span>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-slate-700 uppercase tracking-tight group-hover:text-white"><?= $rem['type'] ?></span>
                                <span class="text-[8px] font-bold text-slate-400 group-hover:text-rose-100 truncate w-24 sm:w-32 uppercase"><?= $rem['subject_name'] ?> - <?= $rem['class_name'] ?></span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                        
                        <?php if(count($teacherData['gradingReminders']) > 3): ?>
                        <a href="<?= base_url('assignments') ?>" class="flex items-center justify-center px-4 py-2.5 bg-slate-100 text-[10px] font-black text-slate-500 rounded-xl hover:bg-slate-200 uppercase tracking-widest transition-all">
                            +<?= count($teacherData['gradingReminders']) - 3 ?> Lainnya
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-8">
            <!-- Student Table (Redesigned with Tabs) -->
            <div class="xl:col-span-2 bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-8 shadow-sm border border-slate-100 overflow-hidden" 
                 x-data="{ 
                    activeTab: '<?= !empty($teacherData['homeroom_class']) ? 'homeroom' : 'subjects' ?>',
                    activeSubClass: '<?= !empty($teacherData['subject_students']) ? $teacherData['subject_students'][0]['class_name'] : '' ?>'
                 }">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-700 uppercase tracking-tight">Siswa Saya</h3>
                        <p class="text-[10px] text-slate-400 mt-1 font-black uppercase tracking-widest leading-none">Manajemen Siswa Berdasarkan Peran</p>
                    </div>
                    
                    <div class="flex bg-slate-50 p-1.5 rounded-2xl border border-slate-100 items-center">
                        <?php if($teacherData['homeroom_class']): ?>
                        <button @click="activeTab = 'homeroom'" 
                                :class="activeTab === 'homeroom' ? 'bg-white text-indigo-600 shadow-md shadow-indigo-100/50' : 'text-slate-400 hover:text-slate-600'"
                                class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">
                            Wali Kelas (<?= $teacherData['homeroom_class']['class_name'] ?>)
                        </button>
                        <?php endif; ?>
                        <button @click="activeTab = 'subjects'" 
                                :class="activeTab === 'subjects' ? 'bg-white text-indigo-600 shadow-md shadow-indigo-100/50' : 'text-slate-400 hover:text-slate-600'"
                                class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">
                            Mata Pelajaran
                        </button>
                    </div>
                </div>

                <!-- SELECT CLASS SUB-TAB (Only for subjects) -->
                <div x-show="activeTab === 'subjects' && <?= count($teacherData['subject_students']) ?> > 0" 
                     class="flex flex-wrap gap-2 mb-6 animate-in slide-in-from-left-4 duration-500">
                    <?php foreach($teacherData['subject_students'] as $idx => $sc): ?>
                    <button @click="activeSubClass = '<?= $sc['class_name'] ?>'"
                            :class="activeSubClass === '<?= $sc['class_name'] ?>' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-slate-50 text-slate-400 border border-slate-100 hover:bg-white hover:text-indigo-600'"
                            class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">
                        <?= $sc['class_name'] ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                
                <!-- CONTENT: Homeroom Students -->
                <div x-show="activeTab === 'homeroom'" class="animate-in fade-in duration-500">
                    <div class="overflow-x-auto -mx-5 sm:mx-0">
                        <div class="min-w-[600px] sm:min-w-0 px-5 sm:px-0">
                            <table class="w-full text-left border-separate border-spacing-0">
                                <thead>
                                    <tr class="bg-indigo-50/30">
                                        <th class="px-4 sm:px-6 py-4 text-[10px] font-black text-indigo-400 uppercase tracking-widest border-b border-indigo-50 w-12 sm:w-16 text-center rounded-l-2xl">No.</th>
                                        <th class="px-4 sm:px-6 py-4 text-[10px] font-black text-indigo-400 uppercase tracking-widest border-b border-indigo-50">Nama Siswa</th>
                                        <th class="px-4 sm:px-6 py-4 text-[10px] font-black text-indigo-400 uppercase tracking-widest border-b border-indigo-50 whitespace-nowrap">NIS/NISN</th>
                                        <th class="px-4 sm:px-6 py-4 text-[10px] font-black text-indigo-400 uppercase tracking-widest border-b border-indigo-50 text-center rounded-r-2xl">JK</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    <?php if(!empty($teacherData['homeroom_students'])): ?>
                                        <?php $no = 1; foreach($teacherData['homeroom_students'] as $s): ?>
                                        <tr class="group hover:bg-slate-50/30 transition-colors">
                                            <td class="px-4 sm:px-6 py-4 text-xs font-black text-slate-400 text-center"><?= $no++ ?></td>
                                            <td class="px-4 sm:px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center text-[10px] font-black group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                                        <?= strtoupper(substr($s['full_name'], 0, 1)) ?>
                                                    </div>
                                                    <span class="text-xs font-black text-slate-700 group-hover:text-indigo-600 transition-colors"><?= $s['full_name'] ?></span>
                                                </div>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 text-xs font-bold text-slate-500"><?= $s['nis'] ?: ($s['nisn'] ?: '-') ?></td>
                                            <td class="px-4 sm:px-6 py-4 text-center">
                                                <span class="inline-flex px-2 py-0.5 rounded-md text-[9px] font-black <?= $s['gender'] == 'L' ? 'bg-blue-50 text-blue-600' : 'bg-rose-50 text-rose-600' ?>">
                                                    <?= $s['gender'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" class="py-12 text-center text-slate-300 text-[10px] font-black uppercase">Belum ada data</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- CONTENT: Subject Students -->
                <div x-show="activeTab === 'subjects'" class="animate-in fade-in duration-500">
                    <?php if(!empty($teacherData['subject_students'])): ?>
                        <?php foreach($teacherData['subject_students'] as $sc): ?>
                            <div x-show="activeSubClass === '<?= $sc['class_name'] ?>'">
                                <div class="overflow-x-auto -mx-5 sm:mx-0">
                                    <div class="min-w-[600px] sm:min-w-0 px-5 sm:px-0">
                                        <table class="w-full text-left border-separate border-spacing-0">
                                            <thead>
                                                <tr class="bg-slate-50/50">
                                                    <th class="px-4 sm:px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-12 sm:w-16 text-center rounded-l-2xl">No.</th>
                                                    <th class="px-4 sm:px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Nama Siswa</th>
                                                    <th class="px-4 sm:px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 whitespace-nowrap">NIS/NISN</th>
                                                    <th class="px-4 sm:px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center rounded-r-2xl">JK</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-50">
                                                <?php $no = 1; foreach($sc['students'] as $s): ?>
                                                <tr class="group hover:bg-slate-50/30 transition-colors">
                                                    <td class="px-4 sm:px-6 py-4 text-xs font-black text-slate-400 text-center"><?= $no++ ?></td>
                                                    <td class="px-4 sm:px-6 py-4">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center text-[10px] font-black group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                                                <?= strtoupper(substr($s['full_name'], 0, 1)) ?>
                                                            </div>
                                                            <span class="text-xs font-black text-slate-700 group-hover:text-indigo-600 transition-colors"><?= $s['full_name'] ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 sm:px-6 py-4 text-xs font-bold text-slate-500"><?= $s['nis'] ?: ($s['nisn'] ?: '-') ?></td>
                                                    <td class="px-4 sm:px-6 py-4 text-center">
                                                        <span class="inline-flex px-2 py-0.5 rounded-md text-[9px] font-black <?= $s['gender'] == 'L' ? 'bg-blue-50 text-blue-600' : 'bg-rose-50 text-rose-600' ?>">
                                                            <?= $s['gender'] ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="py-12 text-center text-slate-300 text-[10px] font-black uppercase">Belum ada data mata pelajaran</div>
                    <?php endif; ?>
                </div>

                <!-- Footer Summary (Responsive) -->
                <div class="mt-8 pt-6 border-t border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <span x-show="activeTab === 'homeroom'">Total: <?= count($teacherData['homeroom_students']) ?> Siswa Kali Kelas</span>
                    <span x-show="activeTab === 'subjects'">Total Siswa per Kelas Mata Pelajaran</span>
                    <div class="flex items-center gap-1">
                        <button class="px-2 py-1 hover:text-indigo-600 transition-colors opacity-50">Prev</button>
                        <button class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center">1</button>
                        <button class="px-2 py-1 hover:text-indigo-600 transition-colors opacity-50">Next</button>
                    </div>
                </div>
            </div>

            <!-- Teaching Schedule (Accordion by Day) -->
            <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-8 shadow-sm border border-slate-100 flex flex-col relative overflow-hidden">
                <div class="absolute -right-12 -bottom-12 w-32 h-32 bg-indigo-50/20 rounded-full group-hover:scale-110 transition-transform duration-700"></div>
                
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-700 uppercase tracking-tight">Jadwal Mengajar</h3>
                        <p class="text-[10px] text-slate-400 mt-1 font-black uppercase tracking-widest">Minggu Ini</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-indigo-50 text-indigo-600 rounded-xl border border-indigo-100 shadow-sm shadow-indigo-50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                </div>
                
                <?php if(!empty($teacherData['schedules'])): ?>
                <?php
                    // Group schedules by day
                    $groupedSchedules = [];
                    foreach ($teacherData['schedules'] as $sch) {
                        $groupedSchedules[$sch['day']][] = $sch;
                    }
                    $daysIndo = [0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'];
                    $today = $daysIndo[date('w')];
                    $initialDay = isset($groupedSchedules[$today]) ? $today : (array_key_first($groupedSchedules) ?? '');
                ?>
                <div class="flex-1 space-y-3 relative z-10" x-data="{ openDay: '<?= $initialDay ?>' }">
                    <?php foreach ($groupedSchedules as $day => $lessons): ?>
                    <div class="rounded-[1.5rem] border transition-all duration-500 overflow-hidden"
                         :class="openDay === '<?= $day ?>' ? 'bg-white shadow-xl shadow-indigo-100/50 border-indigo-200' : 'bg-slate-50/50 border-slate-100 hover:border-slate-200 hover:bg-slate-50'">
                        <!-- Day Header (clickable) -->
                        <button @click="openDay = openDay === '<?= $day ?>' ? null : '<?= $day ?>'"
                                class="w-full flex items-center justify-between p-4 sm:p-5 text-left transition-all group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all shadow-sm"
                                     :class="openDay === '<?= $day ?>' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-400 group-hover:text-indigo-600 border border-slate-100'">
                                    <span class="text-[10px] font-black uppercase tracking-widest leading-none"><?= substr($day, 0, 3) ?></span>
                                </div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-black text-slate-700 transition-colors uppercase tracking-tight" :class="openDay === '<?= $day ?>' ? 'text-indigo-700' : ''"><?= $day ?></h4>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"><?= count($lessons) ?> Mata Pelajaran</span>
                                </div>
                            </div>
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-slate-300 transition-all duration-500"
                                 :class="openDay === '<?= $day ?>' ? 'rotate-180 bg-indigo-50 text-indigo-500' : 'bg-white border border-slate-100'">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </button>
                        
                        <!-- Day Content (expandable) -->
                        <div x-show="openDay === '<?= $day ?>'"
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 -translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200 transform"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-4"
                             class="px-4 sm:px-5 pb-5 space-y-3">
                            <?php foreach ($lessons as $sch): ?>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100/30 group/item hover:bg-white hover:shadow-lg hover:shadow-indigo-50 hover:border-indigo-100 transition-all duration-300">
                                <div class="w-10 h-10 rounded-xl bg-white text-indigo-600 flex items-center justify-center shadow-sm border border-indigo-50 group-hover/item:bg-indigo-600 group-hover/item:text-white transition-all duration-300 shrink-0">
                                    <svg class="w-5 h-5 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-xs font-black text-slate-700 uppercase tracking-tight truncate group-hover/item:text-indigo-600 transition-all"><?= $sch['subject_name'] ?></h5>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-2 py-0.5 bg-white text-indigo-400 text-[8px] font-black rounded-md uppercase tracking-widest border border-indigo-100/50 shadow-sm"><?= $sch['class_name'] ?></span>
                                        <span class="text-[10px] font-bold text-slate-400"><?= date('H:i', strtotime($sch['start_time'])) ?> - <?= date('H:i', strtotime($sch['end_time'])) ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="flex-1 flex flex-col items-center justify-center text-center p-12 relative z-10">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mb-4 border border-slate-100 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Jadwal Belum Diatur</p>
                    <p class="text-[10px] text-slate-300 font-bold mt-1">Silakan hubungi admin akademik.</p>
                </div>
                <?php endif; ?>

                <div class="mt-8 flex justify-center no-print">
                    <button class="px-8 py-3 bg-white text-slate-400 border border-slate-200 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:text-indigo-600 hover:border-indigo-100 hover:bg-slate-50 transition-all duration-300 shadow-sm">Cetak Jadwal Saya</button>
                </div>
            </div>
        </div>

        <!-- NEW: Assignments & Announcements Row -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 sm:gap-8">
            <!-- Recent Assignments -->
            <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-base sm:text-lg font-black text-slate-700 uppercase tracking-tight">Tugas & Materi</h3>
                    <a href="<?= base_url('assignments') ?>" class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] hover:text-indigo-700">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    <?php if(!empty($teacherData['recentAssignments'])): ?>
                        <?php foreach($teacherData['recentAssignments'] as $asgn): ?>
                        <a href="<?= base_url('assignments/submissions/' . $asgn['id']) ?>" class="group flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-xl hover:border-indigo-100 transition-all duration-300 relative overflow-hidden">
                            <div class="absolute right-0 top-0 w-12 h-12 bg-indigo-50/50 rounded-bl-3xl translate-x-12 -translate-y-12 group-hover:translate-x-0 group-hover:-translate-y-0 transition-all duration-500"></div>
                            
                            <div class="w-12 h-12 bg-white text-indigo-600 rounded-xl flex items-center justify-center shadow-sm border border-indigo-50 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <h4 class="text-sm font-black text-slate-700 truncate tracking-tight group-hover:text-indigo-600 transition-colors uppercase"><?= $asgn['title'] ?></h4>
                                    <?php if(($asgn['pending_count'] ?? 0) > 0): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[8px] font-black bg-rose-500 text-white uppercase tracking-tighter animate-pulse flex-shrink-0 shadow-lg shadow-rose-200">
                                            <?= $asgn['pending_count'] ?> PERLU DINILAI
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                        <?= $asgn['subject_name'] ?> • <?= $asgn['class_name'] ?>
                                    </span>
                                    <span class="text-[9px] font-black text-rose-500 uppercase tracking-widest flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                        Deadline: <?= $asgn['deadline'] ? date('d M, H:i', strtotime($asgn['deadline'])) : '-' ?>
                                    </span>
                                </div>
                            </div>

                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-slate-300 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-all shadow-sm border border-slate-50 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 hidden sm:flex">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="py-12 text-center">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-xs font-black text-slate-300 uppercase tracking-widest">Belum ada tugas dibuat</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Class Announcements -->
            <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-base sm:text-lg font-black text-slate-700 uppercase tracking-tight">Pengumuman</h3>
                    <a href="<?= base_url('announcements') ?>" class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] hover:text-indigo-700">Lainnya</a>
                </div>

                <div class="space-y-4">
                    <?php if(!empty($teacherData['announcements'])): ?>
                        <?php foreach($teacherData['announcements'] as $ann): ?>
                        <div class="p-5 rounded-2xl bg-indigo-50/50 border border-indigo-100 relative overflow-hidden group hover:shadow-md transition-all">
                            <div class="absolute right-0 top-0 w-12 h-12 bg-indigo-100 -mr-6 -mt-6 rounded-full opacity-20 group-hover:scale-150 transition-all duration-700"></div>
                            <h4 class="text-sm font-black text-slate-700 mb-2"><?= $ann['title'] ?></h4>
                            <p class="text-xs text-slate-500 line-clamp-2 mb-3 leading-relaxed"><?= strip_tags($ann['content']) ?></p>
                            <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest"><?= date('d F Y', strtotime($ann['created_at'])) ?></span>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="py-12 text-center">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            </div>
                            <p class="text-xs font-black text-slate-300 uppercase tracking-widest">Tidak ada pengumuman</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php elseif(session()->get('role') == 'ortu'): ?>
    <!-- PARENT DASHBOARD (Premium Mockup Style) -->
    <?php if (!empty($parentData['student'])): ?>
    <div class="space-y-6 sm:space-y-8 animate-in slide-in-from-bottom-6 duration-700">
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Student Profile Summary -->
            <div class="md:col-span-3 bg-white rounded-[2rem] p-6 lg:p-8 shadow-sm border border-slate-100 flex flex-col md:flex-row items-center gap-6 relative overflow-hidden group hover:shadow-lg transition-all duration-500">
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-50/50 rounded-full group-hover:scale-110 transition-transform duration-700"></div>
                
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-indigo-100 border border-indigo-200 flex items-center justify-center text-3xl font-black text-indigo-400 flex-shrink-0 overflow-hidden relative">
                    <?php if ($parentData['student']['photo']): ?>
                        <img src="<?= get_photo_url($parentData['student']['photo']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?= strtoupper(substr($parentData['student']['full_name'], 0, 1)) ?>
                    <?php endif; ?>
                </div>

                <div class="text-center md:text-left z-10 flex-1">
                    <h2 class="text-xl font-black text-slate-800 tracking-tight leading-none mb-1"><?= $parentData['student']['full_name'] ?></h2>
                    <?php if(isset($stats['activeYear'])): ?>
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-600 mb-2">T.A <?= $stats['activeYear']['year'] ?> (<?= $stats['activeYear']['semester'] == 1 ? 'Ganjil' : 'Genap' ?>)</p>
                    <?php endif; ?>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg> <?= $parentData['student']['class_name'] ?></span>
                        <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm5 3a2 2 0 100-4 2 2 0 000 4z" /></svg> NIS: <?= $parentData['student']['nis'] ?></span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="<?= base_url('parent/profile') ?>" class="p-3 bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white rounded-2xl transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></a>
                </div>
            </div>

            <!-- Average Grade Card -->
            <div class="bg-indigo-600 rounded-[2rem] p-6 lg:p-8 text-white shadow-xl shadow-indigo-100 flex flex-col justify-center relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full group-hover:scale-125 transition-transform duration-700"></div>
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-200 mb-1">Rata-rata Nilai</h3>
                <div class="flex items-baseline gap-1">
                    <span class="text-4xl font-black tracking-tighter"><?= $parentData['overall_avg'] ?></span>
                    <span class="text-xs font-bold text-indigo-200">/ 100</span>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <div class="flex-1 h-1.5 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-white rounded-full" style="width: <?= $parentData['overall_avg'] ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
            <!-- Left Column: Grades & Attendance -->
            <div class="lg:col-span-8 space-y-6 sm:space-y-8">
                <!-- Academic Grades Table -->
                <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-black text-slate-700 uppercase tracking-tight">Nilai Akademik Terbaru</h3>
                            <p class="text-[10px] text-slate-400 mt-1 font-black uppercase tracking-widest leading-none">5 Penilaian Terakhir</p>
                        </div>
                        <a href="<?= base_url('parent/grades') ?>" class="px-5 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-sm">Lihat Nilai</a>
                    </div>
                    
                    <div class="overflow-x-auto rounded-2xl border border-slate-50">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-indigo-50/50">
                                    <th class="p-4 text-[10px] font-black text-indigo-600 uppercase tracking-widest w-12 text-center">No.</th>
                                    <th class="p-4 text-[10px] font-black text-indigo-600 uppercase tracking-widest">Mata Pelajaran</th>
                                    <th class="p-4 text-[10px] font-black text-indigo-600 uppercase tracking-widest text-center whitespace-nowrap">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php if(!empty($parentData['grades'])): ?>
                                    <?php $no = 1; foreach($parentData['grades'] as $grade): ?>
                                    <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                                        <td class="p-4 text-xs font-black text-slate-400 text-center"><?= $no++ ?></td>
                                        <td class="p-4">
                                            <span class="text-xs font-black text-slate-700 tracking-tight leading-none group-hover:text-indigo-600 transition-colors"><?= $grade['subject_name'] ?></span>
                                        </td>
                                        <td class="p-4 text-center">
                                            <span class="inline-flex px-3 py-1 rounded-lg <?= $grade['score'] >= 75 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' ?> text-xs font-black tracking-tighter shadow-sm border border-white">
                                                <?= $grade['score'] ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="p-10 text-center">
                                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Belum ada data nilai terbaru</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Active Assignments Section -->
                <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-black text-slate-700 uppercase tracking-tight">Tugas & Materi Aktif</h3>
                            <p class="text-[10px] text-slate-400 mt-1 font-black uppercase tracking-widest">Mendekati Batas Waktu</p>
                        </div>
                        <a href="<?= base_url('parent/assignments') ?>" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-800 transition-colors">Lihat Semua</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php if(!empty($parentData['assignments'])): ?>
                            <?php foreach($parentData['assignments'] as $asgn): ?>
                            <?php 
                                $deadline = strtotime($asgn['deadline']);
                                $isUrgent = ($deadline - time()) < (48 * 3600); // Less than 48 hours
                            ?>
                            <div class="p-6 rounded-3xl border border-slate-50 <?= $isUrgent ? 'bg-rose-50/30 border-rose-100 shadow-sm shadow-rose-50' : 'bg-slate-50/30' ?> group hover:shadow-md transition-all">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center <?= $isUrgent ? 'bg-rose-500 text-white shadow-lg shadow-rose-200' : 'bg-white text-slate-400 shadow-sm' ?>">
                                        <svg class="w-5 h-5 font-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <?php if($asgn['sub_status'] == 'submitted' || $asgn['sub_status'] == 'reviewed'): ?>
                                        <span class="px-2 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[8px] font-black uppercase tracking-widest border border-emerald-100">✓ Selesai</span>
                                    <?php elseif($isUrgent): ?>
                                        <span class="px-2 py-1 rounded-lg bg-rose-500 text-white text-[8px] font-black uppercase tracking-widest animate-pulse shadow-md shadow-rose-200">! Deadline</span>
                                    <?php endif; ?>
                                </div>
                                <h4 class="text-sm font-black text-slate-800 tracking-tight leading-none mb-1 group-hover:text-indigo-600 transition-colors"><?= $asgn['title'] ?></h4>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4"><?= $asgn['subject_name'] ?></p>
                                
                                <div class="flex items-center gap-2 mb-6 text-[10px] font-black text-slate-500">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    <span>Deadline: <?= date('d M, H:i', $deadline) ?></span>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-2 mt-auto">
                                    <?php if($asgn['file_path']): ?>
                                        <a href="<?= base_url('uploads/assignments/' . $asgn['file_path']) ?>" class="flex-1 py-3 bg-white text-slate-600 border border-slate-100 rounded-xl text-[9px] font-black uppercase tracking-widest text-center hover:bg-slate-50 transition-all shadow-sm">Materi</a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('parent/assignments/view/' . $asgn['id']) ?>" class="flex-1 py-3 bg-indigo-600 text-white rounded-xl text-[9px] font-black uppercase tracking-widest text-center hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">Upload Tugas</a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-span-2 p-12 text-center bg-slate-50 rounded-3xl border border-slate-100">
                                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-sm"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg></div>
                                <h4 class="text-sm font-black text-slate-700 uppercase tracking-tight">Tidak Ada Tugas Aktif</h4>
                                <p class="text-xs text-slate-400 mt-1">Anak Anda telah menyelesaikan semua tugas atau materi belum tersedia.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Attendance & Announcements -->
            <div class="lg:col-span-4 space-y-6 sm:space-y-8">
                <!-- Attendance Donut Chart -->
                <div class="bg-white rounded-[2rem] p-6 lg:p-8 shadow-sm border border-slate-100 relative overflow-hidden h-fit">
                    <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-slate-50 rounded-full"></div>
                    <div class="relative">
                        <div class="mb-8">
                            <h3 class="text-lg font-black text-slate-700 uppercase tracking-tight leading-none">Kehadiran</h3>
                            <p class="text-[10px] text-slate-400 mt-2 font-black uppercase tracking-widest">Statistik Kehadiran Anak</p>
                        </div>
                        
                        <div class="flex flex-col items-center gap-8">
                            <div class="w-48 h-48 relative flex-shrink-0">
                                <canvas id="parentAttendanceChart"></canvas>
                                <div class="absolute inset-0 flex flex-col items-center justify-center leading-none pointer-events-none">
                                    <span class="text-4xl font-black text-slate-800 tracking-tighter"><?= $parentData['attendance_stats']['present'] ?><span class="text-base text-indigo-400 font-bold ml-0.5">%</span></span>
                                </div>
                            </div>

                            <div class="w-full space-y-4">
                                <div class="p-4 rounded-2xl bg-slate-50/50 border border-slate-100 flex items-center justify-between group hover:bg-white hover:shadow-md transition-all">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" /></svg></div>
                                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Hadir</p><p class="text-xs font-black text-slate-700">Pelajaran Tetap</p></div>
                                    </div>
                                    <span class="text-xs font-black text-slate-700 tracking-tighter"><?= $parentData['attendance_stats']['present'] ?>%</span>
                                </div>
                                <div class="p-4 rounded-2xl bg-slate-50/50 border border-slate-100 flex items-center justify-between group hover:bg-white hover:shadow-md transition-all">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-500"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" /></svg></div>
                                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Izin/Sakit</p><p class="text-xs font-black text-slate-700">Ket. Terverifikasi</p></div>
                                    </div>
                                    <span class="text-xs font-black text-slate-700 tracking-tighter"><?= $parentData['attendance_stats']['permission'] ?>%</span>
                                </div>
                                <a href="<?= base_url('parent/attendance') ?>" class="block w-full py-4 bg-slate-900 border border-slate-800 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-indigo-600 transition-all shadow-lg shadow-slate-100">Riwayat Kehadiran</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pusat Informasi (Announcements) -->
                <div class="bg-white rounded-[2rem] p-6 lg:p-8 shadow-sm border border-slate-100 h-fit">
                    <div class="mb-8">
                        <h3 class="text-lg font-black text-slate-700 uppercase tracking-tight leading-none">Pusat Informasi</h3>
                        <p class="text-[10px] text-slate-400 mt-2 font-black uppercase tracking-widest">Pengumuman Terbaru Sekolah</p>
                    </div>

                    <div class="space-y-4">
                        <?php if(!empty($parentData['announcements'])): ?>
                            <?php foreach($parentData['announcements'] as $ann): ?>
                            <div class="p-5 rounded-3xl bg-slate-50/50 border border-slate-100 group hover:bg-white hover:shadow-lg transition-all relative overflow-hidden">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg></div>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest"><?= date('d M Y', strtotime($ann['created_at'])) ?></span>
                                </div>
                                <h4 class="text-sm font-black text-slate-800 tracking-tight leading-snug"><?= $ann['title'] ?></h4>
                                <p class="text-[11px] text-slate-500 mt-2 line-clamp-2 leading-relaxed"><?= strip_tags($ann['content']) ?></p>
                                <a href="<?= base_url('parent/announcements/view/' . $ann['id']) ?>" class="absolute inset-0 z-10 opacity-0"></a>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-xs text-slate-400 text-center py-6 font-bold uppercase tracking-widest">Belum ada pengumuman</p>
                        <?php endif; ?>
                        
                        <a href="<?= base_url('parent/announcements') ?>" class="block w-full py-4 border border-slate-100 text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-slate-50 transition-all">Semua Informasi</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Growth Summary Card (Medium Width) -->
        <div class="mx-auto max-w-5xl bg-indigo-50/50 border border-indigo-100 p-6 sm:p-8 sm:px-10 rounded-[2.5rem] flex flex-col sm:flex-row items-center gap-6 sm:gap-8 hover:bg-white hover:shadow-2xl hover:shadow-indigo-100 transition-all duration-500 group">
            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-white rounded-3xl shadow-xl shadow-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0 border border-indigo-100 relative overflow-hidden">
                <div class="absolute inset-0 bg-indigo-600/5 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                <!-- Mockup Icon: Growth Chart -->
                <svg class="w-10 h-10 sm:w-12 sm:h-12 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                </svg>
            </div>
            <div class="text-center sm:text-left flex-1">
                <h4 class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-2 leading-none">Ringkasan Perkembangan Akademik</h4>
                <p class="text-lg sm:text-2xl font-black text-indigo-900 leading-tight tracking-tight"><?= $parentData['summary'] ?></p>
            </div>
            <div class="flex-shrink-0 w-full sm:w-auto">
                <a href="<?= base_url('parent/reports') ?>" class="block w-full sm:inline-block px-8 py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-200 text-center">Unduh Rapor Lengkap</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>

</div>

<!-- Scripts for Charts -->
<?php if(session()->get('role') == 'admin'): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ... (Admin Bar Chart)
        const barCtx = document.getElementById('classDistChart');
        if (barCtx) {
            new Chart(barCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_column($adminChartData['classStudents'] ?? [], 'name')) ?>,
                    datasets: [{
                        label: 'Siswa',
                        data: <?= json_encode(array_column($adminChartData['classStudents'] ?? [], 'count')) ?>,
                        backgroundColor: 'rgba(99, 102, 241, 0.9)',
                        borderRadius: 12,
                        barThickness: 32,
                        hoverBackgroundColor: '#4f46e5'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { strokeDashArray: [5, 5], color: '#f1f5f9', border: { display: false } },
                            ticks: { 
                                stepSize: 10,
                                font: { weight: 'bold', size: 10 },
                                color: '#94a3b8'
                            }
                        },
                        x: { 
                            grid: { display: false },
                            border: { display: false },
                            ticks: { 
                                font: { weight: 'bold', size: 10 },
                                color: '#64748b'
                            }
                        }
                    }
                }
            });
        }

        // ... (Admin Donut Chart)
        const donutCtx = document.getElementById('genderStatsChart');
        if (donutCtx) {
            const genderData = <?= json_encode($adminChartData['genderStats'] ?? []) ?>;
            const labels = genderData.map(item => item.gender == 'L' ? 'Laki-laki' : 'Perempuan');
            const counts = genderData.map(item => item.count);
            
            new Chart(donutCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: counts,
                        backgroundColor: ['#4f46e5', '#ec4899'], // Indigo & Pink
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 25,
                                font: { weight: 'bold', size: 11, family: 'Inter' },
                                color: '#64748b'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<?php elseif(session()->get('role') == 'ortu'): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const attCtx = document.getElementById('parentAttendanceChart');
        if (attCtx) {
            new Chart(attCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Hadir', 'Izin/Sakit', 'Alfa'],
                    datasets: [{
                        data: [
                            <?= $parentData['attendance_stats']['present'] ?>, 
                            <?= $parentData['attendance_stats']['permission'] ?>, 
                            <?= $parentData['attendance_stats']['alpha'] ?>
                        ],
                        backgroundColor: ['#4f46e5', '#fbbf24', '#f43f5e'], // Indigo, Amber, Rose
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1E293B',
                            titleFont: { family: 'Inter', weight: '800', size: 12 },
                            bodyFont: { family: 'Inter', weight: '600', size: 11 },
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.raw + '%';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<?php endif; ?>

<?= $this->endSection() ?>
