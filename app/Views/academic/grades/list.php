<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-4 sm:p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-top-4 duration-700">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase font-black tracking-widest">RIWAYAT NILAI</span>
            </div>
            <h1 class="text-4xl font-black text-slate-800 tracking-tight leading-none uppercase"><?= $title ?></h1>
            <p class="text-slate-500 font-medium">Telusuri dan kelola data nilai siswa yang telah diinput.</p>
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <!-- Redundant manual entry removed to favor Task & Material flow -->
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-2 sm:p-4">
        <form method="get" action="<?= base_url('grades/list') ?>" class="flex flex-col lg:flex-row gap-4">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative group">
                    <select name="class_id" class="w-full h-14 pl-6 pr-12 rounded-2xl bg-slate-50 border-2 border-slate-50 text-slate-700 font-black text-[11px] appearance-none focus:bg-white focus:border-indigo-500 transition-all outline-none uppercase tracking-widest">
                        <option value="">SEMUA KELAS</option>
                        <?php foreach($classes as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= $selectedClass == $c['id'] ? 'selected' : '' ?>><?= strtoupper($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-hover:text-indigo-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
                <div class="relative group">
                    <select name="subject_id" class="w-full h-14 pl-6 pr-12 rounded-2xl bg-slate-50 border-2 border-slate-50 text-slate-700 font-black text-[11px] appearance-none focus:bg-white focus:border-indigo-500 transition-all outline-none uppercase tracking-widest">
                        <option value="">SEMUA MATA PELAJARAN</option>
                        <?php foreach($subjects as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= $selectedSubject == $s['id'] ? 'selected' : '' ?>><?= strtoupper($s['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-hover:text-indigo-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>
            <button type="submit" class="h-14 px-8 rounded-2xl bg-slate-800 text-white font-black text-[10px] tracking-widest hover:bg-slate-900 transition-all uppercase">
                Terapkan Filter
            </button>
            <?php if($selectedClass || $selectedSubject): ?>
                <a href="<?= base_url('grades/list') ?>" class="h-14 px-6 rounded-2xl bg-white border border-slate-200 text-slate-400 font-black text-[10px] tracking-widest hover:bg-slate-50 hover:text-rose-500 flex items-center justify-center transition-all uppercase">
                    Reset
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Data List -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        
        <!-- Desktop View Table -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest w-20 text-center">No</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Informasi Siswa</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Mata Pelajaran</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Periode</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Nilai</th>
                        <!-- Actions column removed -->
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(empty($grades)): ?>
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center opacity-20">
                                    <svg class="w-20 h-20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                    <p class="font-black uppercase tracking-widest">Belum ada data nilai</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1 + (($pager->getCurrentPage('grades') - 1) * 20); foreach($grades as $grade): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6 text-center text-xs font-black text-slate-300 font-mono"><?= str_pad($i++, 2, '0', STR_PAD_LEFT) ?></td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                        <span class="text-xs font-black"><?= strtoupper(substr($grade['student_name'], 0, 1)) ?></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-700 uppercase tracking-tight"><?= $grade['student_name'] ?></p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-2 py-0.5 bg-slate-50 rounded-lg"><?= $grade['class_name'] ?></span>
                                            <span class="text-[9px] font-bold text-slate-300 uppercase tracking-widest italic">NIS: <?= $grade['nis'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-[11px] font-black text-slate-600 uppercase tracking-widest"><?= $grade['subject_name'] ?></p>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="inline-flex items-center px-3 py-1.5 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 text-[9px] font-black uppercase tracking-widest">
                                    <?= $grade['type'] ?> (S<?= $grade['semester'] ?>)
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="text-2xl font-black <?= $grade['score'] < 75 ? 'text-rose-600' : 'text-slate-800' ?> tracking-tighter"><?= $grade['score'] ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile View Cards -->
        <div class="lg:hidden p-4 space-y-4 bg-slate-50/30">
            <?php if(empty($grades)): ?>
                <div class="py-20 text-center opacity-20">
                    <p class="font-black uppercase tracking-widest text-xs">Belum ada data nilai</p>
                </div>
            <?php else: ?>
                <?php foreach($grades as $grade): ?>
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-5">
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-black text-sm">
                                <?= strtoupper(substr($grade['student_name'], 0, 1)) ?>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight"><?= $grade['student_name'] ?></h4>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5"><?= $grade['class_name'] ?> • NIS: <?= $grade['nis'] ?></p>
                            </div>
                        </div>
                        <div class="text-2xl font-black <?= $grade['score'] < 75 ? 'text-rose-600' : 'text-slate-800' ?>"><?= $grade['score'] ?></div>
                    </div>
                    
                    <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <div class="bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                            <?= $grade['subject_name'] ?>
                        </div>
                        <div class="bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg border border-indigo-100">
                            <?= $grade['type'] ?> (S<?= $grade['semester'] ?>)
                        </div>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <!-- Actions removed -->
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pagination -->
    <?php if(!empty($grades)): ?>
        <div class="flex justify-center pt-8">
            <div class="bg-white px-8 py-6 rounded-[2rem] shadow-sm border border-slate-100">
                <?= $pager->links('grades', 'tailwind_pager') ?>
            </div>
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>
