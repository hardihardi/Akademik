<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6 lg:gap-8 animate-in fade-in slide-in-from-top-4 duration-700">
        <div>
            <div class="flex items-center gap-2 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 lg:mb-4">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase">MANAJEMEN SISWA</span>
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight">Daftar Peserta Didik</h1>
            <p class="text-slate-500 mt-2 lg:mt-4 font-medium text-xs lg:text-sm">Manajemen data siswa, NISN, dan penempatan kelas secara terpusat.</p>
        </div>
        
        <!-- Action Buttons -->
        <div class="grid grid-cols-2 sm:flex gap-2 lg:gap-3">
            <a href="<?= base_url('students/exportCsv') ?>" class="inline-flex items-center justify-center px-4 py-3 sm:py-3.5 lg:px-6 lg:py-4 rounded-xl lg:rounded-2xl bg-white text-emerald-600 border border-emerald-100 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-emerald-50 hover:border-emerald-200 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                CSV
            </a>
            <a href="<?= base_url('students/exportPdf') ?>" class="inline-flex items-center justify-center px-4 py-3 sm:py-3.5 lg:px-6 lg:py-4 rounded-xl lg:rounded-2xl bg-white text-rose-600 border border-rose-100 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-rose-50 hover:border-rose-200 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                PDF
            </a>
            <?php if(in_array(session()->get('role'), ['admin', 'kepsek'])): ?>
            <a href="<?= base_url('students/import') ?>" class="inline-flex items-center justify-center px-4 py-3 sm:py-3.5 lg:px-8 lg:py-4 rounded-xl lg:rounded-2xl bg-white text-indigo-600 border border-slate-200 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-slate-50 hover:border-slate-300 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                IMPORT
            </a>
            <a href="<?= base_url('students/new') ?>" class="inline-flex items-center justify-center px-4 py-3 sm:py-3.5 lg:px-8 lg:py-4 rounded-xl lg:rounded-2xl bg-indigo-600 text-white font-black text-[10px] lg:text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-1 active:scale-95 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                TAMBAH
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Role-Based Tabs (Guru/Wali Kelas Only) -->
    <?php if(in_array(session()->get('role'), ['guru', 'wali_kelas'])): ?>
    <div class="mb-8 flex bg-slate-100/50 p-1.5 rounded-2xl border border-slate-200 w-fit animate-in fade-in slide-in-from-left-4 duration-500">
        <a href="<?= base_url('students?type=homeroom') ?>" 
           class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.1em] transition-all duration-300 <?= ($filters['type'] == 'homeroom') ? 'bg-white text-indigo-600 shadow-md shadow-indigo-100/50' : 'text-slate-400 hover:text-slate-600' ?>">
            Siswa Wali Kelas
        </a>
        <a href="<?= base_url('students?type=subjects') ?>" 
           class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.1em] transition-all duration-300 <?= ($filters['type'] == 'subjects') ? 'bg-white text-indigo-600 shadow-md shadow-indigo-100/50' : 'text-slate-400 hover:text-slate-600' ?>">
            Siswa Mata Pelajaran
        </a>
    </div>
    <?php endif; ?>

    <!-- Import Error Reporting -->
    <?php if(session()->getFlashdata('import_errors')): ?>
    <div class="mb-8 p-6 bg-rose-50 border border-rose-100 rounded-[2rem] space-y-4 animate-in fade-in slide-in-from-top-2 duration-500">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-rose-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-rose-200">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <div>
                <h4 class="text-sm font-black text-rose-900 uppercase tracking-tight">Detail Kesalahan Import</h4>
                <p class="text-[10px] font-bold text-rose-400 uppercase tracking-widest mt-0.5">Beberapa baris gagal diproses</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
            <?php foreach(session()->getFlashdata('import_errors') as $error): ?>
                <div class="p-3 bg-white/50 rounded-xl border border-rose-100/50 flex items-start gap-2">
                    <svg class="w-3 h-3 text-rose-400 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight leading-tight"><?= $error ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Search & Filter Bar -->
    <form action="<?= base_url('students') ?>" method="get" class="mb-8 flex flex-col md:flex-row gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <div class="relative flex-1 md:min-w-[300px] group">
            <input 
                name="search"
                type="text" 
                value="<?= $filters['search'] ?? '' ?>"
                placeholder="Cari Nama/NIS/NISN..." 
                class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-white border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all duration-300 font-medium text-sm shadow-sm"
            >
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
        </div>

        <div class="grid grid-cols-2 md:flex items-center gap-3 md:gap-4 w-full md:w-auto">
            <div class="relative md:w-44">
                <select 
                    name="class_id"
                    onchange="this.form.submit()"
                    class="w-full pl-4 pr-10 py-3.5 rounded-2xl bg-white border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all duration-300 font-black text-[10px] uppercase tracking-widest appearance-none cursor-pointer shadow-sm text-slate-600"
                >
                    <option value="">Semua Kelas</option>
                    <?php foreach($classes as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= ($filters['class_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>

            <div class="relative md:w-40">
                <select 
                    name="status"
                    onchange="this.form.submit()"
                    class="w-full pl-4 pr-10 py-3.5 rounded-2xl bg-white border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all duration-300 font-black text-[10px] uppercase tracking-widest appearance-none cursor-pointer shadow-sm text-slate-600"
                >
                    <option value="">Status</option>
                    <option value="Aktif" <?= ($filters['status'] ?? '') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="Non-Aktif" <?= ($filters['status'] ?? '') == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                    <option value="Lulus" <?= ($filters['status'] ?? '') == 'Lulus' ? 'selected' : '' ?>>Lulus</option>
                    <option value="Keluar" <?= ($filters['status'] ?? '') == 'Keluar' ? 'selected' : '' ?>>Keluar</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>

            <?php if(!empty($filters['search']) || !empty($filters['class_id']) || !empty($filters['status'])): ?>
                <a href="<?= base_url('students') ?>" class="col-span-2 md:col-auto flex items-center justify-center h-[52px] w-full md:w-12 bg-rose-50 border border-rose-100 text-rose-500 rounded-2xl hover:bg-rose-500 hover:text-white transition-all shadow-sm" title="Reset Filter">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                    <span class="md:hidden ml-2 text-[10px] font-black uppercase tracking-widest">Reset Filter</span>
                </a>
            <?php endif; ?>
        </div>
    </form>

    <!-- Empty State -->
    <?php if(empty($students)): ?>
    <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden mb-10 animate-in fade-in slide-in-from-bottom-4 duration-1000">
        <div class="p-16 lg:p-24 text-center">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 lg:w-24 lg:h-24 bg-slate-50 rounded-2xl lg:rounded-[2.5rem] flex items-center justify-center text-slate-300 mb-6 border-2 border-dashed border-slate-200">
                    <svg class="w-8 h-8 lg:w-12 lg:h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <p class="text-slate-400 font-black tracking-tight text-base lg:text-lg">Tidak ada data siswa yang sesuai.</p>
                <p class="text-slate-400 text-[10px] font-medium uppercase tracking-widest mt-2">Coba sesuaikan kata kunci atau filter Anda</p>
                <?php if(!empty($filters['search']) || !empty($filters['class_id']) || !empty($filters['status'])): ?>
                    <a href="<?= base_url('students') ?>" class="mt-8 text-indigo-600 font-black text-[10px] uppercase tracking-widest hover:text-indigo-700 underline underline-offset-8">Reset Semua Filter</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php else: ?>

    <!-- ==================== MOBILE: Card Layout ==================== -->
    <div class="lg:hidden space-y-3 mb-10 animate-in fade-in slide-in-from-bottom-4 duration-1000">
        <?php foreach($students as $student): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
            <!-- Top Row: Avatar + Name + Status -->
            <div class="flex items-start gap-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-50 border-2 border-white shadow-lg shadow-indigo-100/20 overflow-hidden flex-shrink-0 flex items-center justify-center">
                    <?php if(!empty($student['photo'])): ?>
                        <img src="<?= get_photo_url($student['photo']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <span class="text-indigo-600 font-black text-sm uppercase"><?= substr($student['full_name'], 0, 1) ?></span>
                    <?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-slate-800 font-extrabold text-sm tracking-tight uppercase leading-tight truncate"><?= $student['full_name'] ?></p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 truncate">
                        <span class="text-indigo-500">Wali:</span> <?= $student['parent_name'] ?>
                    </p>
                </div>
                <?php if($student['status'] == 'Aktif'): ?>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black rounded-lg border border-emerald-100 uppercase tracking-wider flex-shrink-0">AKTIF</span>
                <?php else: ?>
                    <span class="px-2.5 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-lg border border-rose-100 uppercase tracking-wider flex-shrink-0"><?= $student['status'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Info Row: NIS, NISN, Kelas -->
            <div class="flex items-center gap-3 mt-3 pt-3 border-t border-slate-50">
                <div class="flex-1">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">NIS</p>
                    <p class="text-[11px] font-black text-slate-700 font-mono mt-0.5"><?= $student['nis'] ?></p>
                </div>
                <div class="flex-1">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">NISN</p>
                    <p class="text-[11px] font-black text-slate-700 font-mono mt-0.5"><?= $student['nisn'] ?: '-' ?></p>
                </div>
                <div class="flex-1">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Kelas</p>
                    <span class="inline-block px-2.5 py-0.5 bg-slate-100 text-slate-700 text-[9px] font-black rounded-md uppercase tracking-wider border border-slate-200/50 mt-0.5">
                        <?= $student['class_name'] ?? 'N/A' ?>
                    </span>
                </div>
            </div>

            <!-- Action Row -->
            <div class="flex items-center justify-end gap-2 mt-3 pt-3 border-t border-slate-50">
                <a href="<?= base_url('students/' . $student['id']) ?>" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors" title="Profil">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </a>
                <a href="<?= base_url('students/' . $student['id'] . '/edit') ?>" class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-colors" title="Edit">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </a>
                <form action="<?= base_url('students/' . $student['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Hapus data siswa?')">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="p-2 bg-rose-50 text-rose-500 rounded-lg hover:bg-rose-100 transition-colors" title="Hapus">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ==================== DESKTOP: Table Layout ==================== -->
    <div class="hidden lg:block bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden mb-10 animate-in fade-in slide-in-from-bottom-4 duration-1000">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/30">
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Siswa</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">NIS / NISN</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Kelas</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-center">Status</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach($students as $student): ?>
                <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                    <td class="px-8 py-7 border-b border-slate-50">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-50 border-2 border-white shadow-xl shadow-indigo-100/20 overflow-hidden flex-shrink-0 flex items-center justify-center transition-transform group-hover:scale-110">
                                <?php if(!empty($student['photo'])): ?>
                                    <img src="<?= get_photo_url($student['photo']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <span class="text-indigo-600 font-black text-xl uppercase"><?= substr($student['full_name'], 0, 1) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="min-w-0">
                                <p class="text-slate-800 font-extrabold text-base tracking-tight group-hover:text-indigo-600 transition-colors uppercase leading-none truncate"><?= $student['full_name'] ?></p>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2 flex items-center gap-1">
                                    <span class="text-indigo-600">WALI:</span>
                                    <span class="text-slate-400 truncate"><?= $student['parent_name'] ?></span>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-7 border-b border-slate-50">
                        <div class="space-y-1">
                            <p class="text-xs font-black text-slate-700 tracking-wider font-mono"><?= $student['nis'] ?></p>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest leading-none"><?= $student['nisn'] ?: '-' ?></p>
                        </div>
                    </td>
                    <td class="px-8 py-7 border-b border-slate-50">
                        <span class="px-4 py-1.5 bg-slate-100 text-slate-700 text-[10px] font-black rounded-lg uppercase tracking-widest border border-slate-200/50">
                            <?= $student['class_name'] ?? 'Unassigned' ?>
                        </span>
                    </td>
                    <td class="px-8 py-7 border-b border-slate-50 text-center">
                        <?php if($student['status'] == 'Aktif'): ?>
                            <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-lg border border-emerald-100 uppercase tracking-widest">AKTIF</span>
                        <?php else: ?>
                            <span class="px-4 py-1.5 bg-rose-50 text-rose-600 text-[10px] font-black rounded-lg border border-rose-100 uppercase tracking-widest"><?= $student['status'] ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-8 py-7 border-b border-slate-50 text-right">
                        <div class="flex items-center justify-end gap-3 opacity-60 group-hover:opacity-100 transition-opacity">
                            <a href="<?= base_url('students/' . $student['id']) ?>" class="p-3 bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 hover:shadow-lg hover:border-indigo-100 rounded-xl transition-all" title="Profil">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </a>
                            <a href="<?= base_url('students/' . $student['id'] . '/edit') ?>" class="p-3 bg-white border border-slate-100 text-slate-400 hover:text-emerald-600 hover:shadow-lg hover:border-emerald-100 rounded-xl transition-all" title="Edit">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                            <form action="<?= base_url('students/' . $student['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Hapus data siswa?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="p-3 bg-white border border-slate-100 text-slate-400 hover:text-rose-600 hover:shadow-lg hover:border-rose-100 rounded-xl transition-all" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Pagination Container -->
    <div class="mb-12 overflow-x-auto py-2">
        <?= $pager->links('students', 'tailwind_pager') ?>
    </div>
<?= $this->endSection() ?>