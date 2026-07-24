<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-4 sm:p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-top-4 duration-700">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase font-black tracking-widest">RAPOR SISWA</span>
            </div>
            <h1 class="text-4xl font-black text-slate-800 tracking-tight leading-none uppercase"><?= $title ?></h1>
            <p class="text-slate-500 font-medium">Pilih kelas untuk mengelola dan mencetak rapor akademik siswa.</p>
        </div>
    </div>

    <!-- Selection Card -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-slate-50 rounded-full -z-0"></div>
        
        <div class="p-8 md:p-12 relative z-10">
            <!-- Active Year Info -->
            <div class="bg-indigo-600 rounded-3xl p-8 mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 shadow-2xl shadow-indigo-100 border border-indigo-500 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/20">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-indigo-200 font-black uppercase tracking-[0.2em] mb-1">Tahun Akademik Aktif</p>
                        <p class="text-2xl font-black text-white tracking-tight uppercase"><?= $activeYear['year'] ?? '-' ?> &bull; <?= ($activeYear['semester'] == '1' ? 'GANJIL' : 'GENAP') ?></p>
                    </div>
                </div>
                <div class="px-6 py-3 bg-white/10 rounded-xl border border-white/20 text-white text-[10px] font-black tracking-widest uppercase">
                    STATUS: AKTIF
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($classes as $class): ?>
                <a href="<?= base_url('report/students/' . $class['id']) ?>" class="group">
                    <div class="h-full bg-slate-50 border-2 border-slate-50 rounded-[2rem] p-8 flex flex-col justify-between hover:bg-white hover:border-indigo-500 hover:shadow-2xl hover:shadow-indigo-100 transition-all duration-500 group-hover:-translate-y-2">
                        <div class="space-y-4">
                            <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-indigo-600 border border-slate-100 group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-600 transition-all duration-500">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight leading-none"><?= $class['name'] ?></h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Pilih untuk Lihat Siswa</p>
                            </div>
                        </div>
                        <div class="mt-8 flex items-center justify-between">
                            <span class="flex items-center gap-1.5 text-[9px] font-black text-indigo-600 uppercase tracking-widest">
                                Buka Kelas
                                <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
