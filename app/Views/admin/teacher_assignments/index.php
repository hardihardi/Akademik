<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6 lg:gap-8 animate-in fade-in slide-in-from-top-4 duration-700">
        <div>
            <div class="flex items-center gap-2 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 lg:mb-4">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase">PENUGASAN GURU</span>
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight">Daftar Penugasan Guru</h1>
            <p class="text-slate-500 mt-2 lg:mt-4 font-medium text-xs lg:text-sm">Manajemen pembagian mata pelajaran dan kelas untuk tenaga pendidik secara terpusat.</p>
        </div>
        
        <div>
            <a href="<?= base_url('teacher-assignments/new') ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 lg:px-8 lg:py-4 rounded-xl lg:rounded-2xl bg-indigo-600 text-white font-black text-[10px] lg:text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-1 active:scale-95 transition-all duration-300">
                <svg class="w-4 h-4 mr-2 lg:mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                TAMBAH PENUGASAN
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('message')): ?>
        <div class="mb-8 p-6 bg-emerald-50 border-2 border-emerald-100 rounded-[2rem] flex items-center justify-between gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-emerald-600 shadow-sm flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                </div>
                <div>
                    <p class="text-emerald-800 font-black text-sm tracking-tight">Berhasil</p>
                    <p class="text-emerald-600 text-xs font-bold"><?= session()->getFlashdata('message') ?></p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    <?php endif; ?>

    <div>
        <!-- Search & Filter Bar (Sticky on Mobile) -->
        <div class="sticky top-4 z-50 mb-8 lg:static lg:z-auto animate-in fade-in slide-in-from-top-4 duration-700">
            <form action="<?= base_url('teacher-assignments') ?>" method="get" x-data="{ showFilters: false }" class="p-2 bg-white/80 backdrop-blur-xl lg:bg-slate-100/50 rounded-[2rem] border border-slate-200/50 shadow-xl shadow-slate-200/20 lg:shadow-none lg:border-slate-200/50">
                <div class="flex flex-col lg:flex-row gap-2">
                    <!-- Search Input -->
                    <div class="relative flex-1 group">
                        <input 
                            name="search"
                            value="<?= esc($search) ?>"
                            type="text" 
                            placeholder="Cari Guru, Mapel, atau Kelas..." 
                            class="w-full pl-12 pr-10 py-4 rounded-2xl bg-white border border-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300 font-bold text-xs sm:text-sm shadow-sm"
                        >
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <div class="absolute inset-y-0 right-2 flex items-center gap-2">
                            <?php if($search || $classFilter || $yearFilter): ?>
                                <a href="<?= base_url('teacher-assignments') ?>" class="p-2 text-slate-300 hover:text-rose-500 transition-colors" title="Reset">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                                </a>
                            <?php endif; ?>
                            <!-- Mobile Filter Toggle -->
                            <button type="button" @click="showFilters = !showFilters" class="lg:hidden p-3 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-colors">
                                <svg class="w-5 h-5 transition-transform duration-300" :class="showFilters ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                            </button>
                            <!-- Submit Button -->
                            <button type="submit" class="hidden lg:flex p-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 active:scale-95">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Filter Options -->
                    <div 
                        x-show="showFilters || window.innerWidth >= 1024" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="grid grid-cols-2 lg:flex items-center gap-2 p-2 lg:p-0"
                    >
                        <div class="relative group">
                            <select 
                                name="class"
                                onchange="this.form.submit()"
                                class="w-full pl-4 pr-10 py-4 rounded-xl lg:rounded-2xl bg-slate-50 lg:bg-white border border-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300 font-black text-[10px] uppercase tracking-[0.15em] appearance-none cursor-pointer shadow-sm lg:w-48"
                            >
                                <option value="">SEMUA KELAS</option>
                                <?php foreach($classes as $c): ?>
                                    <option value="<?= $c['name'] ?>" <?= $classFilter == $c['name'] ? 'selected' : '' ?>><?= strtoupper($c['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>

                        <div class="relative group">
                            <select 
                                name="year"
                                onchange="this.form.submit()"
                                class="w-full pl-4 pr-10 py-4 rounded-xl lg:rounded-2xl bg-slate-50 lg:bg-white border border-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300 font-black text-[10px] uppercase tracking-[0.15em] appearance-none cursor-pointer shadow-sm lg:w-48"
                            >
                                <option value="">SEMUA TAHUN</option>
                                <?php foreach($academicYears as $ay): ?>
                                    <option value="<?= $ay['year'] ?>" <?= $yearFilter == $ay['year'] ? 'selected' : '' ?>><?= $ay['year'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>

                        <!-- Mobile Submit -->
                        <button type="submit" class="lg:hidden col-span-2 py-4 bg-indigo-600 text-white rounded-xl font-black text-[10px] tracking-widest uppercase shadow-lg shadow-indigo-100">
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- ==================== MOBILE: Card Layout ==================== -->
        <div class="lg:hidden space-y-3 mb-10 animate-in fade-in slide-in-from-bottom-4 duration-1000">
            <?php if(empty($assignments)): ?>
                <div class="bg-white rounded-[2rem] p-12 text-center border border-slate-100 shadow-sm flex flex-col items-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-300 mb-6 border border-slate-100 shadow-sm">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                    <p class="text-slate-400 font-black text-[10px] uppercase tracking-widest">Tidak ada data penugasan ditemukan</p>
                    <?php if($search || $classFilter || $yearFilter): ?>
                        <a href="<?= base_url('teacher-assignments') ?>" class="mt-6 text-indigo-600 font-black text-[10px] uppercase tracking-widest underline underline-offset-8 decoration-2 decoration-indigo-100 hover:text-indigo-700 transition-all">Atur Ulang Pencarian</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php foreach($assignments as $asgn): ?>
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <div class="flex-1 min-w-0">
                            <p class="text-slate-800 font-black text-[15px] tracking-tight uppercase leading-tight truncate"><?= $asgn['teacher_name'] ?></p>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 text-[9px] font-black rounded-lg border border-indigo-100 uppercase tracking-wider"><?= $asgn['subject_name'] ?></span>
                                <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[9px] font-black rounded-lg border border-slate-200 uppercase tracking-widest font-mono"><?= $asgn['class_name'] ?></span>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="px-2 py-1 bg-slate-100 rounded-lg border border-slate-200">
                                <p class="text-[9px] font-black text-slate-600 tracking-wider uppercase leading-none"><?= $asgn['academic_year'] ?></p>
                                <p class="text-[7px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1 leading-none"><?= $asgn['semester'] ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-5 border-t border-slate-50">
                        <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest">Management System</p>
                        <div class="flex items-center gap-2">
                            <a href="<?= base_url('teacher-assignments/' . $asgn['id'] . '/edit') ?>" class="w-10 h-10 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                            <form action="<?= base_url('teacher-assignments/' . $asgn['id'] ) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Hapus penugasan ini?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-rose-50 text-rose-500 rounded-xl border border-rose-100 transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- ==================== DESKTOP: Table Layout ==================== -->
        <div class="hidden lg:block bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden mb-12 animate-in fade-in slide-in-from-bottom-4 duration-1000">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/30">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Guru Tenaga Pendidik</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-center">Mata Pelajaran</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-center">Kelas</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-center">Tahun Ajaran</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if(empty($assignments)): ?>
                            <tr>
                                <td colspan="5" class="p-24 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-300 mb-6 border border-slate-100 shadow-sm transition-transform hover:scale-110">
                                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                        </div>
                                        <p class="text-slate-500 font-black tracking-widest uppercase text-xs">Data penugasan tidak ditemukan.</p>
                                        <?php if($search || $classFilter || $yearFilter): ?>
                                            <a href="<?= base_url('teacher-assignments') ?>" class="mt-6 text-indigo-600 font-black text-[10px] uppercase tracking-widest underline underline-offset-8 decoration-2 decoration-indigo-100 hover:text-indigo-700 transition-all">Reset Pencarian</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($assignments as $asgn): ?>
                                <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                                    <td class="px-8 py-7 border-b border-slate-50">
                                        <p class="text-slate-800 font-black text-base tracking-tight group-hover:text-indigo-600 transition-colors uppercase leading-none truncate"><?= $asgn['teacher_name'] ?></p>
                                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mt-2">Active Instructor</p>
                                    </td>
                                    <td class="px-8 py-7 border-b border-slate-50 text-center">
                                        <span class="px-4 py-2 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-xl border border-indigo-100 uppercase tracking-widest shadow-sm"><?= $asgn['subject_name'] ?></span>
                                    </td>
                                    <td class="px-8 py-7 border-b border-slate-50 text-center">
                                        <span class="px-4 py-2 bg-slate-100 text-slate-700 text-[10px] font-black rounded-xl border border-slate-200 uppercase tracking-widest font-mono shadow-sm"><?= $asgn['class_name'] ?></span>
                                    </td>
                                    <td class="px-8 py-7 border-b border-slate-50 text-center uppercase">
                                        <p class="text-[11px] font-black text-slate-800 tracking-wider font-mono"><?= $asgn['academic_year'] ?></p>
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1"><?= $asgn['semester'] ?></p>
                                    </td>
                                    <td class="px-8 py-7 border-b border-slate-50 text-right">
                                        <div class="flex items-center justify-end gap-3 opacity-40 group-hover:opacity-100 transition-opacity">
                                            <a href="<?= base_url('teacher-assignments/' . $asgn['id'] . '/edit') ?>" class="p-3.5 bg-white border border-slate-100 text-slate-400 hover:text-emerald-600 hover:shadow-xl hover:border-emerald-100 rounded-2xl transition-all hover:-translate-y-1" title="Edit Data">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            </a>
                                            <form action="<?= base_url('teacher-assignments/' . $asgn['id'] ) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Hapus penugasan ini?')">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="p-3.5 bg-white border border-slate-100 text-slate-400 hover:text-rose-600 hover:shadow-xl hover:border-rose-100 rounded-2xl transition-all hover:-translate-y-1" title="Hapus Data">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
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

        <!-- Pagination Section -->
        <div class="mb-12">
            <?= $pager->links('assignments', 'tailwind_pager') ?>
        </div>
    </div>
<?= $this->section('scripts') ?>
<script>
    // Any scripts needed for index
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
