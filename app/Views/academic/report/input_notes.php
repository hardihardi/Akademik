<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-4 sm:p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-top-4 duration-700">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <a href="<?= base_url('report') ?>" class="hover:text-indigo-600 transition-colors uppercase">RAPOR</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase font-black tracking-widest">CATATAN WALI KELAS</span>
            </div>
            <h1 class="text-4xl font-black text-slate-800 tracking-tight leading-none uppercase"><?= $student['full_name'] ?></h1>
            <p class="text-slate-500 font-medium uppercase text-[10px] tracking-widest">NIS: <?= $student['nis'] ?> &bull; Semester <?= $semester ?> &bull; <?= $activeYear['year'] ?></p>
        </div>
        <a href="<?= base_url('report/students/' . $student['class_id']) ?>" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-white border border-slate-200 text-slate-500 font-black text-[10px] tracking-widest shadow-sm hover:bg-slate-50 hover:text-indigo-600 transition-all duration-300 uppercase shrink-0">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            KEMBALI KE DAFTAR
        </a>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-slate-50 rounded-full -z-0"></div>
        
        <form action="<?= base_url('report/save-notes') ?>" method="post" class="p-8 md:p-12 relative z-10 space-y-10">
            <?= csrf_field() ?>
            <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
            <input type="hidden" name="class_id" value="<?= $student['class_id'] ?>">
            <input type="hidden" name="academic_year_id" value="<?= $activeYear['id'] ?>">
            <input type="hidden" name="semester" value="<?= $semester ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Info Section -->
                <div class="space-y-8">
                    <div class="bg-indigo-50 border border-indigo-100 rounded-3xl p-8 space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-50">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-indigo-900 uppercase tracking-tight">Informasi Rapor</h4>
                                <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mt-1">Status dan Kenaikan</p>
                            </div>
                        </div>

                        <div class="space-y-4 pt-2">
                            <p class="text-xs text-indigo-700 leading-relaxed font-medium">Catatan wali kelas mencakup perkembangan karakter, prestasi, dan saran motivasi untuk siswa selama satu semester.</p>
                            
                            <?php if($semester == '2'): ?>
                            <div class="p-4 bg-white/60 border border-indigo-200 rounded-2xl flex items-start gap-4">
                                <span class="flex-shrink-0 w-2 h-2 mt-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                <div>
                                    <p class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Kenaikan Kelas</p>
                                    <p class="text-[10px] text-slate-500 font-medium mt-1">Semester 2 mengharuskan pemilihan status promosi siswa ke tingkat berikutnya.</p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($semester == '2'): ?>
                    <div class="space-y-4">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Keputusan Akhir Tahun</label>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" name="promotion_status" value="Naik" <?= ($reportCard['promotion_status'] ?? '') == 'Naik' ? 'checked' : '' ?> class="peer hidden">
                                <div class="px-6 py-4 rounded-2xl border-2 border-slate-50 bg-slate-50 text-slate-500 font-black text-[11px] tracking-widest text-center transition-all peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600 peer-checked:shadow-xl group-hover:border-slate-200 uppercase">
                                    Naik Kelas
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" name="promotion_status" value="Tidak Naik" <?= ($reportCard['promotion_status'] ?? '') == 'Tidak Naik' ? 'checked' : '' ?> class="peer hidden">
                                <div class="px-6 py-4 rounded-2xl border-2 border-slate-50 bg-slate-50 text-slate-500 font-black text-[11px] tracking-widest text-center transition-all peer-checked:bg-rose-600 peer-checked:text-white peer-checked:border-rose-600 peer-checked:shadow-xl group-hover:border-slate-200 uppercase">
                                    Tinggal Kelas
                                </div>
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Notes Section -->
                <div class="space-y-6">
                    <div class="space-y-4">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Catatan Wali Kelas</label>
                        <textarea name="homeroom_notes" rows="10" class="w-full p-8 rounded-[2rem] bg-slate-50 border-2 border-slate-50 text-slate-700 font-medium text-sm focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all outline-none leading-relaxed placeholder:text-slate-300 placeholder:italic" placeholder="Berikan saran dan deskripsi perkembangan siswa..."><?= $reportCard['homeroom_notes'] ?? '' ?></textarea>
                    </div>

                    <div class="flex items-center justify-end pt-4">
                        <button type="submit" class="w-full sm:w-auto px-12 h-16 rounded-2xl bg-indigo-600 text-white font-black text-[11px] tracking-widest shadow-2xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 transition-all duration-300 uppercase flex items-center justify-center gap-3">
                            SIMPAN CATATAN
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
