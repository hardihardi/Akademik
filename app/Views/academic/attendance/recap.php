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
                        <a href="<?= base_url('attendance-recap') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase">REKAP UTAMA</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 tracking-widest">MATRIKS BULANAN</span>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-800 tracking-tight leading-none uppercase">Matriks Kehadiran <?= $class['name'] ?></h1>
            <p class="text-slate-500 font-bold mt-3 tracking-normal normal-case">Periode: <span class="text-indigo-600 font-black"><?= date('F Y', mktime(0, 0, 0, $month, 10, $year)) ?></span></p>
        </div>
        <div class="flex flex-col sm:flex-row gap-4 no-print flex-shrink-0">
            <a href="<?= base_url('attendance-recap') ?>" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-white text-slate-600 font-black text-xs border border-slate-200 hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-100 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-3 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                KEMBALI
            </a>
            <button onclick="window.print()" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-indigo-600 text-white font-black text-xs shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-1 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-3 transition-transform group-hover:scale-125" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                CETAK MATRIKS
            </button>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-3xl border border-slate-100 p-6 sm:p-8 mb-8 no-print animate-in fade-in slide-in-from-top-4 duration-500">
        <form action="<?= base_url('attendance/recap/' . $class['id']) ?>" method="get" class="flex flex-col sm:flex-row gap-4 sm:items-end">
            <div class="flex-1 min-w-0">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Bulan Terpilih</label>
                <div class="relative group">
                    <select name="month" class="w-full pl-6 pr-12 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl font-black text-slate-700 appearance-none focus:outline-none focus:border-indigo-500 focus:bg-white transition-all duration-300 capitalize text-xs sm:text-sm">
                        <?php for($m=1; $m<=12; $m++): ?>
                            <option value="<?= $m ?>" <?= $m == $month ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $m, 10)) ?></option>
                        <?php endfor; ?>
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300 group-hover:text-indigo-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Tahun</label>
                <div class="relative group">
                    <select name="year" class="w-full pl-6 pr-12 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl font-black text-slate-700 appearance-none focus:outline-none focus:border-indigo-500 focus:bg-white transition-all duration-300 text-xs sm:text-sm">
                        <?php for($y=date('Y')-2; $y<=date('Y')+1; $y++): ?>
                            <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300 group-hover:text-indigo-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>
            <button type="submit" class="w-full sm:w-auto h-[58px] bg-slate-800 hover:bg-indigo-600 text-white font-black px-10 rounded-2xl shadow-xl shadow-slate-900/10 hover:shadow-indigo-900/20 active:scale-95 transition-all duration-300 text-[10px] tracking-widest uppercase">
                FILTER REKAP
            </button>
        </form>
    </div>

    <div class="bg-white shadow-sm rounded-3xl border border-slate-100 overflow-hidden mb-12 animate-in fade-in slide-in-from-bottom-6 duration-700">
        <!-- Scroll Indicator (Mobile Only) -->
        <div class="sm:hidden flex items-center justify-center p-3 bg-indigo-50/50 border-b border-indigo-100 gap-2">
            <svg class="w-4 h-4 text-indigo-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest">Geser ke samping untuk melihat data</span>
        </div>

        <div class="overflow-x-auto scrollbar-hide">
            <table class="w-full text-left border-collapse text-[10px] sm:text-[11px] font-bold">
                <thead class="bg-indigo-600 sm:bg-slate-50 sticky top-0 z-30 shadow-sm sm:shadow-none">
                    <tr>
                        <th class="p-4 sm:p-6 font-black text-white sm:text-slate-400 uppercase tracking-widest border-b border-indigo-500 sm:border-slate-100 sticky left-0 bg-indigo-600 sm:bg-white z-40 min-w-[140px] sm:w-64 shadow-[4px_0_10px_rgba(0,0,0,0.1)] sm:shadow-[4px_0_10px_rgba(0,0,0,0.03)] selection-none">Nama Siswa</th>
                        <?php for($d=1; $d<=$daysInMonth; $d++): ?>
                            <th class="p-1 sm:p-2 text-center text-[9px] sm:text-[10px] font-black text-indigo-100 sm:text-slate-300 border-b border-indigo-500 sm:border-slate-100 min-w-[28px] sm:min-w-[32px]"><?= str_pad($d, 2, '0', STR_PAD_LEFT) ?></th>
                        <?php endfor; ?>
                        <th class="p-2 sm:p-4 text-center text-white sm:text-emerald-500 border-b border-indigo-500 sm:border-slate-100 border-l border-indigo-500/30 sm:border-slate-100 bg-indigo-600 sm:bg-slate-50/50 sticky right-24 sm:static z-30 font-black">H</th>
                        <th class="p-2 sm:p-4 text-center text-white sm:text-sky-500 border-b border-indigo-500 sm:border-slate-100 bg-indigo-600 sm:bg-slate-50/50 sticky right-16 sm:static z-30 font-black">S</th>
                        <th class="p-2 sm:p-4 text-center text-white sm:text-sky-500 border-b border-indigo-500 sm:border-slate-100 bg-indigo-600 sm:bg-slate-50/50 sticky right-8 sm:static z-30 font-black">I</th>
                        <th class="p-2 sm:p-4 text-center text-white sm:text-rose-500 border-b border-indigo-500 sm:border-slate-100 bg-indigo-600 sm:bg-slate-50/50 sticky right-0 sm:static z-30 font-black">A</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach($students as $student): ?>
                    <tr class="group hover:bg-slate-50/30 transition-all duration-300">
                        <td class="p-3 sm:p-4 border-r border-slate-50 sticky left-0 bg-white z-20 group-hover:bg-slate-50 transition-colors shadow-[4px_0_10px_rgba(0,0,0,0.03)]">
                            <span class="text-slate-700 group-hover:text-indigo-600 transition-colors block truncate w-32 sm:w-56 uppercase tracking-tight"><?= $student['full_name'] ?></span>
                        </td>
                        <?php for($d=1; $d<=$daysInMonth; $d++): ?>
                            <td class="p-0.5 sm:p-1 text-center border-r border-slate-50/50">
                                <?php 
                                    $status = $attendanceMatrix[$student['id']][$d] ?? '-';
                                    $bgClass = ''; $textClass = 'text-slate-200 opacity-50';
                                    switch($status) {
                                        case 'H': $bgClass = 'bg-emerald-500 text-white shadow-emerald-100'; $textClass = ''; break;
                                        case 'S': $bgClass = 'bg-sky-500 text-white shadow-sky-100'; $textClass = ''; break;
                                        case 'I': $bgClass = 'bg-sky-500 text-white shadow-sky-100'; $textClass = ''; break;
                                        case 'A': $bgClass = 'bg-rose-500 text-white shadow-rose-100'; $textClass = ''; break;
                                    }
                                    if ($status != '-') {
                                        echo "<span class='w-5 h-5 sm:w-6 sm:h-6 inline-flex items-center justify-center rounded-md sm:rounded-lg $bgClass $textClass font-black shadow-sm text-[8px] sm:text-[10px] transform transition-transform group-hover:scale-110'>$status</span>";
                                    } else {
                                        echo "<span class='text-slate-200'>•</span>";
                                    }
                                ?>
                            </td>
                        <?php endfor; ?>
                        <td class="p-2 sm:p-4 text-center font-black bg-emerald-50 text-emerald-600 border-l border-slate-100 sticky right-24 sm:static z-10 shadow-[-4px_0_10px_rgba(0,0,0,0.02)] sm:shadow-none"><?= $summary[$student['id']]['H'] ?></td>
                        <td class="p-2 sm:p-4 text-center font-black bg-sky-50 text-sky-600 sticky right-16 sm:static z-10 shadow-[-4px_0_10px_rgba(0,0,0,0.02)] sm:shadow-none"><?= $summary[$student['id']]['S'] ?></td>
                        <td class="p-2 sm:p-4 text-center font-black bg-sky-50 text-sky-600 sticky right-8 sm:static z-10 shadow-[-4px_0_10px_rgba(0,0,0,0.02)] sm:shadow-none"><?= $summary[$student['id']]['I'] ?></td>
                        <td class="p-2 sm:p-4 text-center font-black bg-rose-50 text-rose-600 sticky right-0 sm:static z-10 shadow-[-4px_0_10px_rgba(0,0,0,0.02)] sm:shadow-none"><?= $summary[$student['id']]['A'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-8 flex flex-wrap gap-6 text-[10px] font-black tracking-widest uppercase text-slate-400 no-print">
        <div class="flex items-center gap-2"><span class="w-6 h-6 rounded-lg bg-emerald-50 border border-slate-100 text-emerald-500 flex items-center justify-center">H</span> HADIR</div>
        <div class="flex items-center gap-2"><span class="w-6 h-6 rounded-lg bg-sky-50 border border-slate-100 text-sky-500 flex items-center justify-center">S</span> SAKIT</div>
        <div class="flex items-center gap-2"><span class="w-6 h-6 rounded-lg bg-sky-50 border border-slate-100 text-sky-500 flex items-center justify-center">I</span> IZIN</div>
        <div class="flex items-center gap-2"><span class="w-6 h-6 rounded-lg bg-rose-50 border border-slate-100 text-rose-500 flex items-center justify-center">A</span> ALPHA</div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .container { width: 100% !important; max-width: none !important; padding: 0 !important; }
        .shadow-sm { shadow: none !important; }
        .rounded-[2rem], .rounded-[2.5rem] { border-radius: 0 !important; }
        .bg-white { background: transparent !important; }
        .sticky { position: static !important; }
    }
</style>
<?= $this->endSection() ?>
