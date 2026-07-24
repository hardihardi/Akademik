<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div x-data="{ 
        search: '', 
        roleFilter: '',
        statusFilter: '',
        showFilters: false,
        matchesNew(username, fullName, email, roles, active) {
            const query = this.search.toLowerCase();
            const matchesSearch = (username || '').toLowerCase().includes(query) || 
                                 (fullName || '').toLowerCase().includes(query) || 
                                 (email || '').toLowerCase().includes(query);
            const matchesRole = this.roleFilter === '' || (Array.isArray(roles) && roles.some(r => r.name === this.roleFilter));
            const status = active === '1' ? '1' : '0';
            const matchesStatus = this.statusFilter === '' || status === this.statusFilter;
            return matchesSearch && matchesRole && matchesStatus;
        }
    }">
        <!-- Header & Add Button -->
        <div class="mb-8 lg:mb-12 flex flex-col lg:flex-row lg:items-center justify-between gap-8 lg:gap-12 animate-in fade-in slide-in-from-top-4 duration-700">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 mb-4">
                    <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors">DASHBOARD</a>
                    <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                    <span class="text-indigo-600">PENGGUNA</span>
                </div>
                <h1 class="text-3xl lg:text-5xl font-black text-slate-800 tracking-tight leading-tight uppercase">Manajemen Pengguna</h1>
                <p class="text-slate-500 mt-3 font-medium text-xs lg:text-sm leading-relaxed max-w-2xl">
                    Kelola akun, hak akses, dan status pengguna dalam satu sistem terpadu yang aman dan efisien.
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3 lg:gap-4 shrink-0">
                <div class="grid grid-cols-2 sm:flex gap-3">
                    <a href="<?= base_url('users/exportCsv') ?>" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-white text-emerald-600 border border-slate-200 font-extrabold text-[10px] tracking-widest shadow-sm hover:bg-emerald-50 hover:border-emerald-200 transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        EXPORT CSV
                    </a>
                    <a href="<?= base_url('users/exportPdf') ?>" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-white text-rose-600 border border-slate-200 font-extrabold text-[10px] tracking-widest shadow-sm hover:bg-rose-50 hover:border-rose-200 transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        EXPORT PDF
                    </a>
                </div>
                <a href="<?= base_url('users/create') ?>" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-indigo-600 text-white font-black text-[10px] tracking-widest shadow-xl shadow-indigo-900/10 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all duration-300 uppercase">
                    <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                    TAMBAH PENGGUNA
                </a>
            </div>
        </div>

        <!-- Search & Filter Bar (Sticky on Mobile) -->
        <div class="sticky top-4 z-50 mb-8 lg:static lg:z-auto animate-in fade-in slide-in-from-top-4 duration-700">
            <div class="p-2 bg-white/80 backdrop-blur-xl lg:bg-slate-100/50 rounded-[2rem] border border-slate-200/50 shadow-xl shadow-slate-200/20 lg:shadow-none lg:border-slate-200/50">
                <div class="flex flex-col lg:flex-row gap-2">
                    <!-- Search Input -->
                    <div class="relative flex-1 group">
                        <input 
                            x-model="search"
                            type="text" 
                            placeholder="Cari Username, Nama, atau Email..." 
                            class="w-full pl-12 pr-10 py-4 rounded-2xl bg-white border border-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300 font-bold text-xs sm:text-sm shadow-sm"
                        >
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <div class="absolute inset-y-0 right-2 flex items-center gap-2">
                            <button x-show="search" @click="search = ''" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                            <!-- Mobile Filter Toggle -->
                            <button @click="showFilters = !showFilters" class="lg:hidden p-3 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-colors">
                                <svg class="w-5 h-5 transition-transform duration-300" :class="showFilters ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
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
                                x-model="roleFilter"
                                class="w-full pl-4 pr-10 py-4 rounded-xl lg:rounded-2xl bg-slate-50 lg:bg-white border border-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300 font-black text-[10px] uppercase tracking-[0.15em] appearance-none cursor-pointer shadow-sm lg:w-48"
                            >
                                <option value="">SEMUA ROLE</option>
                                <?php foreach($roles as $role): ?>
                                    <option value="<?= $role['name'] ?>"><?= strtoupper($role['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>

                        <div class="relative group">
                            <select 
                                x-model="statusFilter"
                                class="w-full pl-4 pr-10 py-4 rounded-xl lg:rounded-2xl bg-slate-50 lg:bg-white border border-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300 font-black text-[10px] uppercase tracking-[0.15em] appearance-none cursor-pointer shadow-sm lg:w-48"
                            >
                                <option value="">SEMUA STATUS</option>
                                <option value="1">AKTIF</option>
                                <option value="0">NON-AKTIF</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== MOBILE: Card Layout ==================== -->
        <div class="lg:hidden space-y-4 mb-10 animate-in fade-in slide-in-from-bottom-4 duration-1000">
            <?php if(empty($users)): ?>
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm">
                    <p class="text-slate-400 font-black text-[10px] uppercase tracking-widest">Tidak ada data pengguna</p>
                </div>
            <?php else: ?>
                <?php foreach($users as $user): ?>
                    <div 
                        x-show="matchesNew('<?= addslashes($user['username']) ?>', '<?= addslashes($user['full_name'] ?? '') ?>', '<?= addslashes($user['email']) ?>', <?= htmlspecialchars(json_encode($user['roles'])) ?>, '<?= $user['active'] ?>')"
                        class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-6 overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-500"
                    >
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <div class="relative flex-shrink-0">
                                    <?php if(!empty($user['photo_url'])): ?>
                                        <img src="<?= $user['photo_url'] ?>" class="h-14 w-14 rounded-2xl object-cover ring-2 ring-white shadow-lg">
                                    <?php else: ?>
                                        <div class="h-14 w-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-700 font-black text-xl italic ring-2 ring-white shadow-lg">
                                            <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="absolute -bottom-1 -right-1 h-5 w-5 rounded-full border-2 border-white shadow-sm ring-1 <?= $user['active'] ? 'bg-emerald-500 ring-emerald-100' : 'bg-slate-300 ring-slate-100' ?>"></div>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-slate-800 font-black text-[15px] tracking-tight truncate uppercase leading-tight"><?= $user['full_name'] ?: $user['username'] ?></h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[8px] font-black rounded-md uppercase tracking-widest leading-none">@<?= $user['username'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:text-indigo-600 rounded-xl transition-colors border border-slate-100">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100/50">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 leading-none">Information Detail</p>
                                <div class="flex items-center gap-2 text-slate-600 mb-2.5">
                                    <svg class="w-3.5 h-3.5 opacity-40 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    <span class="text-xs font-bold truncate tracking-tight"><?= $user['email'] ?></span>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <?php if(!empty($user['roles'])): ?>
                                        <?php foreach($user['roles'] as $role): ?>
                                            <span class="px-2.5 py-1 bg-white text-indigo-600 text-[9px] font-black rounded-lg border border-indigo-50 uppercase tracking-wider font-mono shadow-sm italic"><?= $role['name'] ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">STATUS:</span>
                                    <span class="text-[10px] font-black <?= $user['active'] ? 'text-emerald-500' : 'text-slate-400' ?> uppercase tracking-[0.1em]"><?= $user['active'] ? 'AKTIF' : 'NON-AKTIF' ?></span>
                                </div>
                                <form action="<?= base_url('users/delete/' . $user['id'] ) ?>" method="post" onsubmit="confirmDelete(event, 'Hapus akun pengguna ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="text-[10px] font-extrabold text-rose-400 hover:text-rose-600 uppercase tracking-widest underline underline-offset-4 decoration-2 decoration-rose-100 transition-all">
                                        Hapus Akun
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
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Nama Lengkap</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Username</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Email</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Roles</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-center">Status</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if(empty($users)): ?>
                            <tr>
                                <td colspan="6" class="p-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-300 mb-4 border border-slate-100 shadow-sm">
                                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        </div>
                                        <p class="text-slate-400 font-bold tracking-tight uppercase text-[10px] tracking-widest leading-none">Belum ada data pengguna.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($users as $user): ?>
                                <tr 
                                    x-show="matchesNew('<?= addslashes($user['username']) ?>', '<?= addslashes($user['full_name'] ?? '') ?>', '<?= addslashes($user['email']) ?>', <?= htmlspecialchars(json_encode($user['roles'])) ?>, '<?= $user['active'] ?>')"
                                    class="group hover:bg-slate-50/50 transition-all duration-300"
                                >
                                    <td class="px-8 py-7 border-b border-slate-50">
                                        <div class="flex items-center gap-5">
                                            <div class="relative flex-shrink-0">
                                                <?php if(!empty($user['photo_url'])): ?>
                                                    <img src="<?= $user['photo_url'] ?>" class="h-14 w-14 rounded-2xl object-cover border-2 border-white shadow-xl shadow-indigo-100/20 ring-1 ring-slate-100 transition-transform group-hover:scale-110">
                                                <?php else: ?>
                                                    <div class="h-14 w-14 rounded-2xl bg-indigo-50 border-2 border-white shadow-xl shadow-indigo-100/20 ring-1 ring-indigo-100 flex items-center justify-center text-indigo-700 font-black text-xl italic transition-transform group-hover:scale-110">
                                                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($user['active']): ?>
                                                    <div class="absolute -bottom-1 -right-1 h-5 w-5 rounded-full bg-emerald-500 border-2 border-white shadow-sm ring-1 ring-emerald-100"></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-slate-800 font-extrabold text-base tracking-tight group-hover:text-indigo-600 transition-colors uppercase leading-none truncate"><?= $user['full_name'] ?: ($user['username']) ?></p>
                                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-2 leading-none">ID: <?= $user['id'] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-7 border-b border-slate-50">
                                        <div class="inline-flex items-center px-3 py-1 bg-slate-50 text-slate-600 rounded-lg border border-slate-100">
                                            <span class="text-xs font-black tracking-widest uppercase font-mono"><?= $user['username'] ?></span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-7 border-b border-slate-50">
                                        <p class="text-sm font-bold text-slate-600 tracking-tight leading-none"><?= $user['email'] ?></p>
                                    </td>
                                    <td class="px-8 py-7 border-b border-slate-50">
                                        <div class="flex flex-wrap gap-1.5">
                                            <?php if(!empty($user['roles'])): ?>
                                                <?php foreach($user['roles'] as $role): ?>
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.1em] bg-indigo-50 text-indigo-700 border border-indigo-100 font-mono">
                                                        <?= $role['name'] ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-8 py-7 border-b border-slate-50 text-center">
                                        <?php if($user['active']): ?>
                                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-[0.15em] bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm">
                                                AKTIF
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-[0.15em] bg-rose-50 text-rose-600 border border-rose-100 shadow-sm opacity-60">
                                                NON-AKTIF
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-8 py-7 border-b border-slate-50 text-right">
                                        <div class="flex items-center justify-end gap-3 opacity-60 group-hover:opacity-100 transition-opacity">
                                            <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="p-3 bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 hover:shadow-lg hover:border-indigo-100 rounded-xl transition-all" title="Edit Pengguna">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            </a>
                                            <form action="<?= base_url('users/delete/' . $user['id'] ) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Hapus akun pengguna?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="p-3 bg-white border border-slate-100 text-slate-400 hover:text-rose-600 hover:shadow-lg hover:border-rose-100 rounded-xl transition-all" title="Hapus Pengguna">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <!-- Empty State Search -->
                            <template x-if="search !== '' || roleFilter !== '' || statusFilter !== ''">
                                <tr x-show="[...$el.closest('tbody').querySelectorAll('tr:not([style*=\'display: none\'])')].length === 0">
                                    <td colspan="6" class="py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-300 mb-4 border border-slate-100 shadow-sm">
                                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                            </div>
                                            <h4 class="text-lg font-black text-slate-800 tracking-tight uppercase">Pengguna Tidak Ditemukan</h4>
                                            <p class="text-sm text-slate-400 font-medium mt-1">Maaf, kami tidak menemukan akun yang sesuai dengan kriteria Anda.</p>
                                            <button @click="search = ''; roleFilter = ''; statusFilter = ''" class="mt-6 text-indigo-600 font-black text-[10px] uppercase tracking-widest hover:text-indigo-700 underline underline-offset-8 transition-all">Atur Ulang Pencarian</button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="mb-12">
        <?= $pager->links('users', 'tailwind_pager') ?>
    </div>
<?= $this->endSection() ?>
