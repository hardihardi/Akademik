<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-8">
        <div>
            <div class="flex items-center gap-2 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 lg:mb-4">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600">DATA KELAS</span>
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight"><?= $title ?></h1>
            <?php if(isset($activeYear)): ?>
            <p class="text-indigo-600 font-bold text-xs mt-1 uppercase tracking-widest">Tahun Akademik Aktif: <?= $activeYear['year'] ?> (<?= $activeYear['semester'] == 1 ? 'Ganjil' : 'Genap' ?>)</p>
            <?php endif; ?>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Kelola data kelas dan kapasitas ruangan.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 lg:gap-3">
            <div class="flex gap-2">
                <a href="<?= base_url('classes/exportCsv') ?>" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 lg:px-6 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-white text-emerald-600 border border-emerald-100 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-emerald-50 hover:border-emerald-200 transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    CSV
                </a>
                <a href="<?= base_url('classes/exportPdf') ?>" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 lg:px-6 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-white text-rose-600 border border-rose-100 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-rose-50 hover:border-rose-200 transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    PDF
                </a>
            </div>
            <a href="<?= base_url('classes/new') ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-indigo-600 text-white font-black text-[10px] lg:text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-0.5 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 lg:mr-3 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                TAMBAH KELAS
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('message')):?>
        <div class="mb-6 p-4 sm:p-5 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-600 shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                </div>
                <p class="text-sm font-bold text-emerald-800"><?= session()->getFlashdata('message') ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    <?php endif;?>

    <div x-data="{ 
        search: '', 
        matches(name, year) {
            const query = this.search.toLowerCase();
            return name.toLowerCase().includes(query) || year.toLowerCase().includes(query);
        }
    }">
        <!-- Search Bar -->
        <div class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="relative w-full md:w-96 group">
                <input 
                    x-model="search"
                    type="text" 
                    placeholder="Cari Nama Kelas atau Tahun Ajaran..." 
                    class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-white border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all duration-300 font-medium text-sm shadow-sm"
                >
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <button x-show="search" @click="search = ''" class="absolute inset-y-0 right-4 flex items-center text-slate-300 hover:text-rose-500 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-white rounded-2xl lg:rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-16">No</th>
                            <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Nama Kelas</th>
                            <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Tahun Ajaran</th>
                            <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Kapasitas</th>
                            <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if(empty($classes)): ?>
                        <tr>
                            <td colspan="5" class="p-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    </div>
                                    <p class="text-slate-400 font-bold text-sm">Belum ada data kelas.</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php $i = 1; foreach($classes as $class): ?>
                            <tr 
                                x-show="matches('<?= addslashes($class['name']) ?>', '<?= addslashes($class['academic_year']) ?>')"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="group hover:bg-slate-50/50 transition-all duration-300"
                            >
                                <td class="p-5 lg:p-6 text-sm text-slate-400"><?= $i++ ?></td>
                                <td class="p-5 lg:p-6">
                                    <span class="text-slate-800 font-black tracking-tight group-hover:text-indigo-600 transition-colors uppercase"><?= $class['name'] ?></span>
                                </td>
                                <td class="p-5 lg:p-6">
                                    <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-600 border border-indigo-100"><?= $class['academic_year'] ?></span>
                                </td>
                                <td class="p-5 lg:p-6">
                                    <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100"><?= $class['capacity'] ?></span>
                                </td>
                                <td class="p-5 lg:p-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="<?= base_url('classes/' . $class['id'] . '/edit') ?>" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-emerald-600 hover:shadow-md rounded-xl transition-all duration-300" title="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="<?= base_url('classes/' . $class['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Yakin hapus data ini?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-rose-600 hover:shadow-md rounded-xl transition-all duration-300" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Empty State Search -->
                        <template x-if="search !== ''">
                            <tr x-show="[...$el.closest('tbody').querySelectorAll('tr:not([style*=\'display: none\'])')].length === 0">
                                <td colspan="5" class="py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4 border border-slate-100">
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                        </div>
                                        <p class="text-slate-500 font-black text-sm uppercase tracking-tight">Tidak Ada Hasil</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Maaf, kata kunci ' <span x-text="search" class="text-indigo-600"></span> ' tidak ditemukan.</p>
                                        <button @click="search = ''" class="mt-6 text-indigo-600 font-black text-[10px] uppercase tracking-widest hover:text-indigo-700 underline underline-offset-8 transition-all">Clear Search</button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-3 mb-10">
            <?php if(empty($classes)): ?>
                <div class="bg-white rounded-2xl border border-slate-100 p-8 text-center">
                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-3 mx-auto">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <p class="text-slate-400 font-bold text-sm">Belum ada data kelas.</p>
                </div>
            <?php else: ?>
                <?php $i = 1; foreach($classes as $class): ?>
                <div 
                    x-show="matches('<?= addslashes($class['name']) ?>', '<?= addslashes($class['academic_year']) ?>')"
                    class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-sm flex-shrink-0 breadcrumb-i"><?= $i++ ?></div>
                            <div>
                                <p class="font-black text-slate-800 tracking-tight uppercase"><?= $class['name'] ?></p>
                                <span class="inline-flex mt-1 px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-600 border border-indigo-100"><?= $class['academic_year'] ?></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <a href="<?= base_url('classes/' . $class['id'] . '/edit') ?>" class="p-2.5 bg-slate-50 text-slate-400 hover:text-emerald-600 rounded-xl transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                            <form action="<?= base_url('classes/' . $class['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Yakin hapus data ini?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="p-2.5 bg-slate-50 text-slate-400 hover:text-rose-600 rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <template x-if="search !== ''">
                    <div x-show="[...$el.parentElement.querySelectorAll('div[x-show]:not([style*=\'display: none\'])')].length === 0" class="bg-white rounded-2xl border-2 border-dashed border-slate-100 p-12 text-center">
                        <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-3 mx-auto">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <p class="text-slate-400 font-black text-sm uppercase">Pencarian Kosong</p>
                        <button @click="search = ''" class="mt-4 text-indigo-600 font-bold text-xs underline">Clear</button>
                    </div>
                </template>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mb-12">
        <?= $pager->links('classes', 'tailwind_pager') ?>
    </div>
<?= $this->endSection() ?>
