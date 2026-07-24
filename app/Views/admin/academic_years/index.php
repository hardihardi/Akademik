<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-8">
        <div>
            <div class="flex items-center gap-2 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 lg:mb-4">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600">TAHUN AKADEMIK</span>
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight"><?= $title ?></h1>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Kelola periode pembelajaran aktif dan semester.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 lg:gap-3">
            <div class="flex gap-2">
                <a href="<?= base_url('academic-years/exportCsv') ?>" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 lg:px-6 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-white text-emerald-600 border border-emerald-100 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-emerald-50 hover:border-emerald-200 transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    CSV
                </a>
                <a href="<?= base_url('academic-years/exportPdf') ?>" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 lg:px-6 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-white text-rose-600 border border-rose-100 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-rose-50 hover:border-rose-200 transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    PDF
                </a>
            </div>
            <a href="<?= base_url('academic-years/create') ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-indigo-600 text-white font-black text-[10px] lg:text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-0.5 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 lg:mr-3 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                TAMBAH TAHUN
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('error')):?>
        <div class="mb-6 p-4 sm:p-5 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-rose-600 shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <p class="text-sm font-bold text-rose-800"><?= session()->getFlashdata('error') ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600 transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    <?php endif;?>

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
        semesterFilter: '',
        matches(year, semester) {
            const query = this.search.toLowerCase();
            const matchesSearch = year.toLowerCase().includes(query);
            const matchesSemester = this.semesterFilter === '' || semester === this.semesterFilter;
            return matchesSearch && matchesSemester;
        }
    }">
        <!-- Search & Filter Bar -->
        <div class="mb-8 flex flex-col md:flex-row gap-4 items-center justify-between animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="relative w-full md:w-96 group">
                <input 
                    x-model="search"
                    type="text" 
                    placeholder="Cari Tahun Akademik..." 
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
                <div class="relative flex-1 md:w-44">
                    <select 
                        x-model="semesterFilter"
                        class="w-full pl-5 pr-10 py-3.5 rounded-2xl bg-white border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all duration-300 font-black text-[10px] uppercase tracking-widest appearance-none cursor-pointer shadow-sm"
                    >
                        <option value="">Semua Semester</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-white rounded-2xl lg:rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-16">No</th>
                            <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Tahun Akademik</th>
                            <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Semester</th>
                            <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Status</th>
                            <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Kunci</th>
                            <th class="p-5 lg:p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-slate-700">
                        <?php if(empty($years)): ?>
                        <tr>
                            <td colspan="6" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-300 mb-4 border border-slate-100">
                                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                    <p class="text-slate-400 font-bold">Belum ada data tahun akademik.</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php $i = 1; foreach($years as $year): ?>
                            <tr 
                                x-show="matches('<?= addslashes($year['year']) ?>', '<?= $year['semester'] ?>')"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="group hover:bg-slate-50/50 transition-all duration-300"
                            >
                                <td class="p-5 lg:p-6 text-sm text-slate-400"><?= $i++ ?></td>
                                <td class="p-5 lg:p-6">
                                    <span class="text-slate-800 font-black tracking-tight group-hover:text-indigo-600 transition-colors uppercase"><?= $year['year'] ?></span>
                                </td>
                                <td class="p-5 lg:p-6">
                                    <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest <?= $year['semester'] == 'Ganjil' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-blue-50 text-blue-600 border border-blue-100' ?>"><?= $year['semester'] ?></span>
                                </td>
                                <td class="p-5 lg:p-6 text-center">
                                    <?php if($year['status'] == 'Active'): ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>AKTIF
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-slate-50 text-slate-400 border border-slate-100">INACTIVE</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-5 lg:p-6 text-center">
                                    <?php if($year['is_locked'] ?? 0): ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-100 shadow-sm shadow-rose-100/50">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            TERKUNCI
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm shadow-emerald-100/50">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                            TERBUKA
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-5 lg:p-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <?php if($year['status'] == 'Inactive'): ?>
                                        <a href="<?= base_url('academic-years/activate/' . $year['id']) ?>" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-emerald-600 hover:shadow-md rounded-xl transition-all duration-300 shadow-sm" title="Aktifkan" onclick="confirmDelete(event, 'Aktifkan tahun akademik ini?')">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                        </a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('academic-years/lock/' . $year['id']) ?>" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-amber-600 hover:shadow-md rounded-xl transition-all duration-300 shadow-sm" title="<?= ($year['is_locked'] ?? 0) ? 'Buka Kunci' : 'Kunci' ?>" onclick="confirmDelete(event, '<?= ($year['is_locked'] ?? 0) ? 'Buka kunci tahun akademik ini?' : 'Kunci tahun akademik ini? Data tidak dapat diubah.' ?>')">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                        </a>
                                        <?php if(!($year['is_locked'] ?? 0)): ?>
                                        <a href="<?= base_url('academic-years/edit/' . $year['id']) ?>" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-md rounded-xl transition-all duration-300 shadow-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="<?= base_url('academic-years/delete/' . $year['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Yakin hapus data ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-rose-600 hover:shadow-md rounded-xl transition-all duration-300 shadow-sm" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Empty State Search -->
                        <template x-if="search !== '' || semesterFilter !== ''">
                            <tr x-show="[...$el.closest('tbody').querySelectorAll('tr:not([style*=\'display: none\'])')].length === 0">
                                <td colspan="6" class="py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-300 mb-4 border border-slate-100 shadow-sm">
                                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                        </div>
                                        <h4 class="text-lg font-black text-slate-800 tracking-tight uppercase">Data Tidak Ditemukan</h4>
                                        <p class="text-sm text-slate-400 font-medium mt-1">Kami tidak menemukan tahun akademik yang Anda cari.</p>
                                        <button @click="search = ''; semesterFilter = ''" class="mt-6 text-indigo-600 font-black text-[10px] uppercase tracking-widest hover:text-indigo-700 underline underline-offset-8 transition-all">Reset Pencarian</button>
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
            <?php foreach($years as $year): ?>
            <div 
                x-show="matches('<?= addslashes($year['year']) ?>', '<?= $year['semester'] ?>')"
                class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4"
            >
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="font-black text-slate-800 tracking-tight uppercase"><?= $year['year'] ?></p>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            <span class="inline-flex px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-wider <?= $year['semester'] == 'Ganjil' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-blue-50 text-blue-600 border border-blue-100' ?>"><?= $year['semester'] ?></span>
                            <?php if($year['status'] == 'Active'): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    <span class="h-1 w-1 rounded-full bg-emerald-500 mr-1 animate-pulse"></span>AKTIF
                                </span>
                            <?php endif; ?>
                            <?php if($year['is_locked'] ?? 0): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100">TERKUNCI</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        <?php if($year['status'] == 'Inactive'): ?>
                        <a href="<?= base_url('academic-years/activate/' . $year['id']) ?>" class="p-2.5 bg-slate-50 text-emerald-500 rounded-xl shadow-sm border border-slate-100" onclick="confirmDelete(event, 'Aktifkan?')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        </a>
                        <?php endif; ?>
                        <a href="<?= base_url('academic-years/lock/' . $year['id']) ?>" class="p-2.5 bg-slate-50 text-amber-500 rounded-xl shadow-sm border border-slate-100" onclick="confirmDelete(event, '<?= ($year['is_locked'] ?? 0) ? 'Buka kunci?' : 'Kunci data ini?' ?>')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </a>
                        <?php if(!($year['is_locked'] ?? 0)): ?>
                        <a href="<?= base_url('academic-years/edit/' . $year['id']) ?>" class="p-2.5 bg-slate-50 text-slate-400 hover:text-indigo-600 rounded-xl transition-colors shadow-sm border border-slate-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form action="<?= base_url('academic-years/delete/' . $year['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Yakin hapus?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="p-2.5 bg-slate-50 text-slate-400 hover:text-rose-600 rounded-xl transition-colors shadow-sm border border-slate-100">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <template x-if="search !== '' || semesterFilter !== ''">
                <div x-show="[...$el.parentElement.querySelectorAll('div[x-show]:not([style*=\'display: none\'])')].length === 0" class="bg-white rounded-3xl border-2 border-dashed border-slate-100 p-12 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4 mx-auto border border-slate-100 shadow-sm">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <p class="text-slate-400 font-black text-sm uppercase">Pencarian Kosong</p>
                    <button @click="search = ''; semesterFilter = ''" class="mt-4 text-indigo-600 font-bold text-xs underline uppercase tracking-widest transition-all hover:text-indigo-700">Clear Search</button>
                </div>
            </template>
        </div>
    </div>

<?= $this->endSection() ?>
