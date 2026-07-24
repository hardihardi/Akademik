<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-8">
        <div>
            <nav class="flex mb-3 lg:mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em]">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Dashboard</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 uppercase">Wali Kelas</span>
                    </li>
                </ol>
            </nav>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase">Penugasan Wali Kelas</h3>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Manajemen guru yang bertanggung jawab atas kelas tertentu.</p>
        </div>
        <div>
            <a href="<?= base_url('homerooms/create') ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-indigo-600 text-white font-black text-[10px] lg:text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-0.5 transition-all duration-300 uppercase">
                <svg class="w-4 h-4 mr-2 lg:mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                TAMBAH WALI KELAS
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('message')): ?>
        <div class="mb-6 p-4 sm:p-5 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-600 shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                </div>
                <div>
                    <p class="text-emerald-800 font-black text-sm uppercase tracking-tight leading-none mb-1">Berhasil</p>
                    <p class="text-emerald-600 text-[10px] font-bold"><?= session()->getFlashdata('message') ?></p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="mb-6 p-4 sm:p-5 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-rose-600 shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-rose-800 font-black text-sm uppercase tracking-tight leading-none mb-1">Kesalahan</p>
                    <p class="text-rose-600 text-[10px] font-bold"><?= session()->getFlashdata('error') ?></p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    <?php endif; ?>

    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Kelas</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Wali Kelas</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Tahun Ajaran</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(empty($assignments)): ?>
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-300 mb-4">
                                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    </div>
                                    <p class="text-slate-400 font-bold">Belum ada data wali kelas.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($assignments as $row): ?>
                            <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                                <td class="p-6">
                                    <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-xl border border-indigo-100 uppercase tracking-widest">Kelas <?= $row['class_name'] ?></span>
                                </td>
                                <td class="p-6 text-slate-800 font-black tracking-tight group-hover:text-indigo-600 transition-colors uppercase"><?= $row['teacher_name'] ?></td>
                                <td class="p-6 text-center">
                                    <p class="text-xs font-bold text-slate-600"><?= $row['academic_year'] ?></p>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mt-1"><?= ($row['semester'] == 1) ? 'Ganjil' : 'Genap' ?></p>
                                </td>
                                <td class="p-6 text-right">
                                    <div class="flex items-center justify-end gap-2 text-sm font-medium tracking-widest uppercase">
                                        <a href="<?= base_url('homerooms/edit/' . $row['id']) ?>" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-emerald-600 hover:shadow-md rounded-xl transition-all duration-300" title="Edit">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="<?= base_url('homerooms/delete/' . $row['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Apakah Anda yakin ingin menghapus data ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-rose-600 hover:shadow-md rounded-xl transition-all duration-300" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
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

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3 mb-10 uppercase tracking-widest">
        <?php if(empty($assignments)): ?>
            <div class="bg-white rounded-2xl border border-slate-100 p-8 text-center text-slate-400 font-bold text-sm lowercase">
                Belum ada data wali kelas.
            </div>
        <?php else: ?>
            <?php foreach($assignments as $row): ?>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <span class="inline-flex px-3 py-1 bg-indigo-50 text-indigo-700 text-[9px] font-black rounded-lg border border-indigo-100">Kelas <?= $row['class_name'] ?></span>
                    <div class="flex items-center gap-2">
                        <a href="<?= base_url('homerooms/edit/' . $row['id']) ?>" class="p-2 bg-slate-50 text-emerald-600 rounded-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form action="<?= base_url('homerooms/delete/' . $row['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Hapus data?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="p-2 bg-slate-50 text-rose-600 rounded-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <h5 class="text-sm font-black text-slate-800 mb-1 leading-tight uppercase tracking-tight"><?= $row['teacher_name'] ?></h5>
                <div class="flex items-center gap-2 text-[9px] font-bold text-slate-400">
                    <span><?= $row['academic_year'] ?></span>
                    <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                    <span><?= ($row['semester'] == 1) ? 'GANJIL' : 'GENAP' ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>
