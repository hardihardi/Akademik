<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="animate-in fade-in duration-700">
    <!-- Header Section -->
    <div class="mb-8 lg:mb-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-[10px] font-black uppercase tracking-[0.2em]">
                        <li class="inline-flex items-center">
                            <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Dashboard</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="<?= base_url('assignments') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Pembelajaran</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-indigo-600">Laporan Penyerahan</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-slate-800 tracking-tight leading-tight uppercase font-display">Laporan Penyerahan</h1>
                <p class="text-slate-500 mt-3 font-medium text-sm lg:text-base max-w-2xl">
                    Ringkasan status pengumpulan <span class="text-indigo-600 font-bold"><?= $assignment['title'] ?></span> untuk <span class="text-slate-700 font-bold"><?= $assignment['class_name'] ?></span>.
                </p>
            </div>
            <div class="flex gap-3">
                <a href="<?= base_url('assignments/submissions/' . $assignment['id']) ?>" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-white border border-slate-100 text-slate-600 font-black text-xs tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                    PENINJAUAN
                </a>
                <a href="<?= base_url('assignments/report-pdf/' . $assignment['id']) ?>" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-indigo-600 text-white font-black text-xs tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 no-print">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    CETAK LAPORAN
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-8 mb-10">
        <!-- Total Students -->
        <div class="bg-white p-6 lg:p-8 rounded-[2rem] shadow-sm border border-slate-50 relative overflow-hidden group hover:shadow-xl hover:shadow-slate-100 transition-all duration-500">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                <svg class="w-16 h-16 text-slate-800" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Siswa</p>
            <h3 class="text-3xl lg:text-4xl font-black text-slate-800 mt-2"><?= $stats['total'] ?></h3>
            <p class="text-xs font-bold text-slate-400 mt-1">Dalam satu kelas</p>
        </div>

        <!-- Submitted -->
        <div class="bg-white p-6 lg:p-8 rounded-[2rem] shadow-sm border border-slate-50 relative overflow-hidden group hover:shadow-xl hover:shadow-emerald-100/30 transition-all duration-500">
            <div class="absolute top-0 right-0 p-4 opacity-10 text-emerald-600 group-hover:scale-110 transition-transform">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
            </div>
            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Tepat Waktu</p>
            <h3 class="text-3xl lg:text-4xl font-black text-emerald-600 mt-2"><?= $stats['sudah'] ?></h3>
            <p class="text-xs font-bold text-slate-400 mt-1">Siswa mengumpulkan</p>
        </div>

        <!-- Late -->
        <div class="bg-white p-6 lg:p-8 rounded-[2rem] shadow-sm border border-slate-50 relative overflow-hidden group hover:shadow-xl hover:shadow-amber-100/30 transition-all duration-500">
            <div class="absolute top-0 right-0 p-4 opacity-10 text-amber-600 group-hover:scale-110 transition-transform">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.828a1 1 0 101.414-1.414L11 9.586V6z" clip-rule="evenodd" /></svg>
            </div>
            <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Terlambat</p>
            <h3 class="text-3xl lg:text-4xl font-black text-amber-600 mt-2"><?= $stats['terlambat'] ?></h3>
            <p class="text-xs font-bold text-slate-400 mt-1">Melewati deadline</p>
        </div>

        <!-- Not Submitted -->
        <div class="bg-white p-6 lg:p-8 rounded-[2rem] shadow-sm border border-slate-50 relative overflow-hidden group hover:shadow-xl hover:shadow-rose-100/30 transition-all duration-500">
            <div class="absolute top-0 right-0 p-4 opacity-10 text-rose-600 group-hover:scale-110 transition-transform">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
            </div>
            <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest">Belum Kumpul</p>
            <h3 class="text-3xl lg:text-4xl font-black text-rose-600 mt-2"><?= $stats['belum'] ?></h3>
            <p class="text-xs font-bold text-slate-400 mt-1 text-nowrap">Belum ada respon</p>
        </div>
    </div>

    <!-- Detailed List Section -->
    <div class="space-y-8">
        <!-- Render Each Category -->
        <?php 
        $categories = [
            ['id' => 'tab-sudah', 'label' => 'Tepat Waktu', 'data' => $reportData['sudah'], 'color' => 'emerald'],
            ['id' => 'tab-terlambat', 'label' => 'Terlambat', 'data' => $reportData['terlambat'], 'color' => 'amber'],
            ['id' => 'tab-belum', 'label' => 'Belum Mengumpulkan', 'data' => $reportData['belum'], 'color' => 'rose'],
        ];

        foreach ($categories as $cat):
        ?>
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-50 overflow-hidden">
            <div class="p-6 lg:px-10 lg:py-8 border-b border-slate-50 flex items-center justify-between bg-<?= $cat['color'] ?>-50/30">
                <div class="flex items-center gap-4">
                    <div class="w-1.5 h-8 bg-<?= $cat['color'] ?>-500 rounded-full"></div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight"><?= $cat['label'] ?></h2>
                        <p class="text-xs font-bold text-<?= $cat['color'] ?>-600 uppercase tracking-widest mt-0.5"><?= count($cat['data']) ?> Siswa</p>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50">
                            <th class="px-8 py-6">NIS</th>
                            <th class="px-8 py-6">Nama Siswa</th>
                            <th class="px-8 py-6">Waktu Penyerahan</th>
                            <th class="px-8 py-6">Nilai</th>
                            <th class="px-8 py-6">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if (empty($cat['data'])): ?>
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <p class="text-slate-400 font-bold text-sm">Tidak ada data untuk kategori ini.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($cat['data'] as $student): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <span class="text-xs font-bold text-slate-500 group-hover:text-indigo-600 transition-colors"><?= $student['nis'] ?></span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-sm font-black text-slate-800 group-hover:text-indigo-600 transition-colors"><?= $student['full_name'] ?></span>
                                </td>
                                <td class="px-8 py-5">
                                    <?php if (isset($student['submit_time'])): ?>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-slate-700"><?= date('d M Y', strtotime($student['submit_time'])) ?></span>
                                            <span class="text-[10px] font-bold text-slate-400 mt-0.5 uppercase tracking-widest"><?= date('H:i', strtotime($student['submit_time'])) ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs font-bold text-slate-300">---</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-5">
                                    <?php if ($student['grade'] !== null): ?>
                                        <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-black"><?= $student['grade'] ?></span>
                                    <?php else: ?>
                                        <span class="text-xs font-bold text-slate-300">Belum Dinilai</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-5">
                                    <?php if ($cat['id'] == 'tab-sudah'): ?>
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-emerald-600 uppercase tracking-widest px-3 py-1 bg-emerald-50 rounded-full border border-emerald-100">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                            Selesai
                                        </span>
                                    <?php elseif ($cat['id'] == 'tab-terlambat'): ?>
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-amber-600 uppercase tracking-widest px-3 py-1 bg-amber-50 rounded-full border border-amber-100">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                            Terlambat
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-rose-600 uppercase tracking-widest px-3 py-1 bg-rose-50 rounded-full border border-rose-100">
                                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
                                            Belum Ada
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    @media print {
        body { background: white !important; }
        .no-print { display: none !important; }
        aside, header { display: none !important; }
        main { margin-left: 0 !important; padding: 0 !important; }
        .animate-in { animation: none !important; opacity: 1 !important; transform: none !important; }
        .bg-white { border: none !important; box-shadow: none !important; }
        .rounded-\[2\.5rem\], .rounded-\[2rem\] { border-radius: 1rem !important; }
        .shadow-sm, .shadow-lg { box-shadow: none !important; }
        .p-8, .p-10 { padding: 1rem !important; }
    }
</style>

<?= $this->endSection() ?>
