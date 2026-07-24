<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="mb-10 flex flex-col xl:flex-row xl:items-end xl:justify-between gap-8">
        <div class="flex-1">
            <nav class="flex mb-3" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[10px] font-black uppercase tracking-[0.2em]">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Dashboard</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 font-black">Tugas & Materi</span>
                    </li>
                </ol>
            </nav>
            <h4 class="text-slate-800 text-5xl font-black tracking-tighter">Tugas & Materi</h4>
            <p class="text-slate-500 mt-2 font-medium tracking-tight">Pantau dan kerjakan tugas akademik anak Anda tepat waktu.</p>
        </div>

        <!-- Filters Section -->
        <div class="w-full xl:w-auto">
            <form action="<?= base_url('parent/assignments') ?>" method="GET" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="relative flex-1 md:w-58">
                    <input type="text" name="search" value="<?= $filters['search'] ?>" placeholder="Cari judul/guru..." 
                        class="w-full pl-12 pr-4 py-4 bg-white border border-slate-100 rounded-2xl text-xs font-bold placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-sm">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Subject Filter -->
                <div class="md:w-48">
                    <select name="subject_id" onchange="this.form.submit()" 
                        class="w-full px-5 py-4 bg-white border border-slate-100 rounded-2xl text-[11px] font-black uppercase tracking-widest text-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-sm appearance-none cursor-pointer">
                        <option value="">Semua Mapel</option>
                        <?php foreach($subjects as $subject): ?>
                            <option value="<?= $subject['id'] ?>" <?= $filters['subject_id'] == $subject['id'] ? 'selected' : '' ?>>
                                <?= $subject['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="md:w-48">
                    <select name="status" onchange="this.form.submit()" 
                        class="w-full px-5 py-4 bg-white border border-slate-100 rounded-2xl text-[11px] font-black uppercase tracking-widest text-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-sm appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="not_submitted" <?= $filters['status'] == 'not_submitted' ? 'selected' : '' ?>>🏠 Belum Dikirim</option>
                        <option value="submitted" <?= $filters['status'] == 'submitted' ? 'selected' : '' ?>>📤 Terkirim</option>
                        <option value="reviewed" <?= $filters['status'] == 'reviewed' ? 'selected' : '' ?>>✅ Ter-dinilai</option>
                        <option value="late" <?= $filters['status'] == 'late' ? 'selected' : '' ?>>⏰ Terlewati</option>
                    </select>
                </div>

                <?php if($filters['search'] || $filters['subject_id'] || $filters['status']): ?>
                    <a href="<?= base_url('parent/assignments') ?>" class="flex items-center justify-center w-12 h-14 bg-rose-50 border border-rose-100 text-rose-500 rounded-2xl hover:bg-rose-500 hover:text-white transition-all shadow-sm group" title="Clear Filters">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-12">
        <?php if(!empty($assignments)): ?>
            <?php foreach($assignments as $task): ?>
                <?php 
                    $isSubmitted = $task['sub_status'] != null;
                    $isReviewed = $task['sub_status'] == 'reviewed';
                    $deadlinePassed = strtotime($task['deadline']) < time();
                ?>
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col h-full">
                    <div class="p-8 flex-1">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex flex-wrap gap-2">
                                <span class="text-[10px] font-black <?= $isSubmitted ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-indigo-600 bg-indigo-50 border-indigo-100' ?> uppercase tracking-widest px-3 py-1.5 rounded-xl border">
                                    <?= $task['subject_name'] ?>
                                </span>
                                <span class="text-[10px] font-black text-slate-400 bg-slate-50 border-slate-100 uppercase tracking-widest px-3 py-1.5 rounded-xl border">
                                    <?= $task['type'] ?? 'Tugas' ?>
                                </span>
                            </div>
                            <div class="flex flex-col items-end">
                                <?php if($isReviewed): ?>
                                    <span class="text-xs font-black text-emerald-600">TERDINILAI</span>
                                <?php elseif($isSubmitted): ?>
                                    <span class="text-xs font-black text-amber-500">TERKIRIM</span>
                                <?php elseif($deadlinePassed): ?>
                                    <span class="text-xs font-black text-rose-500">TERLEWAT</span>
                                <?php else: ?>
                                    <span class="text-xs font-black text-indigo-400">AKTIF</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <h4 class="text-xl font-black text-slate-800 mb-3 tracking-tight leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2"><?= $task['title'] ?></h4>
                        
                        <div class="flex items-center text-xs font-bold text-slate-400 mb-6">
                            <svg class="h-4 w-4 mr-2 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Guru: <?= $task['teacher_name'] ?>
                        </div>

                        <div class="space-y-3 pt-4 border-t border-slate-50">
                            <div class="flex justify-between items-center text-[11px]">
                                <span class="font-bold text-slate-400 uppercase tracking-widest">Batasan Waktu</span>
                                <span class="font-black text-slate-700"><?= date('d M, H:i', strtotime($task['deadline'])) ?></span>
                            </div>
                            <?php if($isReviewed): ?>
                                <div class="flex justify-between items-center bg-emerald-50 p-2 rounded-xl">
                                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Nilai Akhir</span>
                                    <span class="text-lg font-black text-emerald-700"><?= $task['grade'] ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="px-8 pb-8">
                        <a href="<?= base_url('parent/assignments/view/' . $task['id']) ?>" class="w-full flex items-center justify-center py-4 bg-slate-50 hover:bg-indigo-600 hover:text-white rounded-2xl text-xs font-black transition-all duration-300 uppercase tracking-widest group/btn">
                            Lihat Detail
                            <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full bg-white rounded-[2rem] border-2 border-dashed border-slate-200 p-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h4 class="text-xl font-black text-slate-800 mb-2">Belum Ada Tugas</h4>
                <p class="text-slate-400 font-medium max-w-sm mx-auto">Saat ini belum ada tugas atau materi yang dibagikan untuk kelas Anda.</p>
            </div>
        <?php endif; ?>
    </div>
    <!-- Pagination -->
    <div class="mb-12">
        <?= $pager->links('assignments', 'tailwind_pager') ?>
    </div>
<?= $this->endSection() ?>
