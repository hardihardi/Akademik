<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8 lg:mb-12 flex flex-col lg:flex-row lg:items-center justify-between gap-6 lg:gap-10">
    <div class="flex-1 min-w-0">
        <nav class="flex mb-4 text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em]" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">DASHBOARD</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-3 h-3 text-slate-300 mx-1 md:mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-indigo-600">KEHADIRAN SISWA</span>
                </li>
            </ol>
        </nav>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight uppercase leading-tight truncate">
            <?= $title ?>
        </h1>
        <p class="text-slate-500 mt-2 text-xs sm:text-sm font-medium leading-relaxed max-w-3xl">
            Dokumentasikan kehadiran siswa dan pantau kedisiplinan harian secara realtime.
        </p>
    </div>

    <!-- Global Action & Search -->
    <div class="w-full lg:w-auto">
        <form action="<?= base_url('attendance') ?>" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1 sm:w-64 lg:w-72">
                <input type="text" name="search" value="<?= $filters['search'] ?? '' ?>" placeholder="Cari nama kelas..." 
                    class="w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-2xl text-xs sm:text-sm font-bold focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-50 transition-all shadow-sm">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-5 h-5 transition-colors group-focus-within:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <div class="sm:w-48 relative group">
                <select name="academic_year_id" onchange="this.form.submit()" 
                    class="w-full pl-5 pr-10 py-4 bg-white border border-slate-200 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-50 transition-all shadow-sm cursor-pointer appearance-none">
                    <option value="">Semua Tahun</option>
                    <?php foreach($academicYears as $year): ?>
                        <option value="<?= $year['id'] ?>" <?= ($filters['academic_year_id'] ?? '') == $year['id'] ? 'selected' : '' ?>>
                            <?= $year['year'] ?> - <?= $year['semester'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300 group-hover:text-indigo-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>

            <?php if(($filters['search'] ?? '') || ($filters['academic_year_id'] ?? '')): ?>
                <a href="<?= base_url('attendance') ?>" class="inline-flex items-center justify-center w-14 h-14 sm:h-auto bg-rose-50 text-rose-500 rounded-2xl hover:bg-rose-500 hover:text-white transition-all border border-rose-100 shadow-sm active:scale-95" title="Hapus Filter">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>

    <!-- Alert Success/Error -->
    <?php if(session()->getFlashdata('error')):?>
        <div class="mb-8 p-4 md:p-6 bg-rose-50 border-2 border-rose-100 rounded-3xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-white flex items-center justify-center text-rose-600 shadow-sm flex-shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-rose-800 font-black text-xs md:text-sm tracking-tight uppercase">Gagal Memproses</p>
                <p class="text-rose-600 text-[11px] md:text-xs font-bold"><?= session()->getFlashdata('error') ?></p>
            </div>
        </div>
    <?php endif;?>

    <!-- Grid Kelas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        <?php foreach($classes as $class): ?>
        <div class="group bg-white rounded-[2rem] shadow-sm border border-slate-100 p-6 md:p-8 hover:shadow-2xl hover:shadow-indigo-100/50 transition-all duration-500 relative overflow-hidden flex flex-col">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-full -mr-12 -mt-12 group-hover:bg-indigo-600 transition-colors duration-500 opacity-20 group-hover:opacity-10"></div>
            
            <!-- Card Header -->
            <div class="relative z-10 flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <span class="px-3 py-1 bg-slate-50 text-slate-500 text-[9px] font-black rounded-lg border border-slate-100 uppercase tracking-widest group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-all">
                    T.A <?= $class['academic_year'] ?>
                </span>
            </div>

            <!-- Card Body -->
            <div class="relative z-10 flex-1">
                <h2 class="text-2xl font-black text-slate-800 tracking-tight mb-2 group-hover:text-indigo-600 transition-colors">
                    Kelas <?= $class['name'] ?>
                </h2>
                <p class="text-xs font-medium text-slate-400 mb-6 leading-relaxed">
                    Kelola kehadiran, rekapitulasi, dan persetujuan izin siswa dalam satu panel.
                </p>
            </div>
            
            <!-- Card Actions -->
            <div class="relative z-10 flex flex-col gap-3">
                <!-- Tombol Input Harian -->
                <a href="<?= base_url('attendance/input/' . $class['id']) ?>" 
                   class="flex items-center justify-center w-full px-5 py-3.5 bg-indigo-600 text-white rounded-xl font-black text-[10px] tracking-[0.1em] uppercase shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Input Kehadiran
                </a>

                <div class="grid grid-cols-2 gap-3">
                    <!-- Tombol Persetujuan (Per Kelas) -->
                    <a href="<?= base_url('attendance/submissions?class_id=' . $class['id']) ?>" 
                       class="flex items-center justify-center px-4 py-3 bg-rose-50 text-rose-600 border border-rose-100 rounded-xl font-black text-[9px] tracking-wider uppercase hover:bg-rose-600 hover:text-white transition-all duration-300">
                        <i class="ph-bold ph-bell-ringing mr-1.5 text-sm"></i>
                        Persetujuan Izin/Sakit
                    </a>

                    <!-- Tombol Rekap -->
                    <a href="<?= base_url('attendance-recap/view/' . $class['id']) ?>" 
                       class="flex items-center justify-center px-4 py-3 bg-white border border-slate-200 text-slate-500 rounded-xl font-black text-[9px] tracking-wider uppercase hover:border-indigo-600 hover:text-indigo-600 transition-all duration-300">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Rekap Kehadiran
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>