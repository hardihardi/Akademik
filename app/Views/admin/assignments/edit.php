<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="min-h-screen lg:min-h-[80vh] flex flex-col items-center justify-start lg:justify-center py-6 md:py-10 px-4 sm:px-6">
        
        <!-- Header Section -->
        <div class="w-full max-w-4xl mb-6 lg:mb-10 animate-in fade-in slide-in-from-top-4 duration-700">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="text-left w-full">
                    <nav class="flex mb-3 md:mb-4" aria-label="Breadcrumb">
                        <ol class="inline-flex flex-wrap items-center space-x-1 md:space-x-2 text-[9px] md:text-[10px] font-black uppercase tracking-widest">
                            <li class="inline-flex items-center">
                                <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Dashboard</a>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <a href="<?= base_url('assignments') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Pembelajaran</a>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="text-indigo-600">Edit Data</span>
                            </li>
                        </ol>
                    </nav>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 md:gap-4">
                        <h1 class="text-2xl md:text-4xl lg:text-5xl font-black text-slate-800 tracking-tight leading-tight uppercase font-display"><?= $title ?></h1>
                        <span class="inline-block w-fit px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[9px] md:text-[10px] font-black rounded-xl border border-indigo-100 uppercase tracking-widest shrink-0">ID: #<?= $assignment['id'] ?></span>
                    </div>
                    <p class="text-slate-500 mt-2 font-medium text-xs md:text-sm lg:text-base max-w-xl">Perbarui rincian atau file lampiran pembelajaran dengan tetap menjaga konsistensi data.</p>
                </div>
                <div class="shrink-0">
                    <a href="<?= base_url('assignments') ?>" class="inline-flex items-center justify-center px-5 py-3 md:px-6 md:py-4 rounded-xl md:rounded-2xl bg-white border border-slate-100 text-slate-500 font-black text-[10px] md:text-xs tracking-widest hover:bg-slate-50 hover:text-slate-700 transition-all shadow-sm group w-full md:w-auto uppercase">
                        <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="w-full max-w-4xl animate-in fade-in slide-in-from-bottom-8 duration-700 delay-300">
            <div class="bg-white rounded-[1.5rem] md:rounded-[2.5rem] lg:rounded-[3.5rem] shadow-xl md:shadow-2xl shadow-slate-200/50 border border-slate-50 overflow-hidden relative group">
                
                <!-- Decorative element (Hidden on Mobile) -->
                <div class="hidden md:block absolute top-0 right-0 w-32 h-32 bg-indigo-50/50 rounded-bl-full -mr-16 -mt-16 group-hover:bg-indigo-100/50 transition-colors"></div>
                
                <div class="p-6 md:p-10 lg:p-14 relative z-10">
                    <form action="<?= base_url('assignments/update/' . $assignment['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-6 md:space-y-8 lg:space-y-10">
                        <?= csrf_field() ?>
                        
                        <?php if(session()->get('role') == 'guru'): ?>
                            <input type="hidden" name="teacher_id" value="<?= $teacherId ?>">
                        <?php endif; ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 lg:gap-12">
                            <!-- Left Column -->
                            <div class="space-y-5 md:space-y-8">
                                <!-- Class Select -->
                                <div>
                                    <label class="block text-[10px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Pilih Kelas Sasaran <span class="text-rose-500">*</span></label>
                                    <div class="relative group/select">
                                        <select name="class_id" class="w-full px-5 py-3.5 md:py-4 rounded-xl md:rounded-2xl border-2 border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 md:focus:ring-8 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none cursor-pointer text-sm md:text-base" required>
                                            <option value="">Pilih Kelas...</option>
                                            <?php foreach($classes as $class): ?>
                                                <option value="<?= $class['id'] ?>" <?= old('class_id', $assignment['class_id']) == $class['id'] ? 'selected' : '' ?>>KELAS <?= strtoupper($class['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 md:pr-6 pointer-events-none text-slate-400 group-hover/select:text-indigo-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subject Select -->
                                <div>
                                    <label class="block text-[10px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Mata Pelajaran <span class="text-rose-500">*</span></label>
                                    <div class="relative group/select">
                                        <select name="subject_id" class="w-full px-5 py-3.5 md:py-4 rounded-xl md:rounded-2xl border-2 border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 md:focus:ring-8 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none cursor-pointer text-sm md:text-base" required>
                                            <option value="">Pilih Mapel...</option>
                                            <?php foreach($subjects as $subject): ?>
                                                <option value="<?= $subject['id'] ?>" <?= old('subject_id', $assignment['subject_id']) == $subject['id'] ? 'selected' : '' ?>><?= $subject['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 md:pr-6 pointer-events-none text-slate-400">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                        </div>
                                    </div>
                                </div>

                                <?php if(session()->get('role') == 'admin'): ?>
                                <div>
                                    <label class="block text-[10px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Guru Pengampu <span class="text-rose-500">*</span></label>
                                    <div class="relative group/select">
                                        <select name="teacher_id" class="w-full px-5 py-3.5 md:py-4 rounded-xl md:rounded-2xl border-2 border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 md:focus:ring-8 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none text-sm md:text-base" required>
                                            <option value="">Pilih Guru...</option>
                                            <?php foreach($teachers as $teacher): ?>
                                                <option value="<?= $teacher['id'] ?>" <?= old('teacher_id', $assignment['teacher_id']) == $teacher['id'] ? 'selected' : '' ?>><?= $teacher['full_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 md:pr-6 pointer-events-none text-slate-400">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-5 md:space-y-8">
                                <div>
                                    <label class="block text-[10px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Tipe Konten <span class="text-rose-500">*</span></label>
                                    <div class="relative group/select">
                                        <select name="type" class="w-full px-5 py-3.5 md:py-4 rounded-xl md:rounded-2xl border-2 border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 md:focus:ring-8 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-bold text-slate-800 appearance-none text-sm md:text-base" required>
                                            <option value="Tugas" <?= old('type', $assignment['type']) == 'Tugas' ? 'selected' : '' ?>>📝 Tugas</option>
                                            <option value="Materi" <?= old('type', $assignment['type']) == 'Materi' ? 'selected' : '' ?>>📚 Materi</option>
                                            <option value="Ulangan" <?= old('type', $assignment['type']) == 'Ulangan' ? 'selected' : '' ?>>📋 Ulangan</option>
                                            <option value="UTS" <?= old('type', $assignment['type']) == 'UTS' ? 'selected' : '' ?>>📊 UTS</option>
                                            <option value="UAS" <?= old('type', $assignment['type']) == 'UAS' ? 'selected' : '' ?>>🏆 UAS</option>
                                            <option value="Sikap" <?= old('type', $assignment['type']) == 'Sikap' ? 'selected' : '' ?>>🌟 Sikap</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 md:pr-6 pointer-events-none text-slate-400">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Judul Pembelajaran <span class="text-rose-500">*</span></label>
                                    <div class="relative group/input">
                                        <input type="text" name="title" value="<?= old('title', $assignment['title']) ?>" class="w-full pl-11 pr-5 py-3.5 md:py-4 rounded-xl md:rounded-2xl border-2 border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-bold text-slate-800 text-sm md:text-base shadow-sm" required>
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/input:text-indigo-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Batas Pengumpulan <span class="text-rose-500">*</span></label>
                                    <div class="relative group/input">
                                        <input type="datetime-local" name="deadline" value="<?= date('Y-m-d\TH:i', strtotime($assignment['deadline'])) ?>" class="w-full pl-11 pr-5 py-3.5 md:py-4 rounded-xl md:rounded-2xl border-2 border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-bold text-slate-800 text-sm md:text-base shadow-sm" required>
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/input:text-indigo-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Instruksi & Penjelasan</label>
                            <textarea name="description" rows="4" class="w-full px-5 py-4 md:py-6 rounded-2xl md:rounded-[2rem] border-2 border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-bold text-slate-800 text-sm md:text-base min-h-[120px] shadow-sm leading-relaxed"><?= old('description', $assignment['description']) ?></textarea>
                        </div>

                        <!-- Upload Box -->
                        <div class="bg-indigo-50/30 p-5 md:p-8 lg:p-10 rounded-2xl md:rounded-[2.5rem] border-2 border-dashed border-indigo-100 group/upload hover:bg-indigo-50/50 transition-all duration-300">
                            <div class="flex flex-col md:flex-row items-center gap-6 md:gap-8">
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-white rounded-2xl md:rounded-3xl shadow-lg flex items-center justify-center text-indigo-500 shrink-0">
                                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                </div>
                                <div class="flex-1 text-center md:text-left w-full overflow-hidden">
                                    <h4 class="text-sm md:text-base font-black text-indigo-900 uppercase tracking-wider mb-1">Ganti Lampiran</h4>
                                    <p class="text-[9px] md:text-[10px] text-slate-500 font-bold uppercase tracking-tight mb-3">Pilih file baru jika ingin mengganti lampiran saat ini</p>
                                    <input type="file" name="file_upload" class="block w-full text-[10px] text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:bg-indigo-600 file:text-white file:uppercase file:tracking-widest hover:file:bg-indigo-700 transition-all cursor-pointer">
                                </div>
                                <div class="hidden lg:block text-slate-400 font-medium text-right">
                                    <p class="text-[10px] uppercase font-black">Format: PDF, DOCX, IMG, ZIP</p>
                                    <p class="text-[9px] text-slate-300">Maksimal: 5MB</p>
                                </div>
                            </div>
                            
                            <?php if($assignment['file_path']): ?>
                                <div class="mt-6 md:mt-8 p-4 md:p-6 bg-white/80 rounded-2xl md:rounded-3xl border border-indigo-50 flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <div class="flex items-center gap-3 md:gap-4 overflow-hidden w-full">
                                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 shrink-0">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                        </div>
                                        <div class="overflow-hidden">
                                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5 leading-none">File Lampiran Saat Ini</p>
                                            <p class="text-[11px] font-bold text-slate-700 truncate"><?= basename($assignment['file_path']) ?></p>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('uploads/assignments/' . $assignment['file_path']) ?>" target="_blank" class="w-full sm:w-auto text-[9px] font-black text-indigo-600 hover:text-white hover:bg-indigo-600 uppercase tracking-widest border-2 border-indigo-600 px-6 py-2.5 rounded-xl transition-all text-center">Lihat File</a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Footer -->
                        <div class="pt-6 md:pt-10 border-t border-slate-50 flex flex-col md:flex-row items-center justify-between gap-6">
                            <div class="flex flex-col items-center md:items-start gap-1.5">
                                <p class="text-[10px] font-black text-slate-700 uppercase tracking-widest">Terakhir Diperbarui</p>
                                <p class="text-[10px] font-mono text-slate-400 font-bold"><?= date('H:i, d M Y', strtotime($assignment['updated_at'] ?? $assignment['created_at'])) ?></p>
                            </div>
                            
                            <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 md:py-5 px-10 md:px-16 rounded-xl md:rounded-[2rem] transition-all duration-300 shadow-xl shadow-indigo-200 hover:shadow-indigo-300 hover:-translate-y-1 active:scale-95 flex items-center justify-center text-xs md:text-sm tracking-widest uppercase group/btn">
                                <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                SIMPAN PERUBAHAN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>