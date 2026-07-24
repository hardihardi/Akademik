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
                        <a href="<?= base_url('homerooms') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase">Wali Kelas</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 uppercase">Edit Wali Kelas</span>
                    </li>
                </ol>
            </nav>
            <div class="flex items-center gap-4">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase"><?= $title ?></h1>
                <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-xl border border-indigo-100 uppercase tracking-widest mt-2 shrink-0">ID: #<?= $assignment['id'] ?></span>
            </div>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Modifikasi detail penugasan guru pengampu jabatan wali kelas.</p>
        </div>
        <div>
            <a href="<?= base_url('homerooms') ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 text-slate-500 font-black text-[10px] tracking-widest hover:bg-slate-200 transition-all uppercase text-center min-w-[120px]">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                KEMBALI
            </a>
        </div>
    </div>

    <!-- Error/Validation -->
    <?php if(session()->getFlashdata('error')): ?>
        <div class="mb-8 p-6 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-4 animate-in slide-in-from-right duration-500 shadow-sm shadow-rose-100/50">
            <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <div>
                <p class="text-xs font-black text-rose-800 uppercase tracking-tight mb-1">Gagal Menyimpan:</p>
                <p class="text-[11px] font-semibold text-rose-600"><?= session()->getFlashdata('error') ?></p>
            </div>
        </div>
    <?php endif; ?>

    <div class="animate-in fade-in slide-in-from-bottom-4 duration-700 mt-6 md:mt-10">
        <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 lg:p-10">
                <form action="<?= base_url('homerooms/update/' . $assignment['id']) ?>" method="post" class="space-y-6 lg:space-y-8">
                    <?= csrf_field() ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <!-- Class Select -->
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="class_id">
                                Pilih Kelas <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative group">
                                <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none bg-white" id="class_id" name="class_id" required>
                                    <?php foreach($classes as $c): ?>
                                        <option value="<?= $c['id'] ?>" <?= (old('class_id') ?: $assignment['class_id']) == $c['id'] ? 'selected' : '' ?>>KELAS <?= $c['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Teacher Select -->
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="teacher_id">
                                Pilih Guru <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative group">
                                <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none bg-white" id="teacher_id" name="teacher_id" required>
                                    <?php foreach($teachers as $t): ?>
                                        <option value="<?= $t['id'] ?>" <?= (old('teacher_id') ?: $assignment['teacher_id']) == $t['id'] ? 'selected' : '' ?>><?= $t['full_name'] ?> (NIP: <?= $t['nip'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Year Select -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest" for="academic_year_id">
                            Tahun Ajaran <span class="text-rose-500">*</span>
                        </label>
                        <div class="p-6 bg-indigo-50 border border-indigo-100 rounded-2xl lg:rounded-[2rem] relative group">
                            <select class="w-full px-5 py-3 lg:py-4 rounded-xl border border-indigo-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-400 transition-all outline-none font-black text-indigo-700 appearance-none bg-white" id="academic_year_id" name="academic_year_id" required>
                                <?php foreach($academic_years as $ay): ?>
                                    <option value="<?= $ay['id'] ?>" <?= (old('academic_year_id') ?: $assignment['academic_year_id']) == $ay['id'] ? 'selected' : '' ?>>
                                        <?= $ay['year'] ?> - <?= ($ay['semester'] == 1) ? 'GANJIL' : 'GENAP' ?> <?= ($ay['status'] == 'Active') ? '(PERIODE AKTIF)' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute right-12 top-1/2 -translate-y-1/2 pointer-events-none text-indigo-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex flex-col sm:flex-row items-center gap-4">
                        <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-12 rounded-xl lg:rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-100 hover:shadow-indigo-200 hover:-translate-y-1 active:scale-95 flex items-center justify-center text-[10px] lg:text-xs tracking-[0.2em] uppercase" type="submit">
                            <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            SIMPAN PERUBAHAN
                        </button>
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none">Terakhir diupdate: <span class="text-slate-400 font-mono"><?= date('H:i d/m/y', strtotime($assignment['updated_at'] ?? $assignment['created_at'])) ?></span></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
