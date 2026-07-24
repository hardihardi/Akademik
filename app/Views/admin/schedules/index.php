<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-8">
        <div>
            <div class="flex items-center gap-2 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 lg:mb-4">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600">JADWAL PELAJARAN</span>
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight"><?= $title ?></h1>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Kelola jadwal pelajaran per kelas dan tahun akademik.</p>
        </div>
        <div>
            <a href="<?= base_url('schedules/create') ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-indigo-600 text-white font-black text-[10px] lg:text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-0.5 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 lg:mr-3 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                TAMBAH JADWAL
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl lg:rounded-[2rem] shadow-sm border border-slate-100 p-4 sm:p-6 mb-6">
        <form method="get" action="<?= base_url('schedules') ?>" class="flex flex-col sm:flex-row gap-3 sm:gap-4 items-end">
            <div class="flex-1 w-full">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kelas</label>
                <select name="class_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-sm font-medium text-slate-800">
                    <option value="">Semua Kelas</option>
                    <?php foreach($classes as $class): ?>
                        <option value="<?= $class['id'] ?>" <?= $selectedClass == $class['id'] ? 'selected' : '' ?>><?= $class['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex-1 w-full">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tahun Akademik</label>
                <select name="academic_year_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-sm font-medium text-slate-800">
                    <option value="">Semua Tahun</option>
                    <?php foreach($academicYears as $year): ?>
                        <option value="<?= $year['id'] ?>" <?= $selectedYear == $year['id'] ? 'selected' : '' ?>><?= $year['year'] ?> - <?= $year['semester'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-black text-xs tracking-wider transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                FILTER
            </button>
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

    <!-- Timetable Grid View (Desktop) -->
    <?php if($selectedClass): ?>
    <div class="hidden md:block bg-white rounded-2xl lg:rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mb-8">
        <div class="p-5 lg:p-6 border-b border-slate-100 bg-slate-50/30">
            <h2 class="font-black text-slate-800 flex items-center text-sm tracking-tight">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Tampilan Roster
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-24">Hari</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Jam</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Mata Pelajaran</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Guru</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Ruang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach($days as $day): ?>
                        <?php $daySchedules = $groupedSchedules[$day]; ?>
                        <?php if(empty($daySchedules)): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-5 lg:p-6">
                                    <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black bg-slate-100 text-slate-600 uppercase tracking-wider"><?= $day ?></span>
                                </td>
                                <td colspan="4" class="p-5 lg:p-6 text-slate-400 text-sm">Tidak ada jadwal</td>
                            </tr>
                        <?php else: ?>
                            <?php $first = true; foreach($daySchedules as $s): ?>
                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                <td class="p-5 lg:p-6">
                                    <?php if($first): ?>
                                        <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black bg-indigo-50 text-indigo-700 uppercase tracking-wider border border-indigo-100"><?= $day ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-5 lg:p-6">
                                    <span class="font-mono font-black text-sm text-slate-700"><?= substr($s['start_time'], 0, 5) ?> - <?= substr($s['end_time'], 0, 5) ?></span>
                                </td>
                                <td class="p-5 lg:p-6 font-black text-slate-800 group-hover:text-indigo-600 transition-colors"><?= $s['subject_name'] ?></td>
                                <td class="p-5 lg:p-6 text-sm text-slate-600"><?= $s['teacher_name'] ?></td>
                                <td class="p-5 lg:p-6 text-sm text-slate-400"><?= $s['room'] ?: '-' ?></td>
                            </tr>
                            <?php $first = false; endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Timetable Mobile View -->
    <div class="md:hidden space-y-3 mb-8">
        <?php foreach($days as $day): ?>
            <?php $daySchedules = $groupedSchedules[$day]; ?>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-4 py-3 bg-indigo-50/50 border-b border-slate-100">
                    <span class="text-xs font-black text-indigo-700 uppercase tracking-widest"><?= $day ?></span>
                </div>
                <?php if(empty($daySchedules)): ?>
                    <div class="p-4 text-sm text-slate-400">Tidak ada jadwal</div>
                <?php else: ?>
                    <div class="divide-y divide-slate-50">
                        <?php foreach($daySchedules as $s): ?>
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-black text-sm text-slate-800"><?= $s['subject_name'] ?></span>
                                <span class="font-mono text-xs font-bold text-indigo-600"><?= substr($s['start_time'], 0, 5) ?>-<?= substr($s['end_time'], 0, 5) ?></span>
                            </div>
                            <p class="text-xs text-slate-500"><?= $s['teacher_name'] ?> <?= $s['room'] ? '· ' . $s['room'] : '' ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Full List — Desktop Table -->
    <div class="hidden md:block bg-white rounded-2xl lg:rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mb-10">
        <div class="p-5 lg:p-6 border-b border-slate-100">
            <h2 class="font-black text-slate-800 text-sm tracking-tight">Daftar Semua Jadwal</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-12">No</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Hari</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Jam</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Kelas</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Mapel</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Guru</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(empty($schedules)): ?>
                        <tr>
                            <td colspan="7" class="p-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-slate-400 font-bold text-sm">Belum ada jadwal.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach($schedules as $s): ?>
                        <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                            <td class="p-5 lg:p-6 text-sm text-slate-400"><?= $i++ ?></td>
                            <td class="p-5 lg:p-6">
                                <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black bg-indigo-50 text-indigo-700 uppercase tracking-wider border border-indigo-100"><?= $s['day'] ?></span>
                            </td>
                            <td class="p-5 lg:p-6">
                                <span class="font-mono font-bold text-sm text-slate-700"><?= substr($s['start_time'], 0, 5) ?> - <?= substr($s['end_time'], 0, 5) ?></span>
                            </td>
                            <td class="p-5 lg:p-6 font-black text-slate-800"><?= $s['class_name'] ?></td>
                            <td class="p-5 lg:p-6 text-sm text-slate-600"><?= $s['subject_name'] ?></td>
                            <td class="p-5 lg:p-6 text-sm text-slate-500"><?= $s['teacher_name'] ?></td>
                            <td class="p-5 lg:p-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('schedules/edit/' . $s['id']) ?>" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-md rounded-xl transition-all duration-300" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="<?= base_url('schedules/delete/' . $s['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Yakin hapus jadwal ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-rose-600 hover:shadow-md rounded-xl transition-all duration-300" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Full List — Mobile Cards -->
    <div class="md:hidden space-y-3 mb-10">
        <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Daftar Semua Jadwal</h2>
        <?php if(empty($schedules)): ?>
            <div class="bg-white rounded-2xl border border-slate-100 p-8 text-center">
                <p class="text-slate-400 font-bold text-sm">Belum ada jadwal.</p>
            </div>
        <?php else: ?>
            <?php foreach($schedules as $s): ?>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="font-black text-slate-800 tracking-tight text-sm"><?= $s['subject_name'] ?></p>
                        <div class="flex flex-wrap items-center gap-1.5 mt-1.5">
                            <span class="inline-flex px-2 py-0.5 rounded-lg text-[9px] font-black bg-indigo-50 text-indigo-600"><?= $s['day'] ?></span>
                            <span class="font-mono text-[10px] font-bold text-slate-500"><?= substr($s['start_time'], 0, 5) ?>-<?= substr($s['end_time'], 0, 5) ?></span>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1"><?= $s['class_name'] ?> · <?= $s['teacher_name'] ?></p>
                    </div>
                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        <a href="<?= base_url('schedules/edit/' . $s['id']) ?>" class="p-2 bg-slate-50 text-slate-400 hover:text-indigo-600 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form action="<?= base_url('schedules/delete/' . $s['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Yakin hapus?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="p-2 bg-slate-50 text-slate-400 hover:text-rose-600 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination Container -->
    <div class="mb-12 overflow-x-auto py-2">
        <?= $pager->links('default', 'tailwind_pager') ?>
    </div>

<?= $this->endSection() ?>
