<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="mb-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8 animate-in fade-in slide-in-from-top-4 duration-700">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase font-black uppercase tracking-widest">REKAP NILAI</span>
            </div>
            <h1 class="text-4xl font-black text-slate-800 tracking-tight leading-none">Rekap Nilai</h1>
            <p class="text-slate-500 mt-4 font-medium text-sm">Pilih kelas untuk melihat rekapitulasi nilai seluruh siswa.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate-in fade-in slide-in-from-bottom-4 duration-1000">
        <?php foreach($classes as $class): ?>
            <a href="<?= base_url('ledger/view/' . $class['id']) ?>" class="group relative bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-100/50 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
                <!-- Decorative element -->
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-indigo-50/50 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                
                <div class="relative">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-600 flex items-center justify-center text-white mb-6 shadow-xl shadow-indigo-100 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    
                    <h5 class="text-2xl font-black text-slate-800 tracking-tight mb-2 uppercase group-hover:text-indigo-600 transition-colors">Kelas <?= $class['name'] ?></h5>
                    <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">
                        <span class="text-indigo-600">TAHUN:</span>
                        <span><?= $class['academic_year'] ?></span>
                    </div>
                    
                    <div class="mt-8 flex items-center text-indigo-600 font-black text-[10px] tracking-[0.2em] uppercase group-hover:translate-x-2 transition-transform">
                        LIHAT NILAI AKHIR
                        <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?= $this->endSection() ?>
