<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
        <div>
            <nav class="flex mb-3" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[10px] font-black uppercase tracking-[0.2em]">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Dashboard</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="<?= base_url('parent/announcements') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Informasi</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 font-black">Detail</span>
                    </li>
                </ol>
            </nav>
            <h3 class="text-slate-800 text-3xl sm:text-4xl lg:text-5xl font-black tracking-tighter">Detail Informasi</h3>
            <p class="text-slate-500 mt-2 font-medium tracking-tight">Informasi resmi dari <?= $announcement['target_role'] == 'all' ? 'Sekolah' : 'Wali Kelas' ?>.</p>
        </div>
        <div class="flex items-center gap-3">
             <button onclick="window.print()" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 no-print">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak
             </button>
             <a href="<?= base_url('parent/announcements') ?>" class="inline-flex items-center px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm no-print">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
             </a>
        </div>
    </div>

    <!-- Style for printing -->
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .bg-white { border: none !important; shadow: none !important; }
        }
    </style>

    <div class="max-w-4xl mx-auto px-4 sm:px-0">
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative">
            <div class="absolute right-0 top-0 p-8">
                <?php if($announcement['target_role'] == 'all'): ?>
                    <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest bg-indigo-50 px-4 py-2 rounded-xl border border-indigo-100 shadow-sm shadow-indigo-50">Portal Sekolah</span>
                <?php else: ?>
                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-4 py-2 rounded-xl border border-emerald-100 shadow-sm shadow-emerald-50">Pesan Wali Kelas</span>
                <?php endif; ?>
            </div>

            <div class="p-8 sm:p-12 lg:p-16">
                <div class="flex items-center gap-2 mb-6">
                    <svg class="h-4 w-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="text-xs font-bold text-slate-400 tabular-nums uppercase tracking-widest"><?= date('d F Y', strtotime($announcement['created_at'])) ?></span>
                    <span class="mx-2 text-slate-200">/</span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest"><?= date('H:i', strtotime($announcement['created_at'])) ?> WIB</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-800 tracking-tight leading-tight mb-8"><?= $announcement['title'] ?></h1>
                
                <div class="w-20 h-1.5 bg-indigo-600 rounded-full mb-12"></div>

                <div class="prose prose-slate max-w-none prose-p:text-slate-600 prose-p:leading-relaxed prose-p:text-lg prose-p:font-medium">
                    <?= nl2br($announcement['content']) ?>
                </div>

                <div class="mt-16 pt-10 border-t border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center border border-slate-200">
                             <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Diterbitkan Oleh</p>
                            <p class="text-sm font-bold text-slate-700"><?= $announcement['target_role'] == 'all' ? 'Administrasi Sekolah' : 'Wali Kelas' ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-50 border-t border-slate-100 p-8 flex justify-center">
                 <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em]">SD ISLAM AL-UKHUWAH CITARIK • SISTEM INFORMASI AKADEMIK</p>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
