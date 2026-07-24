<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-4 sm:p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-top-4 duration-700">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <a href="<?= base_url('report') ?>" class="hover:text-indigo-600 transition-colors uppercase">CETAK RAPOR</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase font-black tracking-widest">DAFTAR SISWA</span>
            </div>
            <h1 class="text-4xl font-black text-slate-800 tracking-tight leading-none uppercase">Kelas: <?= $class['name'] ?> - <?= $activeYear['year'] ?></h1>
            <p class="text-slate-500 font-medium">Kelola penilaian akhir dan cetak rapor semester <?= ($activeYear['semester'] == '1' || $activeYear['semester'] == 'Ganjil') ? 'Ganjil' : 'Genap' ?> Tahun Pelajaran <?= $activeYear['year'] ?>.</p>
        </div>
        <div class="flex flex-wrap gap-4 shrink-0">
            <a href="<?= base_url('report/sync/' . $class['id']) ?>" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-amber-500 text-white font-black text-[10px] tracking-widest shadow-xl shadow-amber-100 hover:bg-amber-600 hover:shadow-amber-200 hover:-translate-y-1 active:scale-95 transition-all duration-300 uppercase">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                SINKRONKAN DATA
            </a>
            <a href="<?= base_url('report') ?>" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-white border border-slate-200 text-slate-500 font-black text-[10px] tracking-widest shadow-sm hover:bg-slate-50 hover:text-indigo-600 transition-all duration-300 uppercase">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                KEMBALI KE KELAS
            </a>
        </div>
    </div>

    <!-- Student List Card -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        
        <!-- Desktop View: Table -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest w-20 text-center">No</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Informasi Siswa</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Semester</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi & Administrasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(empty($students)): ?>
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <p class="text-slate-400 font-black uppercase tracking-widest">Tidak ada siswa di kelas ini</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach($students as $student): ?>
                        <tr class="hover:bg-slate-50/20 transition-colors group">
                            <td class="px-8 py-6 text-center text-xs font-black text-slate-300 font-mono"><?= str_pad($i++, 2, '0', STR_PAD_LEFT) ?></td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-600 transition-all duration-500">
                                        <span class="text-xs font-black uppercase"><?= substr($student['full_name'], 0, 2) ?></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800 uppercase tracking-tight leading-none"><?= $student['full_name'] ?></p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-2">NIS: <?= $student['nis'] ?> &bull; NISN: <?= $student['nisn'] ?? '-' ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-xl border border-indigo-100 uppercase tracking-widest shrink-0">
                                    Semester <?= $activeYear['semester'] ?>
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end gap-2">
                                    <?php $semNum = $activeYear['semester'] == 'Ganjil' ? '1' : '2'; ?>
                                    <a href="<?= base_url('report/notes/' . $student['id']) ?>" class="h-10 px-4 rounded-xl bg-slate-50 text-slate-600 border border-slate-100 flex items-center justify-center text-[9px] font-black tracking-widest hover:bg-white hover:border-indigo-400 hover:text-indigo-600 transition-all uppercase" title="Catatan">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        CATATAN
                                    </a>
                                    <a href="<?= base_url('report/download-pdf/' . $student['id'] . '?semester=' . $semNum) ?>" class="h-10 px-4 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-[9px] font-black tracking-widest hover:bg-emerald-600 hover:text-white transition-all uppercase" title="Download PDF">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        PDF
                                    </a>
                                    <a href="<?= base_url('report/print/' . $student['id'] . '?semester=' . $semNum) ?>" target="_blank" class="h-10 px-4 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-[9px] font-black tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all uppercase" title="Cetak">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        CETAK
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile View: Cards -->
        <div class="lg:hidden p-4 space-y-4 bg-slate-50/30">
            <?php if(empty($students)): ?>
                <div class="py-20 text-center opacity-20">
                    <p class="font-black uppercase tracking-widest text-xs">Tidak ada siswa di kelas ini</p>
                </div>
            <?php else: ?>
                <?php $i = 1; foreach($students as $student): ?>
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-6">
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs shadow-sm border border-indigo-100">
                                <?= $i++ ?>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight"><?= $student['full_name'] ?></h4>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">NIS: <?= $student['nis'] ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a href="<?= base_url('report/notes/' . $student['id']) ?>" class="w-full h-14 rounded-2xl bg-slate-50 border border-slate-100 text-slate-600 font-black text-[10px] tracking-widest flex items-center justify-center hover:bg-slate-100 transition-all uppercase">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            CATATAN WALI KELAS
                        </a>
                        <div class="grid grid-cols-2 gap-3">
                            <?php $semNum = $activeYear['semester'] == 'Ganjil' ? '1' : '2'; ?>
                            <a href="<?= base_url('report/download-pdf/' . $student['id'] . '?semester=' . $semNum) ?>" class="h-14 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 font-black text-[10px] tracking-widest flex items-center justify-center hover:bg-emerald-100 transition-all uppercase">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                PDF
                            </a>
                            <a href="<?= base_url('report/print/' . $student['id'] . '?semester=' . $semNum) ?>" target="_blank" class="h-14 rounded-2xl bg-indigo-600 text-white font-black text-[10px] tracking-widest flex items-center justify-center hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all uppercase">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                CETAK
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
