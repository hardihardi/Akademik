<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div class="flex items-start gap-4">
            <a href="<?= base_url('dashboard') ?>" class="mt-1 flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 hover:shadow-sm transition-all duration-300 group" title="Kembali ke Dashboard">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight leading-tight"><?= $title ?></h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Menampilkan partisipasi kehadiran siswa kelas <span class="text-indigo-600 font-bold"><?= $homeroom['name'] ?></span>.</p>
            </div>
        </div>
        
        <form action="<?= base_url('attendance-recap') ?>" method="get" class="flex items-center gap-2 bg-white p-2 rounded-2xl border border-slate-200 shadow-sm">
            <select name="month" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-slate-600">
                <?php 
                $months = [
                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                ];
                foreach($months as $m => $name): ?>
                    <option value="<?= $m ?>" <?= $selectedMonth == $m ? 'selected' : '' ?>><?= $name ?></option>
                <?php endforeach; ?>
            </select>
            <select name="year" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-slate-600">
                <?php for($y = date('Y'); $y >= date('Y')-2; $y--): ?>
                    <option value="<?= $y ?>" <?= $selectedYear == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" class="p-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    <!-- Legend -->
    <div class="flex flex-wrap gap-3 sm:gap-6 mb-8 bg-indigo-50/50 p-4 sm:p-6 rounded-3xl border border-indigo-100/50">
        <div class="flex items-center text-[10px] sm:text-xs font-black text-slate-600 uppercase tracking-widest">
            <span class="w-3 h-3 bg-emerald-500 rounded-full mr-2 shadow-sm shadow-emerald-200"></span> Hadir (H)
        </div>
        <div class="flex items-center text-[10px] sm:text-xs font-black text-slate-600 uppercase tracking-widest">
            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2 shadow-sm shadow-blue-200"></span> Izin / Sakit (I/S)
        </div>
        <div class="flex items-center text-[10px] sm:text-xs font-black text-slate-600 uppercase tracking-widest">
            <span class="w-3 h-3 bg-rose-500 rounded-full mr-2 shadow-sm shadow-rose-200"></span> Alfa (A)
        </div>
        <div class="flex items-center text-[10px] sm:text-xs font-black text-slate-400 uppercase tracking-widest opacity-60">
            <span class="w-3 h-3 bg-slate-200 rounded-full mr-2 border border-slate-300"></span> Belum Diisi
        </div>
    </div>

    <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden animate-in fade-in slide-in-from-bottom-6 duration-700">
        <!-- Scroll Indicator (Mobile Only) -->
        <div class="sm:hidden flex items-center justify-center p-3 bg-indigo-50/50 border-b border-indigo-100 gap-2">
            <svg class="w-4 h-4 text-indigo-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest">Geser ke samping untuk melihat detail</span>
        </div>

        <div class="overflow-x-auto scrollbar-hide">
            <table class="w-full border-collapse text-[10px] sm:text-[11px] font-bold">
                <thead class="bg-indigo-600 text-white font-black text-[9px] sm:text-[10px] uppercase tracking-widest text-center sticky top-0 z-30 shadow-sm sm:shadow-none">
                    <tr>
                        <th class="px-4 sm:px-6 py-5 border-r border-indigo-500 text-left sticky left-0 bg-indigo-600 z-40 shadow-[4px_0_10px_rgba(0,0,0,0.1)] min-w-[140px] sm:min-width-[200px]">Nama Siswa</th>
                        <?php for($d = 1; $d <= $daysInMonth; $d++): ?>
                            <th class="px-1 sm:px-2 py-5 border-r border-indigo-500 min-w-[28px] sm:min-w-[32px]"><?= str_pad($d, 2, '0', STR_PAD_LEFT) ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach($students as $student): ?>
                        <tr class="hover:bg-indigo-50/30 transition-all duration-300 group">
                            <td class="px-4 sm:px-6 py-4 font-black text-slate-700 border-r border-slate-100 sticky left-0 bg-white z-10 shadow-[4px_0_10px_rgba(0,0,0,0.03)] group-hover:text-indigo-600 transition-colors uppercase">
                                <div class="truncate w-32 sm:w-48"><?= $student['full_name'] ?></div>
                                <div class="text-[8px] sm:text-[9px] text-slate-300 font-black tracking-widest mt-0.5 opacity-60">NIS: <?= $student['nis'] ?></div>
                            </td>
                            <?php for($d = 1; $d <= $daysInMonth; $d++): ?>
                                <td class="px-0.5 sm:px-1 py-4 text-center border-r border-slate-50/50">
                                    <?php 
                                    $status = $mappedAttendance[$student['id']][$d] ?? null;
                                    $dotColor = 'bg-slate-100 border border-slate-200';
                                    $textColor = 'text-slate-300 opacity-40';
                                    $char = '•';
                                    $hasData = false;
                                    
                                    if ($status == 'Hadir') { $dotColor = 'bg-emerald-500 shadow-emerald-100'; $textColor = 'text-white'; $char = 'H'; $hasData = true; }
                                    elseif ($status == 'Sakit' || $status == 'Izin') { $dotColor = 'bg-blue-500 shadow-blue-100'; $textColor = 'text-white'; $char = ($status == 'Sakit' ? 'S' : 'I'); $hasData = true; }
                                    elseif ($status == 'Alfa') { $dotColor = 'bg-rose-500 shadow-rose-100'; $textColor = 'text-white'; $char = 'A'; $hasData = true; }
                                    ?>
                                    <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-md sm:rounded-lg <?= $dotColor ?> mx-auto flex items-center justify-center text-[8px] sm:text-[10px] font-black <?= $textColor ?> <?= $hasData ? 'shadow-sm transform transition-transform group-hover:scale-110' : '' ?>">
                                        <?= $char ?>
                                    </div>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Row / Footer -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-indigo-900 rounded-3xl p-6 text-white shadow-xl shadow-indigo-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-white/10 rounded-2xl border border-white/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div class="text-right">
                    <div class="text-[10px] font-black uppercase tracking-widest text-indigo-300">Target Kehadiran</div>
                    <div class="text-2xl font-black">95%</div>
                </div>
            </div>
            <p class="text-xs text-indigo-200 leading-relaxed">"Kehadiran yang baik adalah awal dari prestasi yang gemilang."</p>
        </div>
         <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <h4 class="text-sm font-black text-slate-800 mb-4 uppercase tracking-widest">Data Kosong</h4>
            <p class="text-xs text-slate-500 leading-relaxed mb-4">Pastikan seluruh absensi diisi setiap hari sekolah untuk keakuratan rekap rapor anak.</p>
            <div class="flex items-center text-xs font-bold text-indigo-600">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Admin Notified of Missing Data
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
