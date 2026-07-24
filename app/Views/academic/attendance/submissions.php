<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h3 class="text-slate-800 text-3xl font-black tracking-tight uppercase">Persetujuan Izin / Sakit</h3>
            <p class="text-slate-500 mt-1 font-medium">Verifikasi bukti ketidakhadiran yang diunggah oleh orang tua.</p>
            <?php if (isset($activeYear)): ?>
            <span class="inline-flex items-center gap-1.5 mt-3 px-4 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-[10px] font-black uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                T.A <?= $activeYear['year'] ?> - <?= $activeYear['semester'] ?>
            </span>
            <?php endif; ?>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= base_url('attendance') ?>" class="bg-white border border-slate-200 text-slate-600 px-5 py-2.5 rounded-2xl font-bold text-sm hover:bg-slate-50 transition-all flex items-center gap-2">
                <i class="ph-bold ph-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center gap-3 animate-fade-in shadow-sm shadow-emerald-50">
            <i class="ph-bold ph-check-circle text-xl"></i>
            <p class="font-bold"><?= session()->getFlashdata('message') ?></p>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl flex items-center gap-3 animate-fade-in shadow-sm shadow-rose-50">
            <i class="ph-bold ph-warning-circle text-xl"></i>
            <p class="font-bold"><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>

    <?php if (empty($submissions)) : ?>
        <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="ph-bold ph-chats-teardrop text-5xl text-slate-300"></i>
            </div>
            <h4 class="text-2xl font-black text-slate-800 uppercase">Tidak ada pengajuan baru</h4>
            <p class="text-slate-500 mt-2 font-medium">Semua bukti izin telah diverifikasi atau belum ada kiriman baru.</p>
        </div>
    <?php else : ?>
        <!-- Desktop Table view -->
        <div class="hidden md:block bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Tanggal</th>
                        <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Siswa & Kelas</th>
                        <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Alasan</th>
                        <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Bukti Dokumen</th>
                        <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $row) : ?>
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-5 border-b border-slate-50">
                                <span class="font-black text-slate-700 block"><?= date('d M Y', strtotime($row['date'])) ?></span>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Diajukan: <?= date('d M Y', strtotime($row['created_at'])) ?></span>
                            </td>
                            <td class="px-6 py-5 border-b border-slate-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-sm uppercase">
                                        <?= substr($row['student_name'], 0, 2) ?>
                                    </div>
                                    <div>
                                        <span class="font-black text-slate-700 block text-lg leading-tight uppercase"><?= $row['student_name'] ?></span>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[10px] font-black uppercase tracking-tighter leading-none"><?= $row['class_name'] ?></span>
                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[10px] font-black uppercase tracking-tighter leading-none border border-emerald-100">T.A <?= $row['academic_year_name'] ?> - <?= $row['semester'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 border-b border-slate-50">
                                <?php if ($row['status'] == 'S') : ?>
                                    <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-xs font-black uppercase tracking-tighter">Sakit / Medis</span>
                                <?php elseif ($row['status'] == 'I') : ?>
                                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-black uppercase tracking-tighter">Izin / Keperluan</span>
                                <?php endif; ?>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-1 font-medium max-w-xs"><?= $row['note'] ?: '-' ?></p>
                            </td>
                            <td class="px-6 py-5 border-b border-slate-50 text-center">
                                <a href="<?= base_url('uploads/attendance/' . $row['evidence_path']) ?>" target="_blank" class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-center justify-center text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all group/file shadow-sm">
                                    <i class="ph-bold ph-file-image text-xl"></i>
                                    <span class="text-[8px] font-black uppercase tracking-tighter leading-none mt-1 group-hover/file:text-white text-slate-400">View</span>
                                </a>
                            </td>
                            <td class="px-6 py-5 border-b border-slate-50 text-right">
                                <form action="<?= base_url('attendance/verify_submission/' . $row['id']) ?>" method="POST" class="inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="bg-indigo-600 hover:bg-slate-900 text-white px-6 py-3 rounded-2xl text-xs font-black transition-all shadow-lg shadow-indigo-100 uppercase tracking-widest flex items-center gap-2 ml-auto">
                                        <i class="ph-bold ph-check-double text-sm"></i>
                                        Setujui
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile Card view -->
        <div class="md:hidden space-y-4 mb-6">
            <?php foreach ($submissions as $row) : ?>
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-5 animate-slide-up relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-3">
                        <span class="px-2 py-1 bg-slate-50 rounded text-[9px] font-black text-slate-400 uppercase tracking-tighter"><?= date('d/m/y', strtotime($row['date'])) ?></span>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-3xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-lg uppercase border border-indigo-100 shadow-inner">
                            <?= substr($row['student_name'], 0, 2) ?>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-800 text-xl leading-none uppercase"><?= $row['student_name'] ?></h4>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[10px] font-black uppercase tracking-tighter leading-none"><?= $row['class_name'] ?></span>
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[10px] font-black uppercase tracking-tighter leading-none border border-emerald-100"><?= $row['academic_year_name'] ?> (<?= substr($row['semester'], 0, 3) ?>)</span>
                                <?php if ($row['status'] == 'S') : ?>
                                    <span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded text-[10px] font-black uppercase tracking-tighter leading-none">Sakit</span>
                                <?php elseif ($row['status'] == 'I') : ?>
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[10px] font-black uppercase tracking-tighter leading-none">Izin</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100/50">
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Catatan Orang Tua:</p>
                        <p class="text-sm text-slate-600 font-medium leading-relaxed"><?= $row['note'] ?: 'Tidak ada keterangan tambahan.' ?></p>
                    </div>
                    
                    <div class="flex gap-3 pt-1">
                        <a href="<?= base_url('uploads/attendance/' . $row['evidence_path']) ?>" target="_blank" class="flex-1 bg-white border border-slate-200 text-slate-600 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-slate-50 transition-all shadow-sm">
                            <i class="ph-bold ph-eye text-base"></i>
                            Bukti
                        </a>
                        <form action="<?= base_url('attendance/verify_submission/' . $row['id']) ?>" method="POST" class="flex-[2]">
                            <?= csrf_field() ?>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-slate-900 text-white py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-2 transition-all shadow-lg shadow-indigo-50 border border-indigo-700/10">
                                <i class="ph-bold ph-check-circle text-base"></i>
                                Verifikasi
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <style>
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-up {
            animation: slide-up 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
<?= $this->endSection() ?>
