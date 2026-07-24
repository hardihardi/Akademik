<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto space-y-4 sm:space-y-8 animate-in fade-in slide-in-from-bottom-6 duration-700 pb-10">
    
    <!-- Header Section -->
    <div class="bg-white rounded-[1.5rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-sm border border-slate-100 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-32 h-32 sm:w-64 sm:h-64 bg-slate-50 rounded-full opacity-50"></div>
        
        <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-50 rounded-full">
                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    <span class="text-[10px] font-black uppercase tracking-[0.1em] text-indigo-600">Jadwal Mengajar Saya</span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase">
                    Jadwal <span class="text-indigo-600">Mengajar</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-xl">
                    Lihat dan cetak jadwal mengajar Anda untuk tahun akademik aktif. Klik tombol cetak untuk versi fisik yang rapi.
                </p>
            </div>

            <div class="flex items-center no-print">
                <button onclick="window.print()" class="w-full sm:w-auto flex items-center justify-center gap-3 px-8 py-4 bg-indigo-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-200 active:scale-95">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    Cetak Jadwal
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section (No Print) -->
    <div class="no-print">
        <form action="<?= base_url('guru/schedule') ?>" method="get" class="grid grid-cols-1 md:grid-cols-12 items-end gap-4 bg-white p-4 sm:p-6 rounded-[1.5rem] border border-slate-100 shadow-sm">
            <div class="md:col-span-4 lg:col-span-3">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Pilih Tahun Akademik</label>
                <select name="academic_year_id" onchange="this.form.submit()" class="w-full bg-slate-50 border-slate-200 rounded-xl text-xs font-bold text-slate-600 focus:ring-indigo-500 focus:border-indigo-500 transition-all py-3">
                    <?php foreach($academicYears as $year): ?>
                        <option value="<?= $year['id'] ?>" <?= $selectedYearId == $year['id'] ? 'selected' : '' ?>>
                            <?= $year['year'] ?> - <?= $year['semester'] == 1 ? 'Ganjil' : 'Genap' ?> <?= $year['status'] == 'Active' ? '(Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="hidden md:block md:col-span-8 lg:col-span-9 text-right pb-3">
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">
                    Tahun Pelajaran Saat Ini: <span class="text-indigo-500"><?= $activeYear['year'] ?> (<?= $activeYear['semester'] == 1 ? 'Ganjil' : 'Genap' ?>)</span>
                </span>
            </div>
        </form>
    </div>

    <!-- Schedule Grid (Desktop) -->
    <div class="hidden lg:block bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 overflow-x-auto">
        <div class="min-w-[1000px]">
            <div class="grid grid-cols-6 gap-4">
                <?php 
                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                foreach($days as $day): 
                ?>
                <div class="space-y-4">
                    <!-- Day Header -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] block mb-1"><?= substr($day, 0, 3) ?></span>
                        <span class="text-sm font-black text-slate-700 uppercase tracking-tight"><?= $day ?></span>
                    </div>

                    <!-- Classes for the day -->
                    <div class="space-y-3">
                        <?php if(!empty($groupedSchedules[$day])): ?>
                            <?php foreach($groupedSchedules[$day] as $sch): ?>
                            <div class="group p-4 rounded-2xl bg-white border border-slate-100 hover:shadow-xl hover:shadow-indigo-100/50 hover:border-indigo-200 transition-all duration-300 relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-1 bg-indigo-500 h-full opacity-0 group-hover:opacity-100 transition-all"></div>
                                <div class="relative">
                                    <div class="inline-block text-[9px] font-black text-indigo-600 mb-3 px-2 py-1 bg-indigo-50 rounded-lg">
                                        <?= date('H:i', strtotime($sch['start_time'])) ?> - <?= date('H:i', strtotime($sch['end_time'])) ?>
                                    </div>
                                    <h4 class="text-xs font-black text-slate-700 uppercase leading-snug mb-3 group-hover:text-indigo-700 transition-colors line-clamp-2"><?= $sch['subject_name'] ?></h4>
                                    
                                    <div class="flex items-center gap-2 pt-3 border-t border-slate-50">
                                        <div class="w-6 h-6 rounded-lg bg-slate-50 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        </div>
                                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest"><?= $sch['class_name'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="py-10 rounded-2xl border-2 border-dashed border-slate-50 text-center">
                                <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Tidak Ada</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Mobile View (Accordions) -->
    <div class="lg:hidden space-y-3 px-1">
        <?php 
        $currentDayNum = date('w'); 
        $dayMap = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'];
        ?>
        <?php foreach($days as $day): ?>
        <div x-data="{ open: <?= (isset($dayMap[$currentDayNum]) && $dayMap[$currentDayNum] == $day) ? 'true' : 'false' ?> }" 
             class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden transition-all"
             :class="open ? 'ring-2 ring-indigo-500/10 border-indigo-100' : ''">
            
            <button @click="open = !open" class="w-full flex items-center justify-between p-4 focus:outline-none">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl flex flex-col items-center justify-center transition-all duration-300 shadow-sm"
                         :class="open ? 'bg-indigo-600 text-white' : 'bg-slate-50 text-slate-400'">
                        <span class="text-[7px] font-black uppercase tracking-tighter leading-none mb-0.5"><?= substr($day, 0, 3) ?></span>
                        <span class="text-[10px] font-black uppercase leading-none"><?= substr($day, 0, 1) ?></span>
                    </div>
                    <div class="text-left">
                        <h4 class="text-xs font-black text-slate-700 uppercase tracking-tight" :class="open ? 'text-indigo-600' : ''"><?= $day ?></h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"><?= count($groupedSchedules[$day] ?? []) ?> Mata Pelajaran</p>
                    </div>
                </div>
                <div class="w-7 h-7 rounded-full flex items-center justify-center bg-slate-50 text-slate-300 transition-transform duration-300" :class="open ? 'rotate-180 bg-indigo-50 text-indigo-500' : ''">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </button>

            <div x-show="open" x-collapse>
                <div class="px-4 pb-4 space-y-3 border-t border-slate-50 pt-4">
                    <?php if(!empty($groupedSchedules[$day])): ?>
                        <?php foreach($groupedSchedules[$day] as $sch): ?>
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 relative group">
                             <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h5 class="text-xs font-black text-slate-700 uppercase leading-tight mb-1"><?= $sch['subject_name'] ?></h5>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3 h-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span class="text-[10px] font-bold text-slate-500 tracking-tight"><?= date('H:i', strtotime($sch['start_time'])) ?> - <?= date('H:i', strtotime($sch['end_time'])) ?></span>
                                    </div>
                                </div>
                                <span class="px-2 py-1 bg-white text-indigo-600 text-[9px] font-black rounded-lg border border-slate-200 shadow-sm whitespace-nowrap uppercase"><?= $sch['class_name'] ?></span>
                             </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="py-6 text-center">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Tidak ada jadwal untuk hari <?= $day ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty State -->
    <?php if(empty($groupedSchedules)): ?>
    <div class="bg-white rounded-[2rem] p-12 sm:p-20 text-center shadow-sm border border-slate-100">
        <div class="w-16 h-16 sm:w-24 sm:h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mx-auto mb-6">
            <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        </div>
        <h3 class="text-lg font-black text-slate-700 uppercase tracking-tight">Data Tidak Tersedia</h3>
        <p class="text-xs sm:text-sm text-slate-400 font-medium mt-2 max-w-xs mx-auto">Jadwal mengajar untuk periode ini belum diatur oleh admin kurikulum.</p>
    </div>
    <?php endif; ?>

</div>

<!-- Print & Mobile Optimized Styles -->
<style>
    @media print {
        @page { size: landscape; margin: 0.5cm; }
        body { background: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .no-print { display: none !important; }
        .bg-white { background-color: white !important; }
        .bg-slate-50 { background-color: #f8fafc !important; }
        .bg-indigo-50 { background-color: #eef2ff !important; }
        .text-indigo-600 { color: #4f46e5 !important; }
        .shadow-sm, .shadow-xl, .shadow-lg { box-shadow: none !important; }
        .border { border: 1px solid #e2e8f0 !important; }
        .rounded-\[2rem\], .rounded-2xl, .rounded-xl { border-radius: 8px !important; }
        .lg\:block { display: block !important; }
        .hidden.lg\:block { display: block !important; }
        .lg\:hidden { display: none !important; }
        /* Paksa grid tampil 6 kolom saat print */
        .grid-cols-6 { display: grid !important; grid-template-columns: repeat(6, minmax(0, 1fr)) !important; gap: 8px !important; }
        .min-w-\[1000px\] { min-width: 100% !important; }
    }

    /* Hide scrollbar but keep functionality */
    .overflow-x-auto::-webkit-scrollbar { height: 4px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: #f1f1f1; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>
<?= $this->endSection() ?>