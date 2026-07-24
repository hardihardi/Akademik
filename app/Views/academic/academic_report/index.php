<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <style>
        @media print {
            @page { size: landscape; margin: 15mm; }
            .no-print, header, aside, nav, .filter-container { display: none !important; }
            body { background: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .container { width: 100%; max-width: none; padding: 0; }
            .print-header { display: block !important; }
            .shadow-xl, .shadow-sm { box-shadow: none !important; }
            .rounded-2xl, .rounded-[2.5rem] { border-radius: 0 !important; }
            .border { border-color: #000 !important; }
        }
    </style>

    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-8 no-print animate-in fade-in slide-in-from-top-4 duration-700">
        <div>
            <div class="flex items-center gap-2 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 lg:mb-4">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase">LAPORAN AKADEMIK</span>
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase"><?= $title ?></h1>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Laporan keseluruhan nilai akademik siswa per kelas dan mata pelajaran.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()" class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-white border border-slate-200 text-slate-700 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-slate-50 hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                CETAK
            </button>
            <button class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-indigo-600 text-white font-black text-[10px] lg:text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                UNDUH
            </button>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl lg:rounded-[2rem] shadow-sm border border-slate-100 p-4 sm:p-6 mb-6 no-print filter-container">
        <form method="get" action="<?= base_url('academic-report') ?>" id="filterForm" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Kelas</label>
                <select name="class_id" id="class_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 text-sm appearance-none" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua Kelas</option>
                    <?php foreach($classes as $cls): ?>
                        <option value="<?= $cls['id'] ?>" <?= ($selectedClassId == $cls['id']) ? 'selected' : '' ?>><?= $cls['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Periode</label>
                <select name="semester" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 text-sm appearance-none" onchange="document.getElementById('filterForm').submit()">
                    <option value="1" <?= ($selectedSemester == '1') ? 'selected' : '' ?>>SEMESTER GANJIL</option>
                    <option value="2" <?= ($selectedSemester == '2') ? 'selected' : '' ?>>SEMESTER GENAP</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Mata Pelajaran</label>
                <select name="subject_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 text-sm appearance-none" onchange="document.getElementById('filterForm').submit()">
                    <option value="">SEMUA MAPEL</option>
                    <?php foreach($subjects as $subj): ?>
                        <option value="<?= $subj['id'] ?>" <?= ($selectedSubjectId == $subj['id']) ? 'selected' : '' ?>><?= $subj['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="w-full px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-black rounded-xl text-xs tracking-widest transition-all">
                TAMPILKAN
            </button>
        </form>
    </div>

    <!-- Print Header (Visible only when printing) -->
    <div class="print-header hidden mb-10 text-center">
        <?php $brand = school_branding(); ?>
        <div class="flex items-center justify-center gap-6 mb-6">
            <?php if($brand['logo']): ?>
                <img src="<?= base_url($brand['logo']) ?>" class="h-20 w-auto" alt="Logo">
            <?php endif; ?>
            <div class="text-left">
                <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight"><?= $brand['name'] ?></h2>
                <p class="text-sm font-medium text-slate-600"><?= $brand['address'] ?></p>
            </div>
        </div>
        <div class="h-1 bg-slate-900 mb-6"></div>
        <h3 class="text-xl font-black text-slate-900 uppercase tracking-widest mb-2">REKAPITULASI LAPORAN AKADEMIK</h3>
        <?php if($selectedClass): ?>
            <p class="text-sm font-bold text-slate-600 uppercase tracking-widest">
                KELAS: <?= $selectedClass['name'] ?> | SEMESTER: <?= $selectedSemester == '1' ? 'GANJIL' : 'GENAP' ?> | TA: <?= $activeYear['year'] ?? date('Y') ?>
            </p>
        <?php endif; ?>
    </div>

    <?php if($selectedClassId && !empty($reportData)): ?>
        <!-- Info Badges -->
        <div class="flex flex-wrap items-center gap-2 mb-6 no-print">
            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-lg border border-indigo-100 uppercase tracking-widest tracking-tighter">KELAS <?= $selectedClass['name'] ?></span>
            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-black rounded-lg border border-emerald-100 uppercase tracking-widest tracking-tighter"><?= count($reportData) ?> SISWA</span>
            <span class="px-3 py-1 bg-amber-50 text-amber-700 text-[10px] font-black rounded-lg border border-amber-100 uppercase tracking-widest tracking-tighter"><?= count($displaySubjects) ?> MAPEL</span>
        </div>

        <!-- Desktop Table -->
        <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="p-4 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-16">NO</th>
                            <th class="p-4 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">NIS / NAMA SISWA</th>
                            <?php foreach($displaySubjects as $subj): ?>
                                <th class="p-4 lg:p-6 text-[10px] font-black text-center text-slate-400 uppercase tracking-widest border-b border-slate-100 min-w-[100px]">
                                    <?= $subj['name'] ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php $no = 1; foreach($reportData as $row): ?>
                        <tr class="group hover:bg-slate-50/30 transition-all duration-300">
                            <td class="p-4 lg:p-6 text-xs font-bold text-slate-400"><?= $no++ ?></td>
                            <td class="p-4 lg:p-6">
                                <div class="flex items-center gap-3 lg:gap-4">
                                    <?php if(!empty($row['photo'])): ?>
                                        <div class="w-8 lg:w-10 h-8 lg:h-10 rounded-xl overflow-hidden border-2 border-slate-100 flex-shrink-0 group-hover:border-indigo-200 transition-colors">
                                            <img src="<?= base_url($row['photo'] ?: 'assets/images/placeholder.png') ?>" alt="" class="w-full h-full object-cover">
                                        </div>
                                    <?php else: ?>
                                        <div class="w-8 lg:w-10 h-8 lg:h-10 rounded-xl bg-slate-50 flex items-center justify-center font-black text-slate-400 text-xs border border-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-400 transition-colors uppercase">
                                            <?= substr($row['full_name'], 0, 1) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="min-w-0">
                                        <p class="text-xs font-black text-slate-800 tracking-tight leading-none mb-1 uppercase group-hover:text-indigo-600 transition-colors truncate"><?= $row['full_name'] ?></p>
                                        <p class="text-[9px] font-mono font-bold text-slate-400 tracking-tighter uppercase"><?= $row['nis'] ?></p>
                                    </div>
                                </div>
                            </td>
                            <?php foreach($displaySubjects as $subj): ?>
                                <td class="p-4 lg:p-6 text-center">
                                    <?php
                                        $score = $row['scores'][$subj['id']] ?? 0;
                                        if ($score == 0) {
                                            echo '<span class="text-slate-200 font-mono font-black">—</span>';
                                        } else {
                                            $color = 'text-slate-700';
                                            $bg = 'bg-slate-50';
                                            if ($score < 70) { $color = 'text-rose-600'; $bg = 'bg-rose-50'; }
                                            elseif ($score >= 90) { $color = 'text-emerald-600'; $bg = 'bg-emerald-50'; }
                                            
                                            echo '<span class="inline-flex items-center justify-center w-10 h-7 rounded-lg '.$bg.' '.$color.' font-mono font-black text-xs">'.$score.'</span>';
                                        }
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 text-[9px] font-black text-slate-400 uppercase tracking-widest no-print">
                MENAMPILKAN <?= count($reportData) ?> DATA SISWA &bull; SELLING <?= $selectedSemester == '1' ? 'GANJIL' : 'GENAP' ?> &bull; TA <?= $activeYear['year'] ?? date('Y') ?>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4 mb-12 no-print">
            <?php foreach($reportData as $row): ?>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center font-black text-slate-400 text-xs border border-slate-100 uppercase">
                        <?= substr($row['full_name'], 0, 1) ?>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-800 uppercase tracking-tight mb-0.5"><?= $row['full_name'] ?></p>
                        <p class="text-[9px] font-mono text-slate-400 uppercase tracking-tighter"><?= $row['nis'] ?></p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <?php foreach($displaySubjects as $subj): ?>
                        <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                            <span class="text-[8px] font-black text-slate-400 uppercase truncate pr-2"><?= $subj['name'] ?></span>
                            <span class="font-mono text-[10px] font-black text-slate-800 tracking-tighter leading-none">
                                <?= $row['scores'][$subj['id']] ?? '—' ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    <?php elseif($selectedClassId && empty($reportData)): ?>
        <div class="bg-white rounded-[2rem] border border-slate-100 p-20 text-center animate-in zoom-in-95 duration-500">
            <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-300 mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight mb-2">TIDAK ADA DATA</h3>
            <p class="text-slate-400 text-sm font-bold">Belum ada nilai yang tercatat untuk filter ini.</p>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-[2rem] border border-slate-100 p-20 text-center animate-in zoom-in-95 duration-500">
            <div class="w-20 h-20 bg-indigo-50 rounded-[2.5rem] flex items-center justify-center text-indigo-400 mx-auto mb-6">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-widest mb-2">PILIH KELAS TERLEBIH DAHULU</h3>
            <p class="text-slate-400 text-sm max-w-md mx-auto font-bold">Gunakan filter di atas untuk menampilkan rekapitulasi laporan akademik berdasarkan kelas dan periode.</p>
        </div>
    <?php endif; ?>

<?= $this->endSection() ?>
