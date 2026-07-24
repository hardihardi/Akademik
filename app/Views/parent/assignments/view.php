<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="mb-10">
        <nav class="flex mb-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[10px] font-black uppercase tracking-[0.2em]">
                <li class="inline-flex items-center">
                    <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Dashboard</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="<?= base_url('parent/assignments') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Tugas & Materi</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-indigo-600 font-black">Detail Tugas</span>
                </li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h3 class="text-slate-800 text-4xl font-black tracking-tighter"><?= $assignment['title'] ?></h3>
                <div class="flex flex-wrap items-center gap-2 mt-3">
                    <span class="inline-flex items-center px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase tracking-widest rounded-xl border border-indigo-100">
                        <?= $assignment['subject_name'] ?>
                    </span>
                    <span class="inline-flex items-center px-4 py-1.5 bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-xl border border-slate-100">
                        <?= $assignment['type'] ?? 'Tugas' ?>
                    </span>
                </div>
            </div>
            <div class="flex-shrink-0">
                <a href="<?= base_url('parent/assignments') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-50 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 border border-slate-100 hover:border-indigo-100 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all group">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    KEMBALI KE MODUL
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="flex items-center mb-8 pb-8 border-b border-slate-50">
                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 mr-5">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Diberikan Oleh</p>
                        <p class="text-lg font-black text-slate-800"><?= $assignment['teacher_name'] ?></p>
                    </div>
                </div>

                <div class="prose prose-slate max-w-none">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Instruksi Tugas</p>
                    <div class="text-slate-600 leading-relaxed font-medium">
                        <?= nl2br($assignment['description']) ?>
                    </div>
                </div>

                <?php if($assignment['file_path']): ?>
                    <div class="mt-10 p-6 bg-slate-50 rounded-3xl border border-slate-100 flex items-center justify-between group">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm mr-4">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-800 tracking-tight">Materi/Lampiran Tugas</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Dokumen Pendukung</p>
                            </div>
                        </div>
                        <a href="<?= base_url('assignments/download/' . $assignment['id']) ?>" class="px-5 py-3 bg-white hover:bg-indigo-600 hover:text-white text-indigo-600 rounded-xl text-[10px] font-black transition-all shadow-sm flex items-center">
                            DOWNLOAD
                            <svg class="w-3.5 h-3.5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar / Submission -->
        <div class="space-y-8">
            <!-- Status Card -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Informasi Pengiriman</p>
                
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Batas Waktu</p>
                        <div class="flex items-center text-slate-800">
                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-black tracking-tight"><?= date('d M Y, H:i', strtotime($assignment['deadline'])) ?> WIB</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status Saat Ini</p>
                        <?php if($submission): ?>
                            <div class="inline-flex items-center px-4 py-2 bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-xl border border-emerald-100">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></div>
                                <?= $submission['status'] == 'reviewed' ? 'Telah Dinilai' : 'Sudah Dikirim' ?>
                            </div>
                        <?php else: ?>
                            <div class="inline-flex items-center px-4 py-2 bg-rose-50 text-rose-700 text-[10px] font-black uppercase tracking-widest rounded-xl border border-rose-100">
                                <div class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-2"></div>
                                Belum Dikirim
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($submission && $submission['grade'] !== null): ?>
                        <div class="pt-6 border-t border-slate-50">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 text-center">Hasil Penilaian</p>
                            <div class="text-center">
                                <span class="text-6xl font-black text-indigo-600"><?= $submission['grade'] ?></span>
                                <?php if($submission['feedback']): ?>
                                    <div class="mt-4 p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100/50">
                                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Feedback Guru</p>
                                        <p class="text-xs font-bold text-slate-600 leading-relaxed">"<?= $submission['feedback'] ?>"</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Upload Card -->
            <?php if(!$submission || ($submission['status'] != 'reviewed' && strtotime($assignment['deadline']) > time())): ?>
                <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-xl shadow-indigo-100 text-white">
                    <h4 class="text-xl font-black mb-2 tracking-tight">Kumpulkan Tugas</h4>
                    <p class="text-white/60 text-[10px] font-bold uppercase tracking-widest mb-8"><?= $submission ? 'Perbarui Jawaban' : 'Unggah Hasil Pengerjaan' ?></p>
                    
                    <form id="submission-form" action="<?= base_url('parent/assignments/submit/' . $assignment['id']) ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="space-y-6">
                            <div class="relative group">
                                <input type="file" name="submission_file" id="submission_file" class="hidden" required onchange="updateFileName(this)">
                                <label for="submission_file" class="w-full flex flex-col items-center justify-center p-8 bg-white/10 hover:bg-white/20 border-2 border-dashed border-white/30 rounded-3xl cursor-pointer transition-all group-hover:border-white/60">
                                    <svg class="w-8 h-8 mb-3 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <span id="file-label" class="text-[10px] font-black uppercase tracking-widest text-center leading-snug">Klik untuk pilih file</span>
                                </label>
                            </div>

                            <!-- Progress Bar Container -->
                            <div id="progress-container" class="hidden space-y-3">
                                <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest text-indigo-200">
                                    <span>Mengunggah...</span>
                                    <span id="progress-text">0%</span>
                                </div>
                                <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden px-0.5 flex items-center">
                                    <div id="progress-bar" class="bg-white h-1 rounded-full w-0 transition-all duration-300 shadow-[0_0_10px_rgba(255,255,255,0.5)]"></div>
                                </div>
                            </div>

                            <p class="text-[9px] text-indigo-200 font-bold uppercase tracking-widest text-center">* Maks. 5MB (PDF/JPG/PNG/DOCX)</p>
                            
                            <button type="submit" id="submit-button" class="w-full py-4 bg-white text-indigo-600 rounded-2xl text-xs font-black transition-all hover:scale-[1.02] active:scale-[0.98] shadow-lg uppercase tracking-[0.2em] flex items-center justify-center">
                                KIRIM TUGAS
                                <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            <?php elseif(strtotime($assignment['deadline']) < time() && !$submission): ?>
                <div class="bg-rose-50 p-8 rounded-[2.5rem] border border-rose-100 text-center">
                    <svg class="w-12 h-12 text-rose-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h5 class="text-lg font-black text-rose-800 mb-1 leading-tight">Waktu Habis</h5>
                    <p class="text-xs font-medium text-rose-500">Anda tidak dapat lagi mengirimkan tugas ini karena telah melewati batas waktu.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function updateFileName(input) {
            if (input.files && input.files[0]) {
                document.getElementById('file-label').textContent = input.files[0].name;
            }
        }

        document.getElementById('submission-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            const submitBtn = document.getElementById('submit-button');
            const progressContainer = document.getElementById('progress-container');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');

            // Disable button
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            submitBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-3 text-indigo-600" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                MEMPROSES...
            `;

            // Show progress bar
            progressContainer.classList.remove('hidden');

            xhr.open('POST', form.action, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            // Track progress
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percent + '%';
                    progressText.textContent = percent + '%';
                }
            });

            xhr.onload = function() {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                submitBtn.innerHTML = `
                    KIRIM TUGAS
                    <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                `;

                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OKE',
                                confirmButtonColor: '#4f46e5',
                                customClass: {
                                    popup: 'rounded-[1.5rem]',
                                    confirmButton: 'rounded-xl px-6 py-3 font-black text-xs uppercase transition-all duration-300'
                                }
                            }).then(() => {
                            window.location.href = '<?= base_url('parent/assignments') ?>';
                        });
                        } else {
                            Swal.fire({
                                title: 'Terjadi Kesalahan',
                                text: response.message,
                                icon: 'error',
                                confirmButtonColor: '#f43f5e',
                                customClass: {
                                    popup: 'rounded-[1.5rem]',
                                    confirmButton: 'rounded-xl px-6 py-3 font-black text-xs uppercase'
                                }
                            });
                            progressContainer.classList.add('hidden');
                            progressBar.style.width = '0%';
                            progressText.textContent = '0%';
                        }
                    } catch(e) {
                        console.error('JSON Parse Error:', xhr.responseText);
                        Swal.fire({
                            title: 'Error',
                            text: 'Respon server tidak valid.',
                            icon: 'error',
                            confirmButtonColor: '#f43f5e'
                        });
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonColor: '#f43f5e'
                    });
                }
            };

            xhr.onerror = function() {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal menghubungi server.',
                    icon: 'error',
                    confirmButtonColor: '#f43f5e'
                });
            };

            xhr.send(formData);
        });
    </script>
<?= $this->endSection() ?>
