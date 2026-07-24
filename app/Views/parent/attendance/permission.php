<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <!-- Header Section -->
    <div class="mb-6 md:mb-10 flex flex-col gap-4 animate-in fade-in slide-in-from-top-4 duration-700">
        <nav class="flex overflow-x-auto pb-2 whitespace-nowrap" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[10px] font-bold uppercase tracking-widest">
                <li class="inline-flex items-center">
                    <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Dashboard</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="<?= base_url('parent/attendance') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Kehadiran</a>
                </li>
                <li class="flex items-center text-indigo-600">
                    <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span>Ajukan Izin</span>
                </li>
            </ol>
        </nav>
        
        <div class="flex flex-col gap-1">
            <h3 class="text-slate-800 text-2xl md:text-4xl font-black tracking-tight uppercase leading-tight">Ajukan Izin / Sakit</h3>
            <p class="text-slate-500 text-sm md:text-base font-medium">Unggah bukti keterangan untuk ketidakhadiran siswa.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl md:rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-5 md:p-10">
            <form action="<?= base_url('parent/attendance/submit_permission') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?= csrf_field() ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                    <!-- Date Input -->
                    <div>
                        <label for="date" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tanggal Absensi</label>
                        <input type="date" name="date" id="date" value="<?= date('Y-m-d') ?>" required
                            class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl md:rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-700 text-sm md:text-base">
                    </div>

                    <!-- Status Input -->
                    <div>
                        <label for="status" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Jenis Izin</label>
                        <div class="relative">
                            <select name="status" id="status" required
                                class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl md:rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-700 appearance-none text-sm md:text-base">
                                <option value="I">Izin (Keperluan Keluarga)</option>
                                <option value="S">Sakit (Surat Dokter)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Note/Reason -->
                <div>
                    <label for="note" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Keterangan / Alasan</label>
                    <textarea name="note" id="note" rows="3" placeholder="Sebutkan alasan secara singkat..." required
                        class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl md:rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-slate-700 text-sm md:text-base"></textarea>
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Unggah Bukti (Foto/PDF)</label>
                    <div class="relative group">
                        <input type="file" name="evidence" id="evidence" required accept="image/*,.pdf"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="border-2 border-dashed border-slate-200 bg-slate-50 rounded-2xl md:rounded-3xl p-6 md:p-10 flex flex-col items-center justify-center group-hover:bg-indigo-50/50 group-hover:border-indigo-200 transition-all duration-300">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-white rounded-xl md:rounded-2xl shadow-sm flex items-center justify-center text-indigo-500 mb-3 md:mb-4 group-hover:scale-110 group-hover:shadow-md transition-all duration-300">
                                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-700 mb-1 text-center">Klik untuk pilih file</p>
                            <p class="text-[10px] font-medium text-slate-400 uppercase tracking-tight text-center">PNG, JPG, PDF (Maks. 5MB)</p>
                            
                            <div id="file-name" class="mt-4 hidden animate-in zoom-in duration-300">
                                <span class="px-4 py-2 bg-emerald-500 text-white rounded-full text-[10px] md:text-xs font-bold shadow-lg shadow-emerald-200 flex items-center">
                                    <svg class="w-3 h-3 md:w-4 md:h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span id="name-text">File Terpilih</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 md:gap-4">
                    <a href="<?= base_url('parent/attendance') ?>" 
                       class="w-full sm:w-auto text-center px-8 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl md:rounded-2xl font-bold text-sm transition-all">
                        Batal
                    </a>
                    <button type="submit" 
                        class="w-full sm:w-auto px-10 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl md:rounded-2xl font-bold text-sm shadow-xl shadow-indigo-100 transition-all transform active:scale-95">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Warning Note -->
    <div class="mt-6 bg-amber-50 border border-amber-100 rounded-2xl p-4 md:p-6 flex gap-4">
        <div class="text-amber-500 shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div>
            <h5 class="font-black text-amber-900 text-[11px] md:text-sm tracking-tight uppercase">Informasi Penting</h5>
            <p class="text-amber-700 text-[10px] md:text-xs font-medium mt-1 leading-relaxed">
                Setiap pengajuan akan diverifikasi secara manual oleh pihak sekolah. Pastikan bukti foto atau dokumen terbaca dengan jelas untuk mempercepat proses persetujuan.
            </p>
        </div>
    </div>
</div>

<script>
    document.getElementById('evidence').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : '';
        const fileNameDiv = document.getElementById('file-name');
        const nameText = document.getElementById('name-text');
        
        if (fileName) {
            fileNameDiv.classList.remove('hidden');
            nameText.textContent = fileName.length > 20 ? fileName.substring(0, 17) + '...' : fileName;
        } else {
            fileNameDiv.classList.add('hidden');
        }
    });
</script>
<?= $this->endSection() ?>