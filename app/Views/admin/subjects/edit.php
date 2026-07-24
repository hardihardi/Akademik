<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 lg:mb-12 flex flex-col md:flex-row md:items-end md:justify-between gap-6 uppercase tracking-widest animate-in fade-in slide-in-from-top-4 duration-700">
        <div>
            <nav class="flex mb-3 lg:mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em]">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase font-black">Dashboard</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="<?= base_url('subjects') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase font-black">Mata Pelajaran</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 uppercase font-black">Edit Mapel</span>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-wrap items-center gap-4">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase"><?= $title ?></h1>
                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-xl border border-indigo-100 uppercase tracking-widest shrink-0">ID: #<?= $subject['id'] ?></span>
            </div>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Perbarui rincian mata pelajaran kurikulum akademik.</p>
        </div>
        <div>
            <a href="<?= base_url('subjects') ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 text-slate-500 font-black text-[10px] tracking-widest hover:bg-slate-200 transition-all uppercase group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                KEMBALI
            </a>
        </div>
    </div>

    <div class="pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
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

        <form action="<?= base_url('subjects/update/' . $subject['id']) ?>" method="post" class="space-y-6 lg:space-y-8">
            <?= csrf_field() ?>
            
            <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 lg:p-10 space-y-8 lg:space-y-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-10">
                        <!-- Left Column: Primary Info -->
                        <div class="space-y-6">
                            <!-- Name -->
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="name">
                                    Nama Mata Pelajaran <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-indigo-600 transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                    <input class="w-full pl-12 pr-6 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all outline-none font-bold text-slate-800 text-sm" 
                                           id="name" name="name" type="text" value="<?= old('name', $subject['name']) ?>" required>
                                </div>
                            </div>

                            <!-- KKM -->
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="kkm">
                                    KKM (Kriteria Ketuntasan Minimal) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-indigo-600 transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.13 3.13 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.13 3.13 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.13-3.13 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.13-3.13z"></path></svg>
                                    </div>
                                    <input class="w-full pl-12 pr-6 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all outline-none font-bold text-slate-800 text-sm" 
                                           id="kkm" name="kkm" type="number" min="0" max="100" value="<?= old('kkm', $subject['kkm']) ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Secondary Info -->
                        <div class="space-y-6">
                            <!-- Category -->
                            <div class="space-y-4">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Kategori Mapel <span class="text-rose-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="relative flex items-center justify-center p-4 rounded-xl lg:rounded-2xl border-2 border-slate-100 cursor-pointer hover:border-indigo-100 transition-all group overflow-hidden">
                                        <input type="radio" name="category" value="Wajib" class="peer absolute opacity-0" <?= old('category', $subject['category']) == 'Wajib' ? 'checked' : '' ?>>
                                        <div class="absolute inset-0 bg-indigo-50/50 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                        <div class="relative flex flex-col items-center gap-1">
                                            <span class="text-xs font-black text-slate-400 peer-checked:text-indigo-600 uppercase tracking-widest transition-colors">Wajib</span>
                                        </div>
                                        <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <div class="w-4 h-4 bg-indigo-600 rounded-full flex items-center justify-center text-white scale-75">
                                                <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7" /></svg>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative flex items-center justify-center p-4 rounded-xl lg:rounded-2xl border-2 border-slate-100 cursor-pointer hover:border-amber-100 transition-all group overflow-hidden">
                                        <input type="radio" name="category" value="Muatan Lokal" class="peer absolute opacity-0" <?= old('category', $subject['category']) == 'Muatan Lokal' ? 'checked' : '' ?>>
                                        <div class="absolute inset-0 bg-amber-50/50 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                        <div class="relative flex flex-col items-center gap-1">
                                            <span class="text-[10px] font-black text-slate-400 peer-checked:text-amber-600 uppercase tracking-tight transition-colors">Muatan Lokal</span>
                                        </div>
                                        <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <div class="w-4 h-4 bg-amber-600 rounded-full flex items-center justify-center text-white scale-75">
                                                <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7" /></svg>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="description">
                                    Deskripsi Singkat
                                </label>
                                <textarea class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all outline-none font-bold text-slate-800 text-sm min-h-[100px] lg:min-h-[110px]" 
                                          id="description" name="description"><?= old('description', $subject['description']) ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Panel -->
                <div class="p-6 lg:p-8 border-t border-slate-50 bg-slate-50/30 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] order-2 sm:order-1 text-center sm:text-left">
                        Update Terakhir: <span class="text-indigo-600"><?= date('H:i d/m/y', strtotime($subject['updated_at'] ?? $subject['created_at'])) ?></span>
                    </p>
                    <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-12 rounded-xl lg:rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-100 hover:shadow-indigo-200 hover:-translate-y-1 active:scale-95 flex items-center justify-center text-[10px] lg:text-xs tracking-[0.2em] uppercase order-1 sm:order-2" type="submit">
                        <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        PERBARUI DATA MAPEL
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
