<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <?php $brand = school_branding(); ?>
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Monitoring</h1>
            <p class="text-slate-500 mt-1">Garis besar performa akademik <?= $brand['name'] ?>.</p>
        </div>
        <div class="bg-indigo-50 px-6 py-3 rounded-2xl border border-indigo-100 flex items-center gap-3">
            <div class="bg-indigo-600 p-2 rounded-lg text-white shadow-lg shadow-indigo-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <span class="block text-[10px] uppercase font-bold text-indigo-400 tracking-wider">Tahun Akademik Aktif</span>
                <span class="block font-bold text-indigo-900 leading-none mt-0.5"><?= $activeYear['year'] ?? '-' ?> (<?= $activeYear['semester'] ?? '-' ?>)</span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Students -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <span class="block text-slate-400 text-xs font-bold uppercase tracking-widest">Total Siswa</span>
                    <span class="text-2xl font-black text-slate-800 leading-tight"><?= $stats['total_students'] ?></span>
                </div>
            </div>
        </div>

        <!-- Teachers -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="bg-purple-50 p-3 rounded-xl text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <span class="block text-slate-400 text-xs font-bold uppercase tracking-widest">Total Guru</span>
                    <span class="text-2xl font-black text-slate-800 leading-tight"><?= $stats['total_teachers'] ?></span>
                </div>
            </div>
        </div>

        <!-- Classes -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="bg-amber-50 p-3 rounded-xl text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <span class="block text-slate-400 text-xs font-bold uppercase tracking-widest">Total Kelas</span>
                    <span class="text-2xl font-black text-slate-800 leading-tight"><?= $stats['total_classes'] ?></span>
                </div>
            </div>
        </div>

        <!-- Ratings -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="bg-emerald-50 p-3 rounded-xl text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2zm0 0h10a2 2 0 002-2v-4a2 2 0 00-2-2h-2m-2 0V5a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
                </div>
                <div>
                    <span class="block text-slate-400 text-xs font-bold uppercase tracking-widest">Rata-rata Nilai</span>
                    <span class="text-2xl font-black text-slate-800 leading-tight"><?= $stats['avg_grade'] ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions / Monitoring Links -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <a href="<?= base_url('kepsek/monitoring/teachers') ?>" class="bg-indigo-600 rounded-2xl p-6 text-white shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all group">
            <div class="flex items-center justify-between mb-2">
                <div class="p-3 bg-white/20 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <svg class="w-5 h-5 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7"></path></svg>
            </div>
            <h3 class="font-bold text-lg">Monitoring Guru</h3>
            <p class="text-indigo-100 text-xs">Pantau beban mengajar dan penugasan guru.</p>
        </a>

        <a href="<?= base_url('kepsek/monitoring/grades') ?>" class="bg-purple-600 rounded-2xl p-6 text-white shadow-lg shadow-purple-100 hover:bg-purple-700 transition-all group">
            <div class="flex items-center justify-between mb-2">
                <div class="p-3 bg-white/20 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <svg class="w-5 h-5 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7"></path></svg>
            </div>
            <h3 class="font-bold text-lg">Monitoring Nilai</h3>
            <p class="text-purple-100 text-xs">Pantau progres pengisian nilai guru.</p>
        </a>

        <a href="<?= base_url('kepsek/monitoring/attendance') ?>" class="bg-emerald-600 rounded-2xl p-6 text-white shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all group">
            <div class="flex items-center justify-between mb-2">
                <div class="p-3 bg-white/20 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <svg class="w-5 h-5 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7"></path></svg>
            </div>
            <h3 class="font-bold text-lg">Monitoring Absensi</h3>
            <p class="text-emerald-100 text-xs">Rekap kehadiran harian siswa.</p>
        </a>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Grade Averages Chart -->
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-sm flex flex-col h-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-black text-slate-800 tracking-tight uppercase">Rata-rata Nilai Per Kelas</h2>
                <div class="flex gap-2">
                    <span class="w-3 h-3 bg-indigo-500 rounded-full"></span>
                </div>
            </div>
            <div class="flex-1 relative min-h-[300px]">
                <?php if (!empty($classGrades) && array_sum(array_column($classGrades, 'avg_score')) > 0): ?>
                    <canvas id="gradeChart"></canvas>
                <?php else: ?>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                        <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <p class="text-sm font-medium">Belum ada data nilai</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Attendance Chart -->
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-sm flex flex-col h-full">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h2 class="text-lg font-black text-slate-800 tracking-tight uppercase">Statistik Kehadiran</h2>
                <div class="flex flex-wrap gap-3 text-[10px] font-bold uppercase">
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 bg-emerald-500 rounded-full"></span> Hadir</div>
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 bg-amber-500 rounded-full"></span> Sakit</div>
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 bg-indigo-500 rounded-full"></span> Izin</div>
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 bg-rose-500 rounded-full"></span> Alfa</div>
                </div>
            </div>
            <div class="flex-1 relative min-h-[300px]">
                <?php if (array_sum($attendanceStats) > 0): ?>
                    <canvas id="attendanceChart"></canvas>
                <?php else: ?>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                        <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm font-medium">Belum ada data kehadiran</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grade Chart
    <?php if (!empty($classGrades) && array_sum(array_column($classGrades, 'avg_score')) > 0): ?>
    const gradeCtx = document.getElementById('gradeChart').getContext('2d');
    new Chart(gradeCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($classGrades, 'name')) ?>,
            datasets: [{
                label: 'Rata-rata Nilai',
                data: <?= json_encode(array_column($classGrades, 'avg_score')) ?>,
                backgroundColor: 'rgba(79, 70, 229, 0.8)',
                borderRadius: 8,
                barThickness: 25,
                hoverBackgroundColor: 'rgba(79, 70, 229, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, max: 100, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });
    <?php endif; ?>

    // Attendance Chart
    <?php if (array_sum($attendanceStats) > 0): ?>
    const attCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Sakit', 'Izin', 'Alfa'],
            datasets: [{
                data: [
                    <?= $attendanceStats['Hadir'] ?>, 
                    <?= $attendanceStats['Sakit'] ?>, 
                    <?= $attendanceStats['Izin'] ?>, 
                    <?= $attendanceStats['Alfa'] ?>
                ],
                backgroundColor: ['#10b981', '#f59e0b', '#6366f1', '#f43f5e'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } }
            }
        }
    });
    <?php endif; ?>
</script>
<?= $this->endSection() ?>
