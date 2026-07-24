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
                        <span class="text-indigo-600">Mata Pelajaran</span>
                    </li>
                </ol>
            </nav>
            <h3 class="text-slate-800 text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight">Manajemen Mapel</h3>
            <p class="text-slate-500 mt-2 font-medium">Kelola daftar mata pelajaran kurikulum sekolah secara terpusat.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 lg:gap-3">
            <div class="flex gap-2">
                <a href="<?= base_url('subjects/exportCsv') ?>" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 lg:px-6 py-3 rounded-2xl bg-white text-emerald-600 border border-emerald-100 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-emerald-50 hover:border-emerald-200 transition-all duration-300 group uppercase">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    CSV
                </a>
                <a href="<?= base_url('subjects/exportPdf') ?>" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 lg:px-6 py-3 rounded-2xl bg-white text-rose-600 border border-rose-100 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-rose-50 hover:border-rose-200 transition-all duration-300 group uppercase">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    PDF
                </a>
            </div>
            <a href="<?= base_url('subjects/create') ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-indigo-600 text-white font-black text-sm tracking-widest uppercase hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200 transition-all duration-300 group">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                Tambah Mapel
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('message')):?>
        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 mb-8 flex items-center shadow-sm animate-pulse">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white mr-4 shadow-lg shadow-emerald-100">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
            </div>
            <div>
                <p class="text-xs font-black text-emerald-800 uppercase tracking-widest leading-none mb-1">Berhasil</p>
                <p class="text-sm font-bold text-emerald-600 leading-none"><?= session()->getFlashdata('message') ?></p>
            </div>
        </div>
    <?php endif;?>

    <div x-data="{ 
        search: '', 
        categoryFilter: '',
        matches(name, category, description) {
            const query = this.search.toLowerCase();
            const cat = this.categoryFilter;
            const matchesSearch = name.toLowerCase().includes(query) || description.toLowerCase().includes(query);
            const matchesCategory = cat === '' || category === cat;
            return matchesSearch && matchesCategory;
        }
    }">
        <!-- Search & Filter Bar -->
        <div class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="relative w-full md:w-96 group">
                <input 
                    x-model="search"
                    type="text" 
                    placeholder="Cari mata pelajaran..." 
                    class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-white border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all duration-300 font-medium text-sm shadow-sm"
                >
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <button x-show="search" @click="search = ''" class="absolute inset-y-0 right-4 flex items-center text-slate-300 hover:text-rose-500 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative flex-1 md:w-64">
                    <select 
                        x-model="categoryFilter"
                        class="w-full pl-5 pr-10 py-3.5 rounded-2xl bg-white border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all duration-300 font-black text-[10px] uppercase tracking-widest appearance-none cursor-pointer shadow-sm"
                    >
                        <option value="">Semua Kategori</option>
                        <option value="Wajib">Wajib</option>
                        <option value="Muatan Lokal">Muatan Lokal</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50/50 text-slate-400 font-bold text-[10px] uppercase tracking-widest">
                        <tr>
                            <th class="py-5 px-8" style="width: 80px;">No.</th>
                            <th class="py-5 px-8">Nama Mata Pelajaran</th>
                            <th class="py-5 px-8">Kategori</th>
                            <th class="py-5 px-8 text-center">KKM</th>
                            <th class="py-5 px-8">Deskripsi Ringkas</th>
                            <th class="py-5 px-8 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-slate-700">
                        <?php $i = 1; foreach($subjects as $subject): ?>
                        <tr 
                            x-show="matches('<?= addslashes($subject['name']) ?>', '<?= $subject['category'] ?? 'Wajib' ?>', '<?= addslashes($subject['description'] ?? '') ?>')"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="hover:bg-slate-50/50 transition-all duration-300 group"
                        >
                            <td class="py-5 px-8">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 text-[11px] font-black text-slate-400 border border-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                    <?= $i++ ?>.
                                </span>
                            </td>
                            <td class="py-5 px-8">
                                <div class="font-black text-slate-800 tracking-tight group-hover:text-indigo-700 transition-colors"><?= $subject['name'] ?></div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><?= $subject['category'] ?? 'Wajib' ?></div>
                            </td>
                            <td class="py-5 px-8">
                                <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest <?= ($subject['category'] ?? 'Wajib') == 'Wajib' ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-amber-50 text-amber-600 border border-amber-100' ?>">
                                    <?= $subject['category'] ?? 'Wajib' ?>
                                </span>
                            </td>
                            <td class="py-5 px-8 text-center">
                                <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 font-black text-sm border border-emerald-100"><?= $subject['kkm'] ?? 70 ?></span>
                            </td>
                            <td class="py-5 px-8">
                                <p class="text-slate-500 font-medium line-clamp-1"><?= $subject['description'] ?: 'Tidak ada deskripsi tersedia' ?></p>
                            </td>
                            <td class="py-5 px-8 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?= base_url('subjects/edit/' . $subject['id']) ?>" class="p-2.5 rounded-xl bg-slate-50 text-slate-400 hover:bg-amber-50 hover:text-amber-600 border border-slate-100 hover:border-amber-100 transition-all duration-300" title="Edit Data">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                    <form action="<?= base_url('subjects/delete/' . $subject['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Yakin ingin menghapus mata pelajaran ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="p-2.5 rounded-xl bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-600 border border-slate-100 hover:border-rose-100 transition-all duration-300" title="Hapus Data">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <!-- Empty State -->
                        <template x-if="search !== '' || categoryFilter !== ''">
                            <tr x-show="[...$el.closest('tbody').querySelectorAll('tr:not([style*=\'display: none\'])')].length === 0">
                                <td colspan="6" class="py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-300 mb-4 border border-slate-100 shadow-sm">
                                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                        </div>
                                        <h4 class="text-lg font-black text-slate-800 tracking-tight">Tidak Ada Hasil</h4>
                                        <p class="text-sm text-slate-400 font-medium mt-1">Maaf, kami tidak menemukan mapel yang sesuai dengan kriteria Anda.</p>
                                        <button @click="search = ''; categoryFilter = ''" class="mt-6 text-indigo-600 font-black text-[10px] uppercase tracking-widest hover:text-indigo-700 underline underline-offset-8">Reset Semua Filter</button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="mb-12">
        <?= $pager->links('subjects', 'tailwind_pager') ?>
    </div>
<?= $this->endSection() ?>
