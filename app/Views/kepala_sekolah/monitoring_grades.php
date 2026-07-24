<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Monitoring Input Nilai</h1>
            <p class="text-gray-500 text-sm">Memantau kemajuan pengisian nilai oleh guru di setiap kelas.</p>
        </div>
    </div>

    <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-2xl mb-8 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-indigo-600 p-2 rounded-lg text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <span class="block text-[10px] uppercase font-bold text-indigo-400">Tahun Akademik</span>
                <span class="block font-bold text-indigo-900"><?= $activeYear['year'] ?? '-' ?> (<?= $activeYear['semester'] ?? '-' ?>)</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach($gradeProgress as $class): ?>
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-black text-slate-800 text-xl">Kelas <?= $class['name'] ?></h3>
                <span class="bg-slate-100 text-slate-500 px-3 py-1 rounded-full text-[10px] font-bold uppercase">ID: <?= $class['id'] ?></span>
            </div>
            
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between items-end mb-1">
                        <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Mata Pelajaran Dinilai</span>
                        <span class="text-slate-800 font-bold"><?= $class['subjects_graded'] ?> Mapel</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-50">
                    <a href="<?= base_url('ledger/view/' . $class['id']) ?>" class="text-indigo-600 hover:text-indigo-800 text-xs font-bold flex items-center group">
                        LIHAT DETAIL NILAI
                        <svg class="w-3 h-3 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>
