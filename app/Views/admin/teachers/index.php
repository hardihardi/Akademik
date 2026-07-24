<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600">MANAJEMEN GURU</span>
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight">Daftar Tenaga Pendidik</h1>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Manajemen data guru, status keaktifan, dan penugasan mengajar secara terpusat.</p>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-wrap sm:flex-nowrap gap-2 lg:gap-3">
            <div class="grid grid-cols-2 gap-2 w-full sm:w-auto">
                <a href="<?= base_url('teachers/exportCsv') ?>" class="inline-flex items-center justify-center px-4 py-3 rounded-xl bg-white text-emerald-600 border border-emerald-100 font-black text-[10px] tracking-widest shadow-sm hover:bg-emerald-50">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    CSV
                </a>
                <a href="<?= base_url('teachers/exportPdf') ?>" class="inline-flex items-center justify-center px-4 py-3 rounded-xl bg-white text-rose-600 border border-rose-100 font-black text-[10px] tracking-widest shadow-sm hover:bg-rose-50">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    PDF
                </a>
            </div>
            <a href="<?= base_url('teachers/new') ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 rounded-xl bg-indigo-600 text-white font-black text-[10px] tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                TAMBAH GURU
            </a>
        </div>
    </div>

    <!-- Flash Messages (Handled by main layout, but local redundancy is okay or we can rely on main) -->

    <!-- Search & Filter Bar -->
    <form action="<?= base_url('teachers') ?>" method="get" class="mb-8 flex flex-col md:flex-row gap-4">
        <div class="relative flex-1">
            <input 
                name="search"
                type="text" 
                value="<?= $filters['search'] ?? '' ?>"
                placeholder="Cari Nama atau NIP..." 
                class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-white border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 font-medium text-sm shadow-sm"
            >
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <div class="relative flex-1 md:w-44">
                <select 
                    name="status"
                    onchange="this.form.submit()"
                    class="w-full pl-4 pr-10 py-3.5 rounded-2xl bg-white border border-slate-200 focus:border-indigo-500 font-black text-[10px] uppercase tracking-widest appearance-none cursor-pointer shadow-sm text-slate-600"
                >
                    <option value="">Semua Status</option>
                    <option value="Aktif" <?= ($filters['status'] ?? '') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="Non-Aktif" <?= ($filters['status'] ?? '') == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
            
            <?php if(!empty($filters['search']) || !empty($filters['status'])): ?>
                <a href="<?= base_url('teachers') ?>" class="flex items-center justify-center h-[52px] w-12 bg-rose-50 border border-rose-100 text-rose-500 rounded-2xl hover:bg-rose-500 hover:text-white shadow-sm" title="Reset Filter">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                </a>
            <?php endif; ?>
        </div>
    </form>

    <!-- Content Area -->
    <div class="mb-10">
        <!-- ==================== MOBILE: Card Layout ==================== -->
        <div class="lg:hidden space-y-4">
            <?php if(empty($teachers)): ?>
                <div class="bg-white rounded-2xl p-10 text-center border border-slate-100">
                    <p class="text-slate-400 font-black text-[10px] uppercase tracking-widest">Tidak ada data guru</p>
                </div>
            <?php else: ?>
                <?php foreach($teachers as $teacher): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-indigo-50 border-2 border-white shadow-md flex-shrink-0 flex items-center justify-center overflow-hidden">
                            <?php if(!empty($teacher['photo'])): ?>
                                <img src="<?= get_photo_url($teacher['photo']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-indigo-600 font-black text-lg uppercase"><?= substr($teacher['full_name'], 0, 1) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <p class="text-slate-800 font-extrabold text-sm uppercase truncate pr-2"><?= $teacher['full_name'] ?></p>
                                <?php if($teacher['status'] == 'Aktif'): ?>
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[8px] font-black rounded border border-emerald-100 tracking-wider">AKTIF</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[8px] font-black rounded border border-rose-100 tracking-wider">NON-AKTIF</span>
                                <?php endif; ?>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">NIP: <?= $teacher['nip'] ?: '-' ?></p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">NUPTK: <?= $teacher['nuptk'] ?: '-' ?></p>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-50 space-y-2">
                        <div class="flex items-center gap-3 text-slate-600">
                            <svg class="w-4 h-4 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            <span class="text-xs font-bold"><?= $teacher['phone'] ?: '-' ?></span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-400">
                            <svg class="w-4 h-4 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                            <span class="text-[10px] font-bold truncate tracking-tight"><?= $teacher['address'] ?: 'Alamat belum diatur' ?></span>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 mt-4 pt-4 border-t border-slate-50">
                        <a href="<?= base_url('teachers/' . $teacher['id']) ?>" class="flex-1 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl flex justify-center items-center font-bold text-[10px] uppercase">Profil</a>
                        <a href="<?= base_url('teachers/' . $teacher['id'] . '/edit') ?>" class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form action="<?= base_url('teachers/' . $teacher['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Hapus data guru <?= addslashes($teacher['full_name']) ?>?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="p-2.5 bg-rose-50 text-rose-500 rounded-xl">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- ==================== DESKTOP: Table Layout ==================== -->
        <div class="hidden lg:block bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Guru</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Kontak & Alamat</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-center">Status</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(empty($teachers)): ?>
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-300 mb-6 border-2 border-dashed border-slate-200">
                                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    </div>
                                    <p class="text-slate-400 font-black tracking-tight text-lg">Tidak ada data guru yang ditemukan.</p>
                                    <p class="text-slate-400 text-[10px] font-medium uppercase tracking-widest mt-2">Coba gunakan kata kunci pencarian yang lain</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($teachers as $teacher): ?>
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-5">
                                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 border-2 border-white shadow-xl shadow-indigo-100/20 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                            <?php if(!empty($teacher['photo'])): ?>
                                                <img src="<?= get_photo_url($teacher['photo']) ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <span class="text-indigo-600 font-black text-xl uppercase"><?= substr($teacher['full_name'], 0, 1) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-slate-800 font-extrabold text-base tracking-tight uppercase leading-none truncate"><?= $teacher['full_name'] ?></p>
                                            <div class="flex flex-col gap-1 mt-2">
                                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">NIP: <?= $teacher['nip'] ?: '-' ?></p>
                                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">NUPTK: <?= $teacher['nuptk'] ?: '-' ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-2 text-slate-600">
                                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                            <span class="text-xs font-bold"><?= $teacher['phone'] ?: '-' ?></span>
                                        </div>
                                        <div class="flex items-center gap-2 text-slate-400">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                            <span class="text-[10px] font-bold line-clamp-1 max-w-[250px]"><?= $teacher['address'] ?: 'Alamat belum diatur' ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <?php if($teacher['status'] == 'Aktif'): ?>
                                        <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-lg border border-emerald-100 uppercase tracking-widest">AKTIF</span>
                                    <?php else: ?>
                                        <span class="px-4 py-1.5 bg-rose-50 text-rose-600 text-[10px] font-black rounded-lg border border-rose-100 uppercase tracking-widest">NON-AKTIF</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="<?= base_url('teachers/' . $teacher['id']) ?>" class="p-2.5 bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 hover:shadow-md rounded-xl" title="Detail">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        </a>
                                        <a href="<?= base_url('teachers/' . $teacher['id'] . '/edit') ?>" class="p-2.5 bg-white border border-slate-100 text-slate-400 hover:text-emerald-600 hover:shadow-md rounded-xl" title="Edit">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="<?= base_url('teachers/' . $teacher['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Hapus data guru <?= addslashes($teacher['full_name']) ?>?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="p-2.5 bg-white border border-slate-100 text-slate-400 hover:text-rose-600 hover:shadow-md rounded-xl" title="Hapus">
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

    <!-- Pagination -->
    <div class="mb-12">
        <?= $pager->links('teachers', 'tailwind_pager') ?>
    </div>
<?= $this->endSection() ?>