<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-8 animate-in fade-in slide-in-from-top-4 duration-700">
        <div>
            <nav class="flex mb-3 lg:mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em]">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase">Dashboard</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="<?= base_url('classes') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase">Data Kelas</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 uppercase">Edit Kelas</span>
                    </li>
                </ol>
            </nav>
            <div class="flex items-center gap-4">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase"><?= $title ?></h1>
                <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-xl border border-indigo-100 uppercase tracking-widest mt-2">ID: #<?= $class['id'] ?></span>
            </div>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Perbarui informasi detil untuk kelas terdaftar.</p>
        </div>
        <div>
            <a href="<?= base_url('classes') ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 text-slate-500 font-black text-[10px] tracking-widest hover:bg-slate-200 transition-all uppercase text-center min-w-[120px]">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                KEMBALI
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="animate-in fade-in slide-in-from-bottom-4 duration-700 delay-150">
        <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 lg:p-10">
                <form action="<?= base_url('classes/' . $class['id']) ?>" method="post" class="space-y-6 lg:space-y-8">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="name">
                                Nama Kelas <span class="text-rose-500">*</span>
                            </label>
                            <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-sm font-bold text-slate-800 placeholder:text-slate-300" id="name" name="name" type="text" value="<?= $class['name'] ?>" required>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="academic_year">
                                Tahun Ajaran <span class="text-rose-500">*</span>
                            </label>
                            <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-sm font-bold text-slate-800 placeholder:text-slate-300" id="academic_year" name="academic_year" type="text" value="<?= $class['academic_year'] ?>" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="capacity">
                            Kapasitas Kelas <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative max-w-xs">
                            <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-sm font-bold text-slate-800" id="capacity" name="capacity" type="number" min="1" max="100" value="<?= $class['capacity'] ?? 30 ?>" required>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase tracking-widest pointer-events-none">SISWA</div>
                        </div>
                        <p class="mt-3 text-[10px] text-slate-400 font-medium">Jumlah maksimal siswa yang dapat ditampung di kelas ini.</p>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex flex-col sm:flex-row items-center gap-4">
                        <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-10 rounded-xl lg:rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-100 hover:shadow-indigo-200 hover:-translate-y-1 active:scale-95 flex items-center justify-center text-[10px] lg:text-xs tracking-[0.2em] uppercase" type="submit">
                            <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            PERBARUI DATA
                        </button>
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Waktu Terakhir Diupdate: <span class="text-slate-400 font-mono"><?= date('H:i d/m/y', strtotime($class['updated_at'] ?? $class['created_at'])) ?></span></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
