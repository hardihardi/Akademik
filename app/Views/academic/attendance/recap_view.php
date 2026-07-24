<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="mb-12 flex flex-col md:flex-row md:items-end md:justify-between gap-6 uppercase tracking-[0.2em]">
        <div>
            <nav class="flex mb-4 text-[10px] font-black uppercase tracking-[0.2em]" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="<?= base_url('attendance-recap') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase font-black uppercase">REKAP UTAMA</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 tracking-widest">DETAIL KELAS</span>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-800 tracking-tight leading-none uppercase">Ringkasan Kehadiran</h1>
            <p class="text-slate-500 font-bold mt-3 tracking-normal normal-case">Kelas: <span class="text-slate-800 font-black uppercase"><?= $class['name'] ?></span> | Tahun Ajaran: <span class="text-indigo-600 font-black"><?= $year['year'] ?> (<?= ($year['semester'] == 1) ? 'Ganjil' : 'Genap' ?>)</span></p>
        </div>
        <div class="flex flex-wrap items-center gap-3 sm:gap-4 w-full md:w-auto">
            <a href="<?= base_url('attendance-recap') ?>" class="inline-flex items-center justify-center px-4 py-3.5 sm:px-6 rounded-2xl bg-slate-100 text-slate-600 font-black text-[10px] sm:text-xs shadow-sm hover:bg-slate-200 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                KEMBALI
            </a>
            <a href="<?= base_url('attendance-recap/pdf/' . $class['id']) ?>" class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3.5 rounded-2xl bg-indigo-600 text-white font-black text-[10px] sm:text-xs shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                PDF
            </a>
            <a href="<?= base_url('attendance/recap/' . $class['id']) ?>" class="hidden sm:inline-flex items-center justify-center px-6 py-3.5 rounded-2xl bg-white text-indigo-600 font-black text-xs border-2 border-indigo-100 shadow-sm hover:shadow-indigo-50 hover:border-indigo-200 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                VIEW MONTHLY
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12 font-black">
        <div class="p-8 bg-white rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-emerald-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <p class="text-[10px] text-slate-400 mb-2 uppercase tracking-[0.2em]">TOTAL HADIR</p>
            <p class="text-4xl text-emerald-600 tracking-tighter"><?= $totalClassH ?></p>
        </div>
        <div class="p-8 bg-white rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-sky-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <p class="text-[10px] text-slate-400 mb-2 uppercase tracking-[0.2em]">TOTAL SAKIT</p>
            <p class="text-4xl text-sky-500 tracking-tighter"><?= $totalClassS ?></p>
        </div>
        <div class="p-8 bg-white rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-sky-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <p class="text-[10px] text-slate-400 mb-2 uppercase tracking-[0.2em]">TOTAL IZIN</p>
            <p class="text-4xl text-sky-500 tracking-tighter"><?= $totalClassI ?></p>
        </div>
        <div class="p-8 bg-white rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-rose-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <p class="text-[10px] text-slate-400 mb-2 uppercase tracking-[0.2em]">TOTAL ALPHA</p>
            <p class="text-4xl text-rose-500 tracking-tighter"><?= $totalClassA ?></p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden mb-12 animate-in fade-in slide-in-from-bottom-6 duration-700">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-indigo-50/50">
                        <th class="p-6 text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-100 sticky left-0 bg-indigo-50 sm:bg-transparent z-10 shadow-[2px_0_5px_rgba(0,0,0,0.02)]">Nama Siswa</th>
                        <th class="p-6 text-[10px] font-black text-emerald-500 uppercase tracking-widest border-b border-slate-100 text-center">Hadir</th>
                        <th class="p-6 text-[10px] font-black text-sky-500 uppercase tracking-widest border-b border-slate-100 text-center">Sakit</th>
                        <th class="p-6 text-[10px] font-black text-sky-500 uppercase tracking-widest border-b border-slate-100 text-center">Izin</th>
                        <th class="p-6 text-[10px] font-black text-rose-500 uppercase tracking-widest border-b border-slate-100 text-center">Alpha</th>
                        <th class="p-6 text-[10px] font-black text-slate-600 uppercase tracking-widest border-b border-slate-100 text-right">% Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(empty($students)): ?>
                        <tr>
                            <td colspan="6" class="p-20 text-center">
                                <p class="text-slate-400 font-black tracking-widest uppercase text-xs">Belum ada data siswa di kelas ini.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($students as $student): ?>
                        <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                            <td class="p-6 sticky left-0 bg-white z-10 group-hover:bg-slate-50 transition-colors shadow-[2px_0_5px_rgba(0,0,0,0.02)]">
                                <p class="text-slate-800 font-black tracking-tight group-hover:text-indigo-600 transition-colors uppercase text-sm truncate max-w-[200px]"><?= $student['full_name'] ?></p>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest leading-none mt-1">NIS: <?= $student['nis'] ?: ($student['nisn'] ?: '-') ?></p>
                            </td>
                            <td class="p-6 text-center">
                                <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-xl font-black text-xs"><?= $attendanceStats[$student['id']]['summary']['H'] ?></span>
                            </td>
                            <td class="p-6 text-center font-bold text-slate-600"><?= $attendanceStats[$student['id']]['summary']['S'] ?></td>
                            <td class="p-6 text-center font-bold text-slate-600"><?= $attendanceStats[$student['id']]['summary']['I'] ?></td>
                            <td class="p-6 text-center font-bold text-rose-500"><?= $attendanceStats[$student['id']]['summary']['A'] ?></td>
                            <td class="p-6 text-right font-black">
                                <div class="flex items-center justify-end gap-3">
                                    <div class="w-24 h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-indigo-600 rounded-full" style="width: <?= $attendanceStats[$student['id']]['percentage'] ?>%"></div>
                                    </div>
                                    <span class="text-indigo-600 text-sm font-black"><?= $attendanceStats[$student['id']]['percentage'] ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .container { width: 100% !important; max-width: none !important; padding: 0 !important; }
        .shadow-sm, .shadow-xl { shadow: none !important; }
        .rounded-[2rem], .rounded-[2.5rem] { border-radius: 0 !important; }
        .bg-white { background: transparent !important; }
        .bg-indigo-600 { background: #4f46e5 !important; -webkit-print-color-adjust: exact; }
    }
</style>
<?= $this->endSection() ?>
