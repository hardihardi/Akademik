<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="max-w-6xl mx-auto">
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
                        <a href="<?= base_url('teacher-assignments') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase">Penugasan Guru</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 uppercase">Edit Penugasan</span>
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase underline decoration-indigo-500 decoration-8 underline-offset-8">Perbarui Konfigurasi</h1>
            <p class="text-slate-500 mt-6 font-medium text-xs lg:text-sm">Modifikasi detail mata pelajaran dan kelas untuk guru yang bersangkutan.</p>
        </div>
        <div>
            <a href="<?= base_url('teacher-assignments') ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 text-slate-500 font-black text-[10px] tracking-widest hover:bg-slate-200 transition-all uppercase text-center min-w-[120px]">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                KEMBALI
            </a>
        </div>
    </div>

    <!-- Error/Validation -->
    <?php if(session()->has('errors')): ?>
        <div class="mb-8 p-6 bg-rose-50 border-2 border-rose-100 rounded-[2rem] flex items-start gap-4">
            <div class="w-10 h-10 rounded-2xl bg-white flex items-center justify-center text-rose-600 shadow-sm flex-shrink-0 mt-1">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <div>
                <p class="text-rose-800 font-black text-sm tracking-tight mb-2">Terjadi Kesalahan Validasi:</p>
                <ul class="text-rose-600 text-xs font-bold space-y-1 list-disc list-inside">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <form action="<?= base_url('teacher-assignments/' . $assignment['id']) ?>" method="post" class="space-y-8">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 bg-slate-50/30">
                    <h4 class="font-black text-slate-800 tracking-tight">Edit Detail Penugasan</h4>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">ID Penugasan: #<?= $assignment['id'] ?></p>
                </div>

                <div class="p-10 space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Teacher Select -->
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]" for="teacher_id">
                                Pilih Guru <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative group">
                                <select class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 appearance-none focus:outline-none focus:border-indigo-500 focus:bg-white transition-all duration-300" id="teacher_id" name="teacher_id" required>
                                    <?php foreach($teachers as $teacher): ?>
                                        <option value="<?= $teacher['id'] ?>" <?= (old('teacher_id') ?: $assignment['teacher_id']) == $teacher['id'] ? 'selected' : '' ?>><?= $teacher['full_name'] ?> (NIP: <?= $teacher['nip'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Year Select -->
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]" for="academic_year_id">
                                Tahun Ajaran <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative group">
                                <select class="w-full px-6 py-4 bg-indigo-50 border-2 border-indigo-100 rounded-2xl font-black text-indigo-700 appearance-none focus:outline-none focus:border-indigo-500 transition-all duration-300" id="academic_year_id" name="academic_year_id" required>
                                    <?php foreach($academicYears as $year): ?>
                                        <option value="<?= $year['id'] ?>" <?= (old('academic_year_id') ?: $assignment['academic_year_id']) == $year['id'] ? 'selected' : '' ?>>
                                            <?= $year['year'] ?> - <?= $year['semester'] ?> <?= $year['status'] == 'Active' ? '(AKTIF)' : '' ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-indigo-300">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Subject Select -->
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]" for="subject_id">
                                Mata Pelajaran <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative group">
                                <select class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 appearance-none focus:outline-none focus:border-indigo-500 focus:bg-white transition-all duration-300" id="subject_id" name="subject_id" required>
                                    <?php foreach($subjects as $subj): ?>
                                        <option value="<?= $subj['id'] ?>" <?= (old('subject_id') ?: $assignment['subject_id']) == $subj['id'] ? 'selected' : '' ?>><?= $subj['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Class Select -->
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]" for="class_id">
                                Kelas <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative group">
                                <select class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 appearance-none focus:outline-none focus:border-indigo-500 focus:bg-white transition-all duration-300" id="class_id" name="class_id" required>
                                    <?php foreach($classes as $cls): ?>
                                        <option value="<?= $cls['id'] ?>" <?= (old('class_id') ?: $assignment['class_id']) == $cls['id'] ? 'selected' : '' ?>>Kelas <?= $cls['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-slate-50/50 border-t border-slate-100 flex justify-end gap-4">
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-12 rounded-[2rem] shadow-xl shadow-indigo-100 hover:shadow-indigo-200 hover:translate-y-[-2px] focus:outline-none transition-all duration-300 tracking-widest uppercase text-xs flex items-center" type="submit">
                        <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>
