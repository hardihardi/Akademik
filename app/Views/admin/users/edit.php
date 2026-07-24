<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="max-w-4xl mx-auto">
        <!-- Header & Back Button -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6 uppercase tracking-widest animate-in fade-in slide-in-from-top-4 duration-500">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[10px] font-black">
                        <li class="inline-flex items-center">
                            <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Dashboard</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="<?= base_url('users') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Pengguna</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-indigo-600">Edit Profil</span>
                        </li>
                    </ol>
                </nav>
                <h3 class="text-slate-800 text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight normal-case"><?= $title ?></h3>
                <p class="text-slate-500 mt-2 font-medium normal-case">Perbarui informasi akun untuk <strong><?= esc($user['username']) ?></strong>.</p>
            </div>
            <a href="<?= base_url('users') ?>" class="inline-flex items-center justify-center px-6 py-3.5 rounded-2xl bg-white text-slate-500 border border-slate-200 font-black text-xs tracking-widest hover:bg-slate-50 transition-all duration-300 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                KEMBALI
            </a>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden mb-12 animate-in fade-in slide-in-from-bottom-6 duration-700">
            <div class="p-8 sm:p-12 lg:p-16">
                
                <?php if ($validation->getErrors()): ?>
                    <div class="mb-10 p-6 bg-rose-50 border border-rose-100 rounded-3xl flex items-start gap-4 animate-shake">
                        <div class="w-10 h-10 bg-rose-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-rose-200 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-rose-800 uppercase tracking-widest mb-1">Terjadi Kesalahan</h4>
                            <ul class="text-rose-600 text-xs font-bold space-y-1">
                                <?php foreach ($validation->getErrors() as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                <?php endif ?>

                <form action="<?= base_url('users/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Photo Upload Section -->
                    <div class="flex flex-col items-center mb-16">
                        <div class="relative group">
                            <div id="photo-preview" class="w-32 h-32 rounded-[2.5rem] bg-slate-50 border-2 border-indigo-500 flex items-center justify-center overflow-hidden transition-all duration-500 group-hover:border-indigo-400 group-hover:bg-indigo-50/30 shadow-xl shadow-indigo-100 ring-4 ring-white">
                                <img src="<?= get_photo_url($user['photo']) ?>" class="object-cover w-full h-full animate-in zoom-in-95 duration-500">
                            </div>
                            <label class="absolute -bottom-2 -right-2 p-3 bg-indigo-600 text-white rounded-2xl cursor-pointer hover:bg-indigo-700 hover:scale-110 transition-all duration-300 shadow-xl shadow-indigo-200 border-4 border-white">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                <input type="file" name="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>
                        <div class="mt-4 text-center">
                            <h5 class="text-xs font-black text-slate-700 uppercase tracking-widest">Foto Profil</h5>
                            <p class="text-[10px] text-slate-400 font-bold mt-1">Ganti dengan PNG, JPG atau WEBP</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                        <!-- Left Column: Basic Info -->
                        <div class="space-y-8">
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-indigo-600 transition-colors">Nama Pengguna (Username)</label>
                                <div class="relative">
                                    <input type="text" name="username" value="<?= esc($user['username']) ?>" required
                                           class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-500 transition-all duration-300 font-bold text-slate-700 shadow-inner">
                                    <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-indigo-600 transition-colors">Nama Lengkap</label>
                                <div class="relative">
                                    <input type="text" name="full_name" value="<?= old('full_name', $user['full_name']) ?>" required
                                           class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-500 transition-all duration-300 font-bold text-slate-700 shadow-inner">
                                    <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-indigo-600 transition-colors">Alamat Email</label>
                                <div class="relative">
                                    <input type="email" name="email" value="<?= esc($user['email']) ?>" required
                                           class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-500 transition-all duration-300 font-bold text-slate-700 shadow-inner">
                                    <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-indigo-600 transition-colors">Ubah Kata Sandi (Opsional)</label>
                                <div class="relative">
                                    <input type="password" name="password"
                                           class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-500 transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 shadow-inner"
                                           placeholder="••••••••">
                                    <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    </div>
                                </div>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mt-2 ml-1">* Kosongkan jika tidak ingin mengubah kata sandi.</p>
                            </div>
                        </div>

                        <!-- Right Column: Roles & Status -->
                        <div class="space-y-8">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-5 ml-1">Perbarui Peran (Roles)</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-6 bg-slate-50 rounded-3xl border border-slate-100 shadow-inner max-h-[280px] overflow-y-auto custom-scrollbar">
                                    <?php foreach($roles as $role): ?>
                                        <label class="relative flex items-center p-3 rounded-xl bg-white border border-slate-100 cursor-pointer hover:border-indigo-200 hover:shadow-sm transition-all group/role">
                                            <input type="checkbox" name="roles[]" value="<?= $role['id'] ?>" class="w-5 h-5 text-indigo-600 bg-slate-100 border-none rounded-lg focus:ring-indigo-500/20 transition-all" <?= in_array($role['id'], $userRoles) ? 'checked' : '' ?>>
                                            <span class="ml-3 text-xs font-black text-slate-700 uppercase tracking-wider group-hover/role:text-indigo-600 transition-colors"><?= esc($role['name']) ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 p-6 bg-slate-50 rounded-3xl border border-slate-100 shadow-inner">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="active" value="1" class="sr-only peer" <?= $user['active'] ? 'checked' : '' ?>>
                                    <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500"></div>
                                </label>
                                <div>
                                    <span class="block text-xs font-black text-slate-700 uppercase tracking-widest">Status Akun Aktif</span>
                                    <span class="block text-[9px] font-bold text-emerald-600 uppercase tracking-widest mt-0.5"><?= $user['active'] ? 'Pengguna dapat masuk ke sistem' : 'Akses pengguna ditangguhkan' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-16 pt-10 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-end gap-4">
                        <button type="button" onclick="history.back()" class="w-full sm:w-auto px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-[0.2em] hover:text-slate-600 transition-all">Batalkan Perubahan</button>
                        <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 hover:shadow-indigo-200 transition-all">Perbarui Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('photo-preview');
                    preview.innerHTML = `<img src="${e.target.result}" class="object-cover w-full h-full animate-in zoom-in-95 duration-500">`;
                    preview.classList.add('border-solid', 'border-indigo-500', 'shadow-xl');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }
        .animate-shake { animation: shake 0.4s ease-in-out 0s 2; }
    </style>
<?= $this->endSection() ?>
