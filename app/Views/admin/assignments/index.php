<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600">PEMBELAJARAN</span>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight"><?= $title ?></h1>
            <?php if(isset($activeYear)): ?>
            <p class="text-indigo-600 font-bold text-xs mt-1 uppercase tracking-widest">Tahun Akademik Aktif: <?= $activeYear['year'] ?> (<?= $activeYear['semester'] == 1 ? 'Ganjil' : 'Genap' ?>)</p>
            <?php endif; ?>
            <p class="text-slate-500 mt-1.5 font-medium text-xs lg:text-sm">Daftar pembelajaran untuk siswa.</p>
        </div>
        <?php if(session()->get('role') == 'guru' || session()->get('role') == 'admin'): ?>
        <div class="flex-shrink-0">
            <a href="<?= base_url('assignments/create') ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-5 sm:px-6 lg:px-8 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-indigo-600 text-white font-black text-[10px] lg:text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-0.5 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                TAMBAH PEMBELAJARAN
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Filter Section -->
    <div class="mb-6 sm:mb-8">
        <form action="<?= base_url('assignments') ?>" method="GET" class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 items-stretch sm:items-end">
            <!-- Search -->
            <div class="relative flex-1 min-w-0">
                <input type="text" name="search" value="<?= $filters['search'] ?? '' ?>" placeholder="Cari judul, guru, mapel..." 
                    class="w-full pl-10 sm:pl-12 pr-4 py-3 sm:py-4 bg-white border border-slate-100 rounded-xl sm:rounded-2xl text-xs font-bold placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-sm">
                <div class="absolute left-3.5 sm:left-4 top-1/2 -translate-y-1/2 text-slate-300">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <!-- Class, Type & Status Filter Row -->
            <div class="grid grid-cols-2 lg:flex gap-3 sm:gap-4">
                <div class="sm:flex-none sm:w-40 lg:w-48">
                    <select name="class_id" onchange="this.form.submit()" 
                        class="w-full px-4 sm:px-5 py-3 sm:py-4 bg-white border border-slate-100 rounded-xl sm:rounded-2xl text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-sm appearance-none cursor-pointer">
                        <option value="">Semua Kelas</option>
                        <?php foreach($classes as $class): ?>
                            <option value="<?= $class['id'] ?>" <?= ($filters['class_id'] ?? '') == $class['id'] ? 'selected' : '' ?>>
                                <?= $class['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="sm:flex-none sm:w-40 lg:w-48">
                    <select name="type" onchange="this.form.submit()" 
                        class="w-full px-4 sm:px-5 py-3 sm:py-4 bg-white border border-slate-100 rounded-xl sm:rounded-2xl text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-sm appearance-none cursor-pointer">
                        <option value="">Semua Tipe</option>
                        <option value="Tugas" <?= ($filters['type'] ?? '') == 'Tugas' ? 'selected' : '' ?>>📝 Tugas</option>
                        <option value="Materi" <?= ($filters['type'] ?? '') == 'Materi' ? 'selected' : '' ?>>📚 Materi</option>
                        <option value="Ulangan" <?= ($filters['type'] ?? '') == 'Ulangan' ? 'selected' : '' ?>>📋 Ulangan</option>
                        <option value="UTS" <?= ($filters['type'] ?? '') == 'UTS' ? 'selected' : '' ?>>📊 UTS</option>
                        <option value="UAS" <?= ($filters['type'] ?? '') == 'UAS' ? 'selected' : '' ?>>🏆 UAS</option>
                        <option value="Sikap" <?= ($filters['type'] ?? '') == 'Sikap' ? 'selected' : '' ?>>🌟 Sikap</option>
                    </select>
                </div>

                <!-- Grading Status Filter -->
                <div class="sm:flex-none sm:w-40 lg:w-48">
                    <select name="grading_status" onchange="this.form.submit()" 
                        class="w-full px-4 sm:px-5 py-3 sm:py-4 bg-white border border-slate-100 rounded-xl sm:rounded-2xl text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-sm appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="graded" <?= ($filters['grading_status'] ?? '') == 'graded' ? 'selected' : '' ?>>✅ Selesai</option>
                        <option value="ungraded" <?= ($filters['grading_status'] ?? '') == 'ungraded' ? 'selected' : '' ?>>🔔 Perlu Dinilai</option>
                    </select>
                </div>

                <?php if(($filters['search'] ?? '') || ($filters['class_id'] ?? '') || ($filters['type'] ?? '') || ($filters['grading_status'] ?? '')): ?>
                    <a href="<?= base_url('assignments') ?>" class="flex items-center justify-center w-full sm:w-12 h-12 sm:h-auto bg-rose-50 border border-rose-100 text-rose-500 rounded-xl sm:rounded-2xl hover:bg-rose-500 hover:text-white transition-all shadow-sm flex-shrink-0 lg:w-12 lg:h-14" title="Clear Filters">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <span class="sm:hidden ml-2 text-[10px] font-black">Hapus Filter</span>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <?php if(session()->getFlashdata('message')):?>
        <div class="mb-6 p-4 sm:p-5 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-600 shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                </div>
                <p class="text-sm font-bold text-emerald-800"><?= session()->getFlashdata('message') ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    <?php endif;?>

    <?php if(session()->getFlashdata('error')):?>
        <div class="mb-6 p-4 sm:p-5 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-rose-600 shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01" /></svg>
                </div>
                <p class="text-sm font-bold text-rose-800"><?= session()->getFlashdata('error') ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600 transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    <?php endif;?>

    <!-- Assignment Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5 lg:gap-6 mb-10">
        <?php if(empty($assignments)): ?>
            <div class="col-span-full bg-white rounded-2xl lg:rounded-[2rem] border border-slate-100 p-12 lg:p-16 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <p class="text-slate-400 font-bold text-sm">Belum ada pembelajaran.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($assignments as $a): ?>
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md hover:border-slate-200 transition-all duration-300 group flex flex-col">
                <div class="p-4 sm:p-5 flex-1">
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex px-2.5 py-1 rounded-xl text-[9px] font-black bg-indigo-50 text-indigo-700 uppercase tracking-wider border border-indigo-100"><?= $a['subject_name'] ?></span>
                            <span class="inline-flex px-2.5 py-1 rounded-xl text-[9px] font-black bg-slate-100 text-slate-600 uppercase tracking-wider border border-slate-200"><?= $a['type'] ?? 'Tugas' ?></span>
                            <?php if(($a['pending_count'] ?? 0) > 0): ?>
                                <span class="inline-flex px-2.5 py-1 rounded-xl text-[9px] font-black bg-rose-500 text-white uppercase tracking-wider shadow-sm animate-pulse border border-rose-600">
                                    🔔 <?= $a['pending_count'] ?> PERLU DINILAI
                                </span>
                            <?php else: ?>
                                <span class="inline-flex px-2.5 py-1 rounded-xl text-[9px] font-black bg-emerald-50 text-emerald-600 uppercase tracking-wider border border-emerald-100">
                                    ✅ SELESAI
                                </span>
                            <?php endif; ?>
                        </div>
                        <span class="text-[10px] text-slate-400 font-medium flex-shrink-0"><?= date('d M Y', strtotime($a['created_at'])) ?></span>
                    </div>
                    <h3 class="text-sm sm:text-base font-black text-slate-800 tracking-tight mb-2 group-hover:text-indigo-600 transition-colors line-clamp-2"><?= $a['title'] ?></h3>
                    <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 leading-relaxed"><?= $a['description'] ?></p>

                    <div class="space-y-2 pt-4 mt-4 border-t border-slate-50">
                        <div class="flex items-center text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 mr-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Kelas: <span class="font-bold ml-1 text-slate-700"><?= $a['class_name'] ?></span>
                        </div>
                        <div class="flex items-center text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 mr-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Deadline: <span class="font-bold ml-1 text-rose-600"><?= date('d M Y, H:i', strtotime($a['deadline'])) ?></span>
                        </div>
                        <div class="flex items-center text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 mr-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Guru: <span class="font-bold ml-1 text-slate-700"><?= $a['teacher_name'] ?></span>
                        </div>
                    </div>
                </div>

                <div class="px-4 sm:px-5 pb-4 sm:pb-5 pt-0">
                    <div class="flex flex-wrap gap-1.5 sm:gap-2">
                        <?php if($a['file_path']): ?>
                        <a href="<?= base_url('assignments/download/' . $a['id']) ?>" class="inline-flex items-center justify-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-black py-2 sm:py-2.5 px-3 sm:px-4 rounded-lg sm:rounded-xl text-[9px] sm:text-[10px] uppercase tracking-wider transition-colors border border-indigo-100">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            MATERI
                        </a>
                        <?php endif; ?>

                        <a href="<?= base_url('assignments/submissions/' . $a['id']) ?>" class="inline-flex items-center justify-center bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-black py-2 sm:py-2.5 px-3 sm:px-4 rounded-lg sm:rounded-xl text-[9px] sm:text-[10px] uppercase tracking-wider transition-colors border border-emerald-100">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            INPUT NILAI
                        </a>

                        <a href="<?= base_url('assignments/report/' . $a['id']) ?>" class="inline-flex items-center justify-center bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-black py-2 sm:py-2.5 px-3 sm:px-4 rounded-lg sm:rounded-xl text-[9px] sm:text-[10px] uppercase tracking-wider transition-colors border border-emerald-100">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> 
                            REKAP
                        </a>

                        <?php if((session()->get('role') == 'guru' && $currentTeacherId == $a['teacher_id']) || session()->get('role') == 'admin'): ?>
                        <div class="flex gap-1.5 sm:gap-2 ml-auto">
                            <a href="<?= base_url('assignments/edit/' . $a['id']) ?>" class="p-2 sm:p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-md rounded-lg sm:rounded-xl transition-all duration-300 border border-slate-100" title="Edit">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                            <form action="<?= base_url('assignments/delete/' . $a['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Hapus pembelajaran ini?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-2 sm:p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-rose-600 hover:shadow-md rounded-lg sm:rounded-xl transition-all duration-300 border border-slate-100" title="Hapus">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="mb-12">
        <?= $pager->links('assignments', 'tailwind_pager') ?>
    </div>
<?= $this->endSection() ?>
