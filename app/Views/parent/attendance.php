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
                        <span class="text-indigo-600">Kehadiran</span>
                    </li>
                </ol>
            </nav>
            <h3 class="text-slate-800 text-3xl md:text-4xl font-black tracking-tight leading-tight">Riwayat Absensi</h3>
            <p class="text-slate-500 mt-2 font-medium text-sm md:text-base">
                Memantau kedisiplinan harian <span class="text-slate-800 font-bold"><?= $student['full_name'] ?></span>
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-4">
            <!-- Class Info Badge -->
            <div class="w-full sm:w-auto bg-white px-5 py-3 rounded-2xl border border-slate-100 flex items-center shadow-sm">
                <div class="p-2 bg-indigo-600 rounded-xl text-white mr-3 shadow-lg shadow-indigo-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" /></svg>
                </div>
                <div class="text-left">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kelas Aktif</span>
                    <span class="text-base font-black text-slate-800"><?= $student['class_name'] ?></span>
                </div>
            </div>

            <?php if (isset($activeYear)): ?>
            <div class="w-full sm:w-auto bg-emerald-50 px-5 py-3 rounded-2xl border border-emerald-100 flex items-center shadow-sm">
                <div class="p-2 bg-emerald-600 rounded-xl text-white mr-3 shadow-lg shadow-emerald-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <div class="text-left">
                    <span class="block text-[10px] font-bold text-emerald-400 uppercase tracking-widest">Tahun Akademik</span>
                    <span class="text-base font-black text-emerald-800"><?= $activeYear['year'] ?> - <?= $activeYear['semester'] ?></span>
                </div>
            </div>
            <?php endif; ?>

            <!-- Action Button -->
            <a href="<?= base_url('parent/attendance/permission') ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl shadow-xl shadow-indigo-100 transition-all duration-300 hover:-translate-y-1 active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                <span class="font-bold text-sm tracking-tight uppercase">Ajukan Izin</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards: 2 Columns on Mobile, 4 on Desktop -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
        <!-- Hadir -->
        <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 border border-emerald-100">
                <span class="font-black text-lg">H</span>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Hadir</p>
            <p class="text-2xl md:text-3xl font-black text-slate-800"><?= $summary['H'] ?></p>
        </div>
        <!-- Izin/Sakit -->
        <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4 border border-amber-100">
                <span class="font-black text-lg">I/S</span>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Izin/Sakit</p>
            <p class="text-2xl md:text-3xl font-black text-slate-800"><?= $summary['I'] + $summary['S'] ?></p>
        </div>
        <!-- Alpa -->
        <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mb-4 border border-rose-100">
                <span class="font-black text-lg">A</span>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Alpa</p>
            <p class="text-2xl md:text-3xl font-black text-slate-800"><?= $summary['A'] ?></p>
        </div>
        <!-- Total -->
        <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4 border border-indigo-100">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Hari</p>
            <p class="text-2xl md:text-3xl font-black text-slate-800"><?= $summary['total'] ?></p>
        </div>
    </div>

    <!-- Attendance History -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
            <h4 class="font-black text-slate-800 tracking-tight">Timeline Log Absensi</h4>
            <span class="hidden sm:inline text-[10px] font-bold text-slate-400 uppercase tracking-widest">Terakhir Diperbarui: <?= date('d/m/Y') ?></span>
        </div>

        <!-- Desktop View: Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50/50 text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em]">
                    <tr>
                        <th class="py-5 px-8 whitespace-nowrap">Hari & Tanggal</th>
                        <th class="py-5 px-8 whitespace-nowrap">Status</th>
                        <th class="py-5 px-8 text-right whitespace-nowrap">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(!empty($attendance)): ?>
                        <?php foreach($attendance as $att): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="py-5 px-8">
                                <div class="font-bold text-slate-700 group-hover:text-indigo-600 transition-colors tracking-tight">
                                    <?= date('l, d M Y', strtotime($att['date'])) ?>
                                </div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Semester <?= $activeYear['semester'] ?></div>
                            </td>
                            <td class="py-5 px-8">
                                <?php 
                                    $statusClasses = [
                                        'H' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'I' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'S' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        'A' => 'bg-rose-50 text-rose-700 border-rose-100',
                                    ];
                                    $statusLabels = ['H' => 'Hadir', 'I' => 'Izin', 'S' => 'Sakit', 'A' => 'Alpa'];
                                    $class = $statusClasses[$att['status']] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                                    $label = $statusLabels[$att['status']] ?? 'N/A';
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border <?= $class ?>">
                                    <?= $label ?>
                                </span>
                            </td>
                            <td class="py-5 px-8 text-right">
                                <div class="flex flex-col items-end gap-1.5">
                                    <span class="text-xs font-medium text-slate-500">
                                        <?= $att['note'] ?: 'Tidak ada catatan' ?>
                                    </span>
                                    <?php if($att['evidence_path']): ?>
                                        <div class="flex items-center gap-2">
                                            <a href="<?= base_url('uploads/attendance/' . $att['evidence_path']) ?>" target="_blank" class="text-[9px] font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded border border-indigo-100 hover:bg-indigo-600 hover:text-white transition-all">
                                                Lihat Bukti
                                            </a>
                                            <span class="<?= $att['is_verified'] ? 'text-emerald-600 bg-emerald-50' : 'text-amber-600 bg-amber-50' ?> text-[9px] font-bold px-2 py-1 rounded border">
                                                <?= $att['is_verified'] ? 'Terverifikasi' : 'Menunggu' ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile View: Card List -->
        <div class="block md:hidden divide-y divide-slate-100">
            <?php if(!empty($attendance)): ?>
                <?php foreach($attendance as $att): ?>
                <div class="p-5 flex flex-col gap-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-black text-slate-800 tracking-tight text-sm">
                                <?= date('d M Y', strtotime($att['date'])) ?>
                            </div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><?= date('l', strtotime($att['date'])) ?></div>
                        </div>
                        <?php 
                            $mLabel = ['H' => 'Hadir', 'I' => 'Izin', 'S' => 'Sakit', 'A' => 'Alpa'];
                            $mColor = [
                                'H' => 'bg-emerald-500', 
                                'I' => 'bg-amber-500', 
                                'S' => 'bg-blue-500', 
                                'A' => 'bg-rose-500'
                            ];
                        ?>
                        <span class="px-3 py-1 <?= $mColor[$att['status']] ?> text-white text-[10px] font-black rounded-lg uppercase tracking-widest shadow-sm">
                            <?= $mLabel[$att['status']] ?>
                        </span>
                    </div>
                    
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            <?= $att['note'] ?: 'Tanpa keterangan tambahan' ?>
                        </p>
                    </div>

                    <?php if($att['evidence_path']): ?>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-50">
                            <a href="<?= base_url('uploads/attendance/' . $att['evidence_path']) ?>" target="_blank" class="text-[10px] font-black text-indigo-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Bukti Lampiran
                            </a>
                            <span class="text-[9px] font-black uppercase tracking-widest <?= $att['is_verified'] ? 'text-emerald-500' : 'text-amber-500' ?>">
                                <?= $att['is_verified'] ? 'Terverifikasi' : 'Proses Verifikasi' ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Empty State -->
        <?php if(empty($attendance)): ?>
            <div class="py-20 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-slate-400 font-bold tracking-tight">Belum ada riwayat tercatat</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        <?= $pager->links('attendance', 'tailwind_pager') ?>
    </div>
</div>
<?= $this->endSection() ?>