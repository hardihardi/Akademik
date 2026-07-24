<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-8 animate-in fade-in slide-in-from-top-4 duration-700">
        <div>
            <div class="flex items-center gap-2 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 lg:mb-4">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase">PENGATURAN</span>
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight"><?= $title ?></h1>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Sesuaikan identitas dan branding sekolah Anda.</p>
        </div>
        <div class="flex gap-3">
            <a href="<?= base_url('backup/download') ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-white text-indigo-600 border border-slate-200 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-slate-50 hover:border-slate-300 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 lg:mr-3 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                BACKUP DATA
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('message')):?>
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-xl shadow-sm animate-fade-in-down" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-emerald-800"><?= session()->getFlashdata('message') ?></p>
                </div>
            </div>
        </div>
    <?php endif;?>

    <!-- Main Form Card -->
    <div class="bg-white rounded-2xl lg:rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-1000">
        <form action="<?= base_url('settings/update') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- ==================== SECTION 1: Branding Assets ==================== -->
            <div class="p-4 sm:p-6 lg:p-8 border-b border-slate-100">
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-wider mb-1">Branding & Aset Visual</h2>
                <p class="text-xs text-slate-400 mb-6">Logo, favicon, dan tanda tangan kepala sekolah.</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Logo -->
                    <div class="flex flex-col items-center sm:items-start">
                        <label class="block text-xs font-bold text-slate-500 mb-3 uppercase tracking-wider">Logo Sekolah</label>
                        <div class="relative group w-32 h-32 sm:w-36 sm:h-36 lg:w-44 lg:h-44">
                            <div class="w-full h-full rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden transition-all group-hover:border-indigo-300">
                                <?php if(!empty($settings['school_logo'])): ?>
                                    <img src="<?= base_url($settings['school_logo']) ?>" class="object-contain w-full h-full p-2" alt="Logo">
                                <?php else: ?>
                                    <div class="text-center p-4">
                                        <svg class="mx-auto h-10 w-10 text-slate-300" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                        <p class="mt-1 text-[10px] text-slate-400">Logo 1:1</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <label class="absolute inset-0 cursor-pointer flex flex-col items-center justify-center bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl text-white text-xs font-bold">
                                <svg class="w-7 h-7 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                GANTI LOGO
                                <input type="file" name="school_logo" class="hidden" accept="image/*">
                            </label>
                        </div>
                        <p class="mt-2 text-[10px] text-slate-400">Maks 2MB</p>
                    </div>

                    <!-- Favicon -->
                    <div class="flex flex-col items-center sm:items-start">
                        <label class="block text-xs font-bold text-slate-500 mb-3 uppercase tracking-wider">Favicon</label>
                        <div class="relative group w-20 h-20">
                            <div class="w-full h-full rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden transition-all group-hover:border-indigo-300">
                                <?php if(!empty($settings['school_favicon'])): ?>
                                    <img src="<?= base_url($settings['school_favicon']) ?>" class="object-contain w-full h-full p-1" alt="Favicon">
                                <?php else: ?>
                                    <div class="text-center">
                                        <svg class="mx-auto h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <label class="absolute inset-0 cursor-pointer flex flex-col items-center justify-center bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl text-white text-[10px] font-bold">
                                GANTI
                                <input type="file" name="school_favicon" class="hidden" accept="image/*">
                            </label>
                        </div>
                        <p class="mt-2 text-[10px] text-slate-400">Tab browser</p>
                    </div>

                    <!-- Tanda Tangan -->
                    <div class="flex flex-col items-center sm:items-start">
                        <label class="block text-xs font-bold text-slate-500 mb-3 uppercase tracking-wider">Tanda Tangan Kepsek</label>
                        <div class="relative group w-44 h-20 sm:w-full sm:h-24">
                            <div class="w-full h-full rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden transition-all group-hover:border-indigo-300">
                                <?php if(!empty($settings['headmaster_signature'])): ?>
                                    <img src="<?= base_url($settings['headmaster_signature']) ?>" class="object-contain w-full h-full p-2" alt="Tanda Tangan">
                                <?php else: ?>
                                    <div class="text-center p-3">
                                        <svg class="mx-auto h-7 w-7 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        <p class="mt-1 text-[10px] text-slate-400">Upload TTD</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <label class="absolute inset-0 cursor-pointer flex flex-col items-center justify-center bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl text-white text-xs font-bold">
                                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                GANTI TTD
                                <input type="file" name="headmaster_signature" class="hidden" accept="image/*">
                            </label>
                        </div>
                        <p class="mt-2 text-[10px] text-slate-400">PNG transparan. Maks 1MB</p>
                    </div>
                </div>
            </div>

            <!-- ==================== SECTION 2: Informasi Sekolah ==================== -->
            <div class="p-4 sm:p-6 lg:p-8 border-b border-slate-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-wider mb-1">Informasi Sekolah</h2>
                        <p class="text-xs text-slate-400">Data identitas sekolah yang tampil di rapor dan dokumen.</p>
                    </div>
                </div>

                <?php if(session()->getFlashdata('error')): ?>
                    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl text-rose-700 text-xs font-bold animate-in fade-in slide-in-from-left-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Sekolah</label>
                        <input type="text" name="school_name" value="<?= $settings['school_name'] ?? '' ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium text-slate-800 text-sm" placeholder="Masukkan nama resmi sekolah" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email Sekolah</label>
                        <input type="email" name="school_email" value="<?= $settings['school_email'] ?? '' ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium text-slate-800 text-sm" placeholder="kontak@sekolah.sch.id" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kota / Kabupaten</label>
                        <input type="text" name="school_city" value="<?= $settings['school_city'] ?? '' ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium text-slate-800 text-sm" placeholder="Contoh: Cikarang" required>
                        <p class="mt-1.5 text-[10px] text-slate-400">Digunakan pada format tanggal dokumen: <span class="font-bold text-slate-500">Cikarang, 18 April 2026</span></p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                        <textarea name="school_address" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium text-slate-800 text-sm" placeholder="Jalan, No, Kec, Kota/Kab, Provinsi" required><?= $settings['school_address'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- ==================== SECTION 3: Konfigurasi Bobot Nilai ==================== -->
            <div class="p-4 sm:p-6 lg:p-8 border-b border-slate-100 bg-slate-50/30">
                <div class="flex items-center gap-3 mb-1">
                    <h2 class="text-sm font-black text-slate-800 uppercase tracking-wider">Konfigurasi Bobot Nilai Akhir</h2>
                    <span class="px-2 py-0.5 bg-indigo-100 text-indigo-600 text-[9px] font-black rounded-lg uppercase tracking-widest">Global</span>
                </div>
                <p class="text-xs text-slate-400 mb-8">Tentukan persentase kontribusi setiap komponen nilai terhadap nilai akhir rapor. Total harus 100%.</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 lg:gap-10">
                    <!-- Weight: Tugas -->
                    <div class="group">
                        <label class="block text-[11px] font-black text-slate-500 mb-3 uppercase tracking-widest group-hover:text-indigo-600 transition-colors">Penilaian Harian (Tugas)</label>
                        <div class="relative">
                            <input type="number" name="weight_tugas" value="<?= $settings['weight_tugas'] ?? '40' ?>" min="0" max="100" class="w-full pl-5 pr-12 py-4 rounded-2xl border-2 border-slate-100 focus:border-indigo-500 focus:ring-0 transition-all font-black text-xl text-slate-700" required>
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-slate-300 text-xl">%</span>
                        </div>
                        <p class="mt-3 text-[10px] text-slate-400 font-medium italic">Termasuk Tugas, Ulangan, dan Sikap.</p>
                    </div>

                    <!-- Weight: UTS -->
                    <div class="group">
                        <label class="block text-[11px] font-black text-slate-500 mb-3 uppercase tracking-widest group-hover:text-indigo-600 transition-colors">Tengah Semester (UTS)</label>
                        <div class="relative">
                            <input type="number" name="weight_uts" value="<?= $settings['weight_uts'] ?? '30' ?>" min="0" max="100" class="w-full pl-5 pr-12 py-4 rounded-2xl border-2 border-slate-100 focus:border-indigo-500 focus:ring-0 transition-all font-black text-xl text-slate-700" required>
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-slate-300 text-xl">%</span>
                        </div>
                        <p class="mt-3 text-[10px] text-slate-400 font-medium italic">Evaluasi tengah periode belajar.</p>
                    </div>

                    <!-- Weight: UAS -->
                    <div class="group">
                        <label class="block text-[11px] font-black text-slate-500 mb-3 uppercase tracking-widest group-hover:text-indigo-600 transition-colors">Akhir Semester (UAS)</label>
                        <div class="relative">
                            <input type="number" name="weight_uas" value="<?= $settings['weight_uas'] ?? '30' ?>" min="0" max="100" class="w-full pl-5 pr-12 py-4 rounded-2xl border-2 border-slate-100 focus:border-indigo-500 focus:ring-0 transition-all font-black text-xl text-slate-700" required>
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-slate-300 text-xl">%</span>
                        </div>
                        <p class="mt-3 text-[10px] text-slate-400 font-medium italic">Evaluasi akhir keseluruhan materi.</p>
                    </div>
                </div>
            </div>

            <!-- ==================== SECTION 4: Kepala Sekolah ==================== -->
            <div class="p-4 sm:p-6 lg:p-8">
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-wider mb-1">Kepala Sekolah</h2>
                <p class="text-xs text-slate-400 mb-6">Informasi kepala sekolah untuk keperluan rapor dan surat resmi.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kepala Sekolah</label>
                        <input type="text" name="headmaster_name" value="<?= $settings['headmaster_name'] ?? '' ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium text-slate-800 text-sm" placeholder="Gelar Lengkap" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">NIP Kepala Sekolah</label>
                        <input type="text" name="headmaster_nip" value="<?= $settings['headmaster_nip'] ?? '' ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium text-slate-800 text-sm" placeholder="18-digit NIP" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end pt-6 mt-6 border-t border-slate-100">
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 text-sm font-bold text-white bg-indigo-600 rounded-xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-0.5 active:scale-95 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        SIMPAN PERUBAHAN
                    </button>
                </div>
            </div>
        </form>
    </div>

<style>
@keyframes fade-in-down {
    0% { opacity: 0; transform: translateY(-10px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-down {
    animation: fade-in-down 0.5s ease-out forwards;
}
</style>
<?= $this->endSection() ?>
