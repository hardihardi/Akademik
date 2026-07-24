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
                        <a href="<?= base_url('students') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase font-black">Manajemen Siswa</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 uppercase font-black">Perbarui Data</span>
                    </li>
                </ol>
            </nav>
            <div class="flex items-center gap-4">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase"><?= $title ?></h1>
                <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-xl border border-indigo-100 uppercase tracking-widest mt-2 shrink-0">ID: #<?= $student['id'] ?></span>
            </div>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Modifikasi informasi akademik and data personal siswa terpilih.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="<?= base_url('students') ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 text-slate-500 font-black text-[10px] tracking-widest hover:bg-slate-200 transition-all uppercase">
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
                    <?php 
                    $errs = is_array(session('errors')) ? session('errors') : (session()->getFlashdata('errors') ?: []);
                    foreach ($errs as $error): 
                    ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <form action="<?= base_url('students/' . $student['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-6 lg:space-y-8">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <!-- Identity Section -->
            <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 lg:p-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                    <div>
                        <h4 class="font-black text-slate-800 tracking-tight uppercase leading-none">Identitas Siswa</h4>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Informasi dasar & pas foto siswa</p>
                    </div>
                </div>

                <div class="p-6 lg:p-10">
                    <div class="flex flex-col lg:flex-row gap-10 lg:gap-14">
                        <!-- Photo Side -->
                        <div class="flex-shrink-0 flex flex-col items-center">
                            <div class="relative group">
                                <div class="w-40 h-40 lg:w-48 lg:h-48 rounded-2xl lg:rounded-[2rem] bg-slate-100 border-4 border-white shadow-inner flex items-center justify-center overflow-hidden" id="photo-preview">
                                    <?php if(!empty($student['photo'])): ?>
                                        <img src="<?= base_url($student['photo']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 shadow-lg">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-5xl lg:text-6xl font-black">
                                            <?= substr($student['full_name'], 0, 1) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <label class="absolute -bottom-3 -right-3 w-12 h-12 lg:w-14 lg:h-14 bg-indigo-600 text-white rounded-xl lg:rounded-2xl border-4 border-white shadow-lg flex items-center justify-center cursor-pointer hover:bg-indigo-700 hover:scale-110 transition-all duration-300 group">
                                    <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    <input type="file" name="student_photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                                </label>
                            </div>
                            <p class="mt-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center leading-relaxed">BIARKAN KOSONG<br>JIKA TIDAK DIGANTI</p>
                        </div>

                        <!-- Fields Side -->
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="nis">
                                    NIS <span class="text-rose-500">*</span>
                                </label>
                                <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="nis" name="nis" type="text" value="<?= $student['nis'] ?>" placeholder="Nomor Induk Siswa" required>
                            </div>
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="nisn">
                                    NISN
                                </label>
                                <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="nisn" name="nisn" type="text" value="<?= $student['nisn'] ?>" placeholder="Nomor Induk Siswa Nasional">
                            </div>
                            <div class="md:col-span-2 space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="full_name">
                                    Nama Lengkap Siswa <span class="text-rose-500">*</span>
                                </label>
                                <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="full_name" name="full_name" type="text" value="<?= $student['full_name'] ?>" placeholder="Nama Lengkap Sesuai Akte" required>
                            </div>
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="gender">
                                    Jenis Kelamin <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative group">
                                    <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none bg-white" id="gender" name="gender" required>
                                        <option value="L" <?= ($student['gender'] == 'L') ? 'selected' : '' ?>>LAKI-LAKI</option>
                                        <option value="P" <?= ($student['gender'] == 'P') ? 'selected' : '' ?>>PEREMPUAN</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="religion">
                                    Agama
                                </label>
                                <div class="relative group">
                                    <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none bg-white" id="religion" name="religion">
                                        <option value="" disabled>Pilih...</option>
                                        <option value="Islam" <?= (old('religion') ?? $student['religion']) == 'Islam' ? 'selected' : '' ?>>ISLAM</option>
                                        <option value="Kristen" <?= (old('religion') ?? $student['religion']) == 'Kristen' ? 'selected' : '' ?>>KRISTEN</option>
                                        <option value="Katolik" <?= (old('religion') ?? $student['religion']) == 'Katolik' ? 'selected' : '' ?>>KATOLIK</option>
                                        <option value="Hindu" <?= (old('religion') ?? $student['religion']) == 'Hindu' ? 'selected' : '' ?>>HINDU</option>
                                        <option value="Buddha" <?= (old('religion') ?? $student['religion']) == 'Buddha' ? 'selected' : '' ?>>BUDDHA</option>
                                        <option value="Konghucu" <?= (old('religion') ?? $student['religion']) == 'Konghucu' ? 'selected' : '' ?>>KONGHUCU</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="class_id">
                                    Penempatan Kelas
                                </label>
                                <div class="relative group">
                                    <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none bg-white" id="class_id" name="class_id">
                                        <option value="">TANPA KELAS</option>
                                        <?php foreach($classes as $class): ?>
                                            <option value="<?= $class['id'] ?>" <?= ($student['class_id'] == $class['id']) ? 'selected' : '' ?>><?= strtoupper($class['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-span-2 space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="status">
                                    Status Keaktifan
                                </label>
                                <div class="relative group">
                                    <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-black text-indigo-700 appearance-none bg-indigo-50/30 shadow-sm" id="status" name="status">
                                        <option value="Aktif" <?= ($student['status'] == 'Aktif') ? 'selected' : '' ?>>AKTIF</option>
                                        <option value="Lulus" <?= ($student['status'] == 'Lulus') ? 'selected' : '' ?>>LULUS</option>
                                        <option value="Pindah" <?= ($student['status'] == 'Pindah') ? 'selected' : '' ?>>PINDAH</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-indigo-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 lg:p-8 border-b border-slate-50 bg-slate-50/30">
                    <h4 class="font-black text-slate-800 tracking-tight uppercase leading-none">Biodata & Alamat</h4>
                </div>
                <div class="p-6 lg:p-10 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="birth_place">
                            Tempat Lahir
                        </label>
                        <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="birth_place" name="birth_place" type="text" value="<?= $student['birth_place'] ?>" placeholder="Kota Tempat Lahir">
                    </div>
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="birth_date">
                            Tanggal Lahir
                        </label>
                        <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 text-sm" id="birth_date" name="birth_date" type="date" value="<?= $student['birth_date'] ?>">
                    </div>
                    <div class="md:col-span-2 space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="address">
                            Alamat Lengkap Domisili
                        </label>
                        <textarea class="w-full px-5 py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm min-h-[120px]" id="address" name="address" placeholder="Tuliskan alamat lengkap..."><?= $student['address'] ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Parent Info -->
            <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 lg:p-8 border-b border-slate-50 bg-slate-50/30">
                    <h4 class="font-black text-slate-800 tracking-tight uppercase leading-none">Informasi Orang Tua / Wali</h4>
                </div>
                <div class="p-6 lg:p-10 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="parent_name">
                            Nama Orang Tua / Wali
                        </label>
                        <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="parent_name" name="parent_name" type="text" value="<?= $student['parent_name'] ?>" placeholder="Nama Lengkap Wali">
                    </div>
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="parent_phone">
                            Nomor WhatsApp Wali
                        </label>
                        <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all font-bold text-slate-800 placeholder:text-slate-300 text-sm" id="parent_phone" name="parent_phone" type="text" value="<?= $student['parent_phone'] ?>" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="md:col-span-2 space-y-3 p-6 lg:p-8 bg-indigo-50 rounded-2xl lg:rounded-[2rem] border border-dashed border-indigo-200">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="user_id">
                            Hubungkan Akun Sistem Orang Tua <span class="text-indigo-400 ml-1 font-medium tracking-normal text-[8px]">(Opsional)</span>
                        </label>
                        <div class="relative group mt-3">
                            <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-400 transition-all font-bold text-slate-800 appearance-none bg-white" id="user_id" name="user_id">
                                <option value="">TIDAK DIHUBUNGKAN</option>
                                <?php foreach($parents as $p): ?>
                                    <option value="<?= $p['id'] ?>" <?= ($student['user_id'] == $p['id']) ? 'selected' : '' ?>><?= $p['username'] ?> (<?= $p['email'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Panel -->
                <div class="p-6 lg:p-8 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-12 rounded-xl lg:rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-100 hover:shadow-indigo-200 hover:-translate-y-1 active:scale-95 flex items-center justify-center text-[10px] lg:text-xs tracking-[0.2em] uppercase" type="submit">
                        <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        SIMPAN PERUBAHAN DATA
                    </button>
                    <p class="text-[9px] lg:text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none shrink-0">TERAKHIR DIUPDATE: <span class="text-slate-400 font-mono"><?= date('H:i d/m/y', strtotime($student['updated_at'] ?? $student['created_at'])) ?></span></p>
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
