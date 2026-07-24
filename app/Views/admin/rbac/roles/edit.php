<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="max-w-4xl mx-auto">
        <!-- Header & Back Button -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6 uppercase tracking-widest animate-in fade-in slide-in-from-top-4 duration-500">
            <div>
            <nav class="flex mb-3 lg:mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em]">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase font-black">Dashboard</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="<?= base_url('roles') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase font-black">Kelola Role</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 uppercase font-black">Edit Role</span>
                    </li>
                </ol>
            </nav>
            <div class="flex items-center gap-4">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase"><?= $title ?></h1>
                <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-xl border border-indigo-100 uppercase tracking-widest mt-2 shrink-0">ID: #<?= $role['id'] ?></span>
            </div>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Perbarui definisi peran dan modifikasi batasan hak akses sistem.</p>
        </div>
        <div>
            <a href="<?= base_url('roles') ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 text-slate-500 font-black text-[10px] tracking-widest hover:bg-slate-200 transition-all uppercase">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                KEMBALI
            </a>
        </div>
    </div>

    <div class="max-w-4xl pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <?php if (session()->has('errors')): ?>
            <div class="mb-6 p-6 bg-rose-50 border border-rose-100 rounded-3xl animate-shake">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span class="text-xs font-black text-rose-600 uppercase tracking-widest">Terjadi Kesalahan Validasi</span>
                </div>
                <ul class="space-y-1">
                    <?php foreach (session('errors') as $error): ?>
                        <li class="text-[11px] font-bold text-rose-500 uppercase tracking-tight flex items-center gap-2">
                            <span class="w-1 h-1 bg-rose-400 rounded-full shrink-0"></span>
                            <?= $error ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form action="<?= base_url('roles/update/' . $role['id']) ?>" method="post" class="space-y-6 lg:space-y-8">
            <?= csrf_field() ?>

            <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 lg:p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <!-- Name -->
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="name">
                                Nama Role <span class="text-rose-500">*</span>
                            </label>
                            <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="name" name="name" type="text" value="<?= $role['name'] ?>" required>
                        </div>

                        <!-- Description -->
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="description">
                                Deskripsi Singkat
                            </label>
                            <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="description" name="description" type="text" value="<?= $role['description'] ?>">
                        </div>
                    </div>

                    <!-- Permissions -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Konfigurasi Hak Akses (Permissions)</label>
                        <div class="p-6 lg:p-8 bg-slate-50 rounded-2xl lg:rounded-[2rem] border border-slate-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                <?php foreach($permissions as $perm): ?>
                                    <label class="flex items-center p-4 bg-white rounded-xl border border-slate-100 hover:border-indigo-200 hover:shadow-sm transition-all cursor-pointer group">
                                        <div class="relative flex items-center justify-center">
                                            <input type="checkbox" name="permissions[]" value="<?= $perm['id'] ?>" id="perm_<?= $perm['id'] ?>" class="peer w-5 h-5 opacity-0 absolute cursor-pointer" <?= in_array($perm['id'], $rolePermissions) ? 'checked' : '' ?>>
                                            <div class="w-5 h-5 border-2 border-slate-200 rounded-md peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all flex items-center justify-center text-white">
                                                <svg class="w-3.5 h-3.5 opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7" /></svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-xs font-black text-slate-700 uppercase group-hover:text-indigo-600 transition-colors uppercase"><?= $perm['name'] ?></p>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter uppercase"><?= $perm['description'] ?></p>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Panel -->
                <div class="p-6 lg:p-8 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-12 rounded-xl lg:rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-100 hover:shadow-indigo-200 hover:-translate-y-1 active:scale-95 flex items-center justify-center text-[10px] lg:text-xs tracking-[0.2em] uppercase" type="submit">
                        <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        SIMPAN PERUBAHAN
                    </button>
                </div>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>
