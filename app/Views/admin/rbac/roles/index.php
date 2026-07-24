<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-8">
        <div>
            <div class="flex items-center gap-2 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 lg:mb-4">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase">HAK AKSES / ROLES</span>
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase"><?= $title ?></h1>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Kelola peran pengguna dan pembatasan akses sistem.</p>
        </div>
        <div>
            <a href="<?= base_url('roles/create') ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-indigo-600 text-white font-black text-[10px] lg:text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-0.5 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 lg:mr-3 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                TAMBAH ROLE
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('message')):?>
        <div class="mb-6 p-4 sm:p-5 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-600 shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                </div>
                <p class="text-sm font-bold text-emerald-800 uppercase tracking-tight"><?= session()->getFlashdata('message') ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    <?php endif;?>

    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-2xl lg:rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mb-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-16">ID</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Nama Role</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Deskripsi Access</th>
                        <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach($roles as $role): ?>
                    <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                        <td class="p-5 lg:p-6 text-xs font-bold text-slate-400"><?= $role['id'] ?></td>
                        <td class="p-5 lg:p-6">
                            <span class="text-slate-800 font-black tracking-tight group-hover:text-indigo-600 transition-colors uppercase"><?= $role['name'] ?></span>
                        </td>
                        <td class="p-5 lg:p-6">
                            <span class="text-sm font-medium text-slate-500"><?= $role['description'] ?: 'Tidak ada deskripsi' ?></span>
                        </td>
                        <td class="p-5 lg:p-6 text-right">
                            <div class="flex items-center justify-end gap-2 text-sm font-medium tracking-widest">
                                <a href="<?= base_url('roles/edit/' . $role['id']) ?>" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-emerald-600 hover:shadow-md rounded-xl transition-all duration-300" title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="<?= base_url('roles/delete/' . $role['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Apakah Anda yakin ingin menghapus role ini?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-rose-600 hover:shadow-md rounded-xl transition-all duration-300" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3 mb-10 uppercase tracking-widest">
        <?php foreach($roles as $role): ?>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-black text-slate-400">#<?= $role['id'] ?></span>
                <div class="flex items-center gap-2">
                    <a href="<?= base_url('roles/edit/' . $role['id']) ?>" class="p-2 bg-slate-50 text-emerald-600 rounded-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </a>
                    <form action="<?= base_url('roles/delete/' . $role['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Hapus role ini?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="p-2 bg-slate-50 text-rose-600 rounded-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </form>
                </div>
            </div>
            <h5 class="text-sm font-black text-slate-800 mb-1"><?= $role['name'] ?></h5>
            <p class="text-[10px] text-slate-400 leading-relaxed font-medium normal-case"><?= $role['description'] ?: 'Tidak ada deskripsi' ?></p>
        </div>
        <?php endforeach; ?>
    </div>

<?= $this->endSection() ?>
