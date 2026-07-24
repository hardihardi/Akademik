<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-8 animate-in fade-in slide-in-from-top-4 duration-700">
        <div>
            <nav class="flex mb-3 lg:mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em]">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase font-black">Dashboard</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="<?= base_url('teachers') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase font-black">Manajemen Guru</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 uppercase font-black">Tambah Guru</span>
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase"><?= $title ?></h1>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Daftarkan tenaga pendidik baru ke dalam sistem akademik.</p>
        </div>
        <div>
            <a href="<?= base_url('teachers') ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 text-slate-500 font-black text-[10px] tracking-widest hover:bg-slate-200 transition-all uppercase">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                KEMBALI
            </a>
        </div>
    </div>

    <!-- Error/Validation -->
    <?php if(session()->has('errors')): ?>
        <div class="mb-8 p-6 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-4 animate-in slide-in-from-right duration-500 shadow-sm shadow-rose-100/50">
            <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <div>
                <p class="text-xs font-black text-rose-800 uppercase tracking-tight mb-2 tracking-widest">Terjadi Kesalahan Validasi:</p>
                <ul class="text-[11px] font-semibold text-rose-600 space-y-1 list-disc list-inside uppercase tracking-tighter">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <form action="<?= base_url('teachers') ?>" method="post" enctype="multipart/form-data" class="space-y-6 lg:space-y-8">
            <?= csrf_field() ?>

            <!-- Identity Section -->
            <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 lg:p-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                    <div>
                        <h4 class="font-black text-slate-800 tracking-tight uppercase">Data Identitas</h4>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Informasi Dasar & Foto Guru</p>
                    </div>
                </div>

                <div class="p-6 lg:p-10">
                    <div class="flex flex-col lg:flex-row gap-10 lg:gap-14">
                        <!-- Photo Side -->
                        <div class="flex-shrink-0 flex flex-col items-center">
                            <div class="relative group">
                                <div class="w-40 h-40 lg:w-48 lg:h-48 rounded-2xl lg:rounded-[2rem] bg-slate-100 border-4 border-white shadow-inner flex items-center justify-center overflow-hidden" id="photo-preview">
                                    <div class="w-full h-full bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-slate-400">
                                        <svg class="w-16 h-16 lg:w-20 lg:h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                </div>
                                <label class="absolute -bottom-3 -right-3 w-12 h-12 lg:w-14 lg:h-14 bg-indigo-600 text-white rounded-xl lg:rounded-2xl border-4 border-white shadow-lg flex items-center justify-center cursor-pointer hover:bg-indigo-700 hover:scale-110 transition-all duration-300 group">
                                    <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <input type="file" name="teacher_photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                                </label>
                            </div>
                            <p class="mt-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center leading-relaxed">Format Jpeg/Png<br>Max 1MB</p>
                        </div>

                        <!-- Fields Side -->
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="nip">
                                    NIP <span class="text-rose-500">*</span>
                                </label>
                                <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="nip" name="nip" type="text" value="<?= old('nip') ?>" placeholder="Nomor Induk Pegawai" required>
                            </div>
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="nuptk">
                                    NUPTK
                                </label>
                                <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="nuptk" name="nuptk" type="text" value="<?= old('nuptk') ?>" placeholder="Nomor Unik Pendidik & Tenaga Kependidikan">
                            </div>
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="status">
                                    Status Keaktifan
                                </label>
                                <div class="relative group">
                                    <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-black text-indigo-700 appearance-none bg-indigo-50/30" id="status" name="status">
                                        <option value="Aktif" <?= old('status') == 'Aktif' ? 'selected' : '' ?>>AKTIF</option>
                                        <option value="Tidak Aktif" <?= old('status') == 'Tidak Aktif' ? 'selected' : '' ?>>TIDAK AKTIF</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-indigo-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="religion">
                                    Agama
                                </label>
                                <div class="relative group">
                                    <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-black text-indigo-700 appearance-none bg-indigo-50/30" id="religion" name="religion">
                                        <option value="Islam" <?= old('religion') == 'Islam' ? 'selected' : '' ?>>ISLAM</option>
                                        <option value="Kristen" <?= old('religion') == 'Kristen' ? 'selected' : '' ?>>KRISTEN</option>
                                        <option value="Katolik" <?= old('religion') == 'Katolik' ? 'selected' : '' ?>>KATOLIK</option>
                                        <option value="Hindu" <?= old('religion') == 'Hindu' ? 'selected' : '' ?>>HINDU</option>
                                        <option value="Buddha" <?= old('religion') == 'Buddha' ? 'selected' : '' ?>>BUDDHA</option>
                                        <option value="Khonghucu" <?= old('religion') == 'Khonghucu' ? 'selected' : '' ?>>KHONGHUCU</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-indigo-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-span-2 space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="full_name">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="full_name" name="full_name" type="text" value="<?= old('full_name') ?>" placeholder="Contoh: Dr. Herman Saputra, M.Pd" required>
                            </div>
                            <div class="md:col-span-2 space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="phone">
                                    Nomor Telepon / WhatsApp
                                </label>
                                <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="phone" name="phone" type="text" value="<?= old('phone') ?>" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="md:col-span-2 space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="address">
                                    Alamat Lengkap Domisili
                                </label>
                                <textarea class="w-full px-5 py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm min-h-[120px]" id="address" name="address" placeholder="Tuliskan alamat lengkap beserta kota..."><?= old('address') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Info Panel -->
                <div class="p-6 lg:p-8 bg-slate-50/50 border-t border-slate-50">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl lg:rounded-2xl bg-indigo-100/80 text-indigo-600 flex items-center justify-center shrink-0 shadow-sm border border-indigo-200/50">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] lg:text-xs font-black text-slate-800 uppercase tracking-widest leading-relaxed">OTOMATISASI AKUN LOGIN</p>
                            <p class="text-[9px] lg:text-[10px] font-bold text-slate-500 mt-1 leading-relaxed uppercase tracking-tighter">Sistem akan membuatkan akun login secara otomatis. Username: [NAMA_LENGKAP] | Password: <span class="text-indigo-600 font-black">guru123</span></p>
                        </div>
                    </div>
                </div>

                <!-- Submit Panel -->
                <div class="p-6 lg:p-8 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-12 rounded-xl lg:rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-100 hover:shadow-indigo-200 hover:-translate-y-1 active:scale-95 flex items-center justify-center text-[10px] lg:text-xs tracking-[0.2em] uppercase" type="submit">
                        <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        DAFTARKAN GURU BARU
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div>

    <script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photo-preview').innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 shadow-lg">';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
<?= $this->endSection() ?>
