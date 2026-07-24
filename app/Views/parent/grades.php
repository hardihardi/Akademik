<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-bold uppercase tracking-widest">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Dashboard</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600">Nilai</span>
                    </li>
                </ol>
            </nav>
            <h3 class="text-slate-800 text-4xl font-black tracking-tight">Capaian Akademik</h3>
            <p class="text-slate-500 mt-2 font-medium">Laporan hasil belajar komprehensif <strong><?= $student['full_name'] ?></strong></p>
        </div>
        <div class="bg-white px-6 py-4 rounded-2xl border border-slate-100 flex items-center shadow-sm">
            <div class="p-2.5 bg-emerald-500 rounded-xl text-white mr-4 shadow-lg shadow-emerald-100">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Rata-rata Kelas</span>
                <span class="text-xl font-black text-slate-800 tracking-tighter">84.5</span>
            </div>
        </div>
    </div>

    <?php if(!empty($grades)): ?>
        <?php 
            $groupedGrades = [];
            foreach($grades as $g) {
                $groupedGrades[$g['subject_name']][] = $g;
            }
        ?>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-12">
            <?php foreach($groupedGrades as $subject => $items): ?>
                <?php $avg = round(array_sum(array_column($items, 'score')) / count($items)); ?>
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:translate-y-[-4px] transition-all duration-300 flex flex-col group">
                    <div class="bg-slate-50/50 px-8 py-5 border-b border-slate-100 flex justify-between items-center group-hover:bg-indigo-50/30 transition-colors">
                        <div>
                            <h4 class="font-black text-slate-800 tracking-tight group-hover:text-indigo-700 transition-colors"><?= $subject ?></h4>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5"><?= count($items) ?> Penilaian Tercatat</p>
                        </div>
                        <div class="flex items-center bg-white px-4 py-2 rounded-2xl shadow-sm border border-slate-100">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mr-3">Indeks</span>
                            <span class="text-2xl font-black <?= $avg >= 75 ? 'text-indigo-600' : 'text-rose-500' ?>"><?= $avg ?></span>
                        </div>
                    </div>
                    <div class="p-0 flex-grow overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50/30 text-slate-400 font-bold text-[9px] uppercase tracking-widest">
                                <tr>
                                    <th class="py-3 px-8 text-left whitespace-nowrap">Tipe Ujian</th>
                                    <th class="py-3 px-8 text-left whitespace-nowrap">Tanggal</th>
                                    <th class="py-3 px-8 text-right whitespace-nowrap">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <?php foreach($items as $item): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors group/row">
                                    <td class="py-4 px-8">
                                        <span class="text-xs font-black text-slate-700 uppercase tracking-tight"><?= ucfirst($item['type'] ?? 'Tugas') ?></span>
                                    </td>
                                    <td class="py-4 px-8">
                                        <span class="text-xs font-semibold text-slate-400 tracking-tight"><?= date('d M Y', strtotime($item['created_at'])) ?></span>
                                    </td>
                                    <td class="py-4 px-8 text-right">
                                        <span class="px-3 py-1 rounded-lg font-black text-sm <?= $item['score'] >= 75 ? 'text-emerald-700 bg-emerald-50 border border-emerald-100' : 'text-rose-700 bg-rose-50 border border-rose-100' ?>">
                                            <?= $item['score'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-20 text-center mb-12">
            <div class="inline-flex items-center justify-center w-28 h-28 rounded-[2rem] bg-indigo-50 mb-8 text-indigo-400 rotate-12">
                <svg class="w-14 h-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 00-2 2v-4a2 2 0 012-2h10a2 2 0 012 2v4a2 2 0 00-2 2H7z"></path></svg>
            </div>
            <h3 class="text-3xl font-black text-slate-800 mb-4 tracking-tight">Belum Ada Data Nilai</h3>
            <p class="text-slate-500 max-w-sm mx-auto font-medium">Hasil belajar Anda akan muncul di sini setelah pihak sekolah melakukan input penilaian semester.</p>
        </div>
    <?php endif; ?>

    <!-- Pagination -->
    <div class="mb-12">
        <?= $pager->links('grades', 'tailwind_pager') ?>
    </div>
<?= $this->endSection() ?>
