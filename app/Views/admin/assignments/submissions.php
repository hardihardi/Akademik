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
                        <a href="<?= base_url('assignments') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Pembelajaran</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 font-black">Peninjauan Pengumpulan</span>
                    </li>
                </ol>
            </nav>
            <h3 class="text-slate-800 text-3xl font-black tracking-tighter leading-none mb-2"><?= $assignment['title'] ?></h3>
            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-[10px] font-black text-slate-500 uppercase tracking-widest"><?= $class['name'] ?></span>
                <span class="px-3 py-1 bg-indigo-50 border border-indigo-100 rounded-lg text-[10px] font-black text-indigo-600 uppercase tracking-widest"><?= $assignment['type'] ?? 'Tugas' ?></span>
                <span class="text-slate-400 text-xs font-bold">Batas Waktu: <?= date('d M Y, H:i', strtotime($assignment['deadline'])) ?></span>
            </div>
        </div>
        <div class="flex items-center gap-3 md:gap-4">
             <a href="<?= base_url('assignments') ?>" class="inline-flex items-center px-4 md:px-5 py-3 bg-white border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-sm group">
                <svg class="w-4 h-4 md:mr-2 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="hidden md:inline">Kembali</span>
             </a>
             <div class="px-4 md:px-6 py-3 bg-white rounded-2xl border border-slate-100 shadow-sm flex items-center">
                <span class="hidden sm:inline text-[10px] font-black text-slate-400 uppercase tracking-widest mr-3">Total Submissions</span>
                <span class="text-xl md:text-2xl font-black text-indigo-600"><?= count($submissions) ?></span>
             </div>
        </div>
    </div>

    <!-- Submissions Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Siswa</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Berkas</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Nilai</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(!empty($submissions)): ?>
                        <?php foreach($submissions as $sub): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mr-4 font-black text-sm">
                                            <?= substr($sub['student_name'], 0, 1) ?>
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-800 tracking-tight leading-none mb-1 group-hover:text-indigo-600 transition-colors"><?= $sub['student_name'] ?></p>
                                            <p class="text-[10px] font-bold text-slate-400 tracking-widest uppercase">NIS: <?= $sub['nis'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest <?= $sub['status'] == 'reviewed' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' ?>">
                                        <?= $sub['status'] == 'reviewed' ? 'TERDINILAI' : 'BELUM DINILAI' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <a href="<?= base_url('assignments/download-submission/' . $sub['id']) ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 group/link">
                                        <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        <span class="text-[10px] font-black uppercase tracking-widest border-b border-transparent group-hover/link:border-indigo-800 transition-all">UNDUH</span>
                                    </a>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <span class="text-xl font-black text-slate-800"><?= $sub['grade'] ?? '-' ?></span>
                                </td>
                                <td class="px-8 py-6 text-right" x-data="{ open: false, grade: '<?= $sub['grade'] ?>', feedback: '<?= $sub['feedback'] ?>' }">
                                    <button @click="open = true" class="px-4 py-2.5 bg-white border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 text-slate-500 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                                        <?= $sub['status'] == 'reviewed' ? 'UBAH NILAI' : 'BERI NILAI' ?>
                                    </button>

                                    <!-- Grading Modal -->
                                    <div x-show="open" 
                                         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                                         x-cloak>
                                        <div class="bg-white w-full max-w-md p-8 rounded-[2.5rem] shadow-2xl relative text-left" @click.away="open = false">
                                            <h4 class="text-2xl font-black text-slate-800 tracking-tighter mb-1">Penilaian Pembelajaran</h4>
                                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8"><?= $sub['student_name'] ?></p>
                                            
                                            <form action="<?= base_url('assignments/grade/' . $sub['id']) ?>" method="POST">
                                                <div class="space-y-6">
                                                    <div>
                                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Nilai (0-100)</label>
                                                        <input type="number" name="grade" x-model="grade" class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-sm font-bold text-slate-800" min="0" max="100" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Feedback / Catatan</label>
                                                        <textarea name="feedback" x-model="feedback" class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-sm font-medium text-slate-800 h-24" placeholder="Tulis catatan pengerjaan siswa di sini..."></textarea>
                                                    </div>
                                                    
                                                    <div class="flex gap-3 pt-4">
                                                        <button type="button" @click="open = false" class="flex-1 py-4 text-[10px] font-black text-slate-400 tracking-widest uppercase hover:bg-slate-50 rounded-2xl transition-all">Batal</button>
                                                        <button type="submit" class="flex-[1.5] py-4 bg-indigo-600 text-white rounded-2xl text-[10px] font-black tracking-[0.2em] shadow-lg shadow-indigo-100 transition-all hover:scale-[1.02] active:scale-[0.98]">SIMPAN NILAI</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="w-14 h-14 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Belum ada pengumpulan dari siswa.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>
