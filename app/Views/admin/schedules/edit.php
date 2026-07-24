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
                        <a href="<?= base_url('schedules') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase">Jadwal</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 uppercase">Edit Jadwal</span>
                    </li>
                </ol>
            </nav>
            <div class="flex items-center gap-4">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase"><?= $title ?></h1>
                <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-xl border border-indigo-100 uppercase tracking-widest mt-2 shrink-0">ID: #<?= $schedule['id'] ?></span>
            </div>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Sesuaikan kembali detail rincian jadwal pada roaster pelajaran.</p>
        </div>
        <div>
            <a href="<?= base_url('schedules') ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 text-slate-500 font-black text-[10px] tracking-widest hover:bg-slate-200 transition-all uppercase text-center min-w-[120px]">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                KEMBALI
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('error')):?>
        <div class="mb-6 lg:mb-8 animate-in slide-in-from-right duration-500 no-print">
            <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 lg:p-6 flex items-start gap-4 shadow-sm shadow-rose-100/50">
                <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-black text-rose-800 uppercase tracking-tight mb-1">Terjadi Kesalahan</p>
                    <p class="text-xs font-semibold text-rose-600 leading-relaxed"><?= session()->getFlashdata('error') ?></p>
                </div>
            </div>
        </div>
    <?php endif;?>

    <div class="animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 lg:p-10">
                <form action="<?= base_url('schedules/update/' . $schedule['id']) ?>" method="post" class="space-y-6 lg:space-y-8 text-sm">
                    <?= csrf_field() ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="class_id">
                                Pilih Kelas <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none bg-white" id="class_id" name="class_id" required>
                                    <option value="">Pilih Kelas...</option>
                                    <?php foreach($classes as $class): ?>
                                        <option value="<?= $class['id'] ?>" <?= $schedule['class_id'] == $class['id'] ? 'selected' : '' ?>><?= $class['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="subject_id">
                                Mata Pelajaran <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none bg-white" id="subject_id" name="subject_id" required>
                                    <option value="">Pilih Mapel...</option>
                                    <?php foreach($subjects as $subject): ?>
                                        <option value="<?= $subject['id'] ?>" <?= $schedule['subject_id'] == $subject['id'] ? 'selected' : '' ?>><?= $subject['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="teacher_id">
                                Guru Pengajar <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none bg-white" id="teacher_id" name="teacher_id" required>
                                    <option value="">Pilih Guru...</option>
                                    <?php foreach($teachers as $teacher): ?>
                                        <option value="<?= $teacher['id'] ?>" <?= $schedule['teacher_id'] == $teacher['id'] ? 'selected' : '' ?>><?= $teacher['full_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="academic_year_id">
                                Tahun Akademik <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none bg-white" id="academic_year_id" name="academic_year_id" required>
                                    <option value="">Pilih Tahun...</option>
                                    <?php foreach($academicYears as $year): ?>
                                        <option value="<?= $year['id'] ?>" <?= $schedule['academic_year_id'] == $year['id'] ? 'selected' : '' ?>><?= $year['year'] ?> - <?= strtoupper($year['semester']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="day">
                                Hari <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none bg-white" id="day" name="day" required>
                                    <?php foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $d): ?>
                                        <option value="<?= $d ?>" <?= $schedule['day'] == $d ? 'selected' : '' ?>><?= strtoupper($d) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="start_time">
                                Jam Mulai <span class="text-rose-500">*</span>
                            </label>
                            <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800" id="start_time" name="start_time" type="time" value="<?= substr($schedule['start_time'], 0, 5) ?>" required>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="end_time">
                                Jam Selesai <span class="text-rose-500">*</span>
                            </label>
                            <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800" id="end_time" name="end_time" type="time" value="<?= substr($schedule['end_time'], 0, 5) ?>" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="room">
                            Ruangan <span class="text-slate-300 ml-1 font-medium tracking-normal text-[8px]">(Opsional)</span>
                        </label>
                        <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300" id="room" name="room" type="text" value="<?= $schedule['room'] ?>" placeholder="Contoh: Ruang 101, Lab IPA, dsb.">
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex flex-col sm:flex-row items-center gap-4">
                        <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-10 rounded-xl lg:rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-100 hover:shadow-indigo-200 hover:-translate-y-1 active:scale-95 flex items-center justify-center text-[10px] lg:text-xs tracking-[0.2em] uppercase" type="submit">
                            <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            SIMPAN PERUBAHAN
                        </button>
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Update terakhir: <span class="text-slate-400 font-mono"><?= date('H:i d/m/y', strtotime($schedule['updated_at'] ?? $schedule['created_at'])) ?></span></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
