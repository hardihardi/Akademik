<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <!-- Header Section -->
    <div class="mb-6 md:mb-10 flex flex-col xl:flex-row xl:items-end justify-between gap-6 animate-in fade-in slide-in-from-top-4 duration-700">
        <div class="flex-1 min-w-0">
            <!-- Breadcrumbs: Scrollable on mobile -->
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4 overflow-x-auto whitespace-nowrap pb-2 md:pb-0">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full flex-shrink-0"></span>
                <a href="<?= base_url('ledger') ?>" class="hover:text-indigo-600 transition-colors uppercase">REKAP NILAI</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full flex-shrink-0"></span>
                <span class="text-indigo-600 uppercase font-black tracking-widest"><?= $class['name'] ?></span>
            </div>
            
            <h1 class="text-2xl md:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase">
                Rekap Nilai <span class="text-indigo-600">Semester</span>
            </h1>
            
            <!-- Info Cards: Responsive Grid -->
            <div class="mt-6 grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3 md:gap-4">
                <div class="col-span-2 md:col-span-1 bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100/50 group hover:bg-indigo-50 transition-all duration-300">
                    <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-1">Sekolah</p>
                    <p class="text-xs md:text-sm font-bold text-slate-700 truncate"><?= $school_name ?></p>
                </div>
                <div class="bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100/50 group hover:bg-indigo-50 transition-all duration-300">
                    <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-1">Wali Kelas</p>
                    <p class="text-xs md:text-sm font-bold text-slate-700 truncate"><?= $homeroom ?></p>
                </div>
                <div class="bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100/50 group hover:bg-indigo-50 transition-all duration-300">
                    <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-1">Kelas</p>
                    <p class="text-xs md:text-sm font-bold text-slate-700"><?= $class['name'] ?></p>
                </div>
                <div class="bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100/50 group hover:bg-indigo-50 transition-all duration-300">
                    <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-1">Semester</p>
                    <p class="text-xs md:text-sm font-bold text-slate-700"><?= $year['semester'] ?></p>
                </div>
                <div class="bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100/50 group hover:bg-indigo-50 transition-all duration-300">
                    <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-1">Tahun Pelajaran</p>
                    <p class="text-xs md:text-sm font-bold text-slate-700"><?= $year['year'] ?></p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-row gap-3 no-print w-full xl:w-auto">
            <a href="<?= base_url('ledger/sync/' . $class['id']) ?>" class="flex-1 xl:flex-none inline-flex items-center justify-center px-4 md:px-6 py-3 md:py-4 rounded-xl md:rounded-2xl bg-amber-500 text-white font-black text-[10px] md:text-xs tracking-widest shadow-lg shadow-amber-100 hover:bg-amber-600 hover:-translate-y-1 active:scale-95 transition-all duration-300 whitespace-nowrap">
                <svg class="w-4 h-4 mr-2 md:mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                SINKRON
            </a>
            <a href="<?= base_url('ledger/pdf/' . $class['id']) ?>" target="_blank" class="flex-1 xl:flex-none inline-flex items-center justify-center px-4 md:px-6 py-3 md:py-4 rounded-xl md:rounded-2xl bg-rose-600 text-white font-black text-[10px] md:text-xs tracking-widest shadow-lg shadow-rose-100 hover:bg-rose-700 hover:-translate-y-1 active:scale-95 transition-all duration-300 whitespace-nowrap">
                <svg class="w-4 h-4 mr-2 md:mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                PDF
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden mb-10 animate-in fade-in slide-in-from-bottom-4 duration-1000 print:shadow-none print:border-none print:rounded-none">
        <div class="overflow-x-auto overflow-y-auto max-h-[75vh] print:max-h-none scroll-smooth relative">
            <!-- table-auto lebih baik untuk responsivitas dibanding table-fixed -->
            <table class="w-full text-left border-separate border-spacing-0 min-w-[1000px] print:min-w-0">
                <thead>
                    <tr class="bg-slate-50/80 sticky top-0 z-40 backdrop-blur-md print:bg-white">
                        <!-- Sticky No -->
                        <th class="w-12 md:w-16 px-4 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-r border-slate-100 text-center sticky left-0 bg-slate-50 z-50">
                            No
                        </th>
                        <!-- Sticky Nama -->
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-r border-slate-100 min-w-[200px] md:w-80 sticky left-12 md:left-16 bg-slate-50 z-50 shadow-[4px_0_10px_-5px_rgba(0,0,0,0.05)]">
                            Nama Siswa
                        </th>
                        <?php foreach($subjects as $subject): ?>
                            <th class="px-3 py-6 text-[9px] font-black text-slate-400 uppercase tracking-tight border-b border-r border-slate-100 text-center min-w-[100px] leading-relaxed">
                                <span class="line-clamp-2"><?= $subject['name'] ?></span>
                            </th>
                        <?php endforeach; ?>
                        <th class="px-4 py-6 text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b border-r border-slate-100 text-center w-24 bg-indigo-50/30">Rata2</th>
                        <th class="px-4 py-6 text-[10px] font-black text-emerald-600 uppercase tracking-widest border-b border-slate-100 text-center w-20 bg-emerald-50/30">Rank</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php 
                    $no = 1; 
                    foreach($students as $student): 
                        $sid = $student['id'];
                    ?>
                    <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                        <!-- Sticky No Body -->
                        <td class="px-4 py-4 border-r border-slate-50 text-center text-xs font-black text-slate-400 sticky left-0 bg-white group-hover:bg-slate-50 z-30 transition-colors">
                            <?= $no++ ?>
                        </td>
                        <!-- Sticky Nama Body -->
                        <td class="px-6 py-4 border-r border-slate-50 sticky left-12 md:left-16 bg-white group-hover:bg-slate-50 z-30 shadow-[4px_0_10px_-5px_rgba(0,0,0,0.05)] transition-colors">
                            <p class="text-sm font-extrabold text-slate-800 uppercase tracking-tight truncate max-w-[180px] md:max-w-none"><?= $student['full_name'] ?></p>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-0.5"><?= $student['nis'] ?></p>
                        </td>
                        <?php foreach($subjects as $subject): ?>
                            <td class="px-3 py-4 border-r border-slate-50 text-center">
                                <?php 
                                $val = $ledger[$sid][$subject['id']] ?? 0;
                                $isBelowKKM = $val < ($subject['kkm'] ?? 70);
                                ?>
                                <span class="text-xs font-black <?= $isBelowKKM ? 'text-rose-600' : 'text-slate-600' ?>">
                                    <?= $val ?: '-' ?>
                                </span>
                            </td>
                        <?php endforeach; ?>
                        <td class="px-4 py-4 border-r border-slate-100 text-center bg-indigo-50/10">
                            <span class="text-sm font-black text-indigo-700"><?= number_format($averages[$sid], 1) ?></span>
                        </td>
                        <td class="px-4 py-4 text-center bg-emerald-50/10">
                            <div class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 text-[10px] font-black shadow-sm">
                                <?= $ranks[$sid] ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Scroll Indicator for Mobile -->
        <div class="md:hidden bg-slate-50 px-4 py-2 text-[9px] font-bold text-slate-400 text-center border-t border-slate-100 uppercase tracking-widest">
            ← Geser untuk melihat nilai lainnya →
        </div>
    </div>

    <!-- Enhanced Print & Custom CSS -->
    <style>
        /* Sembunyikan scrollbar tapi tetap bisa di-scroll */
        .overflow-x-auto {
            -ms-overflow-style: none;
            scrollbar-width: thin;
        }
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background-color: #e2e8f0;
            border-radius: 10px;
        }

        @media print {
            @page { size: landscape; margin: 1cm; }
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .bg-white { background-color: white !important; }
            .rounded-\[2\.5rem\], .rounded-\[1\.5rem\] { border-radius: 0 !important; }
            .shadow-sm { box-shadow: none !important; }
            .max-h-\[75vh\] { max-height: none !important; overflow: visible !important; }
            table { min-width: 100% !important; border: 1px solid #e2e8f0 !important; }
            th, td { border: 1px solid #e2e8f0 !important; -webkit-print-color-adjust: exact; }
            .sticky { position: static !important; }
            .shadow-\[4px_0_10px_-5px_rgba\(0\,0\,0\,0\.05\)\] { box-shadow: none !important; }
        }
    </style>
<?= $this->endSection() ?>