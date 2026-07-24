<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-4 sm:p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-top-4 duration-700">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <a href="<?= base_url('students') ?>" class="hover:text-indigo-600 transition-colors uppercase">DATA SISWA</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase font-black tracking-widest">IMPORT SISWA</span>
            </div>
            <h1 class="text-4xl font-black text-slate-800 tracking-tight leading-none uppercase"><?= $title ?></h1>
            <p class="text-slate-500 font-medium">Unggah file CSV untuk mengimpor data siswa secara massal ke dalam sistem.</p>
        </div>
        <a href="<?= base_url('students') ?>" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-white border border-slate-200 text-slate-500 font-black text-[10px] tracking-widest shadow-sm hover:bg-slate-50 hover:text-indigo-600 transition-all duration-300 uppercase shrink-0">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            KEMBALI KE DATA SISWA
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Instructions Card -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-indigo-50 border border-indigo-100 rounded-[2rem] p-8 space-y-6 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-100/50 rounded-full blur-3xl"></div>
                
                <div class="flex items-center gap-4 relative">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-50">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-indigo-900 uppercase tracking-tight">Instruksi Import</h4>
                        <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mt-1">Panduan Penggunaan</p>
                    </div>
                </div>

                <div class="space-y-4 pt-2 relative">
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-[10px] font-black">1</span>
                            <p class="text-[11px] text-indigo-700 leading-relaxed font-bold uppercase">Gunakan file format <span class="text-indigo-900">.csv</span> saja.</p>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-[10px] font-black">2</span>
                            <p class="text-[11px] text-indigo-700 leading-relaxed font-bold uppercase">Nama kelas harus terdaftar (Contoh: <span class="text-indigo-900">1-A</span>, <span class="text-indigo-900">2-B</span>).</p>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-[10px] font-black">3</span>
                            <p class="text-[11px] text-indigo-700 leading-relaxed font-bold uppercase">Format tanggal lahir: <span class="text-indigo-900 font-mono">YYYY-MM-DD</span>.</p>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-[10px] font-black">4</span>
                            <p class="text-[11px] text-indigo-700 leading-relaxed font-bold uppercase">NIS harus <span class="text-indigo-900 font-black">UNIK</span> dan belum ada di sistem.</p>
                        </li>
                    </ul>
                </div>

                <div class="pt-4 relative border-t border-indigo-100">
                    <a href="<?= base_url('students/import/template') ?>" class="group flex items-center justify-between p-4 bg-white/60 hover:bg-white rounded-2xl border border-indigo-100 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </div>
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Download Template</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-300 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Import Form Card -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative min-h-[400px]">
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-slate-50 rounded-full -z-0 opacity-50"></div>
                
                <form action="<?= base_url('students/import/process') ?>" method="post" enctype="multipart/form-data" class="p-8 md:p-12 relative z-10 flex flex-col items-center justify-center h-full min-h-[400px]">
                    <?= csrf_field() ?>
                    
                    <div class="w-full max-w-xl mx-auto space-y-10">
                        <div class="text-center space-y-4">
                            <div class="inline-flex items-center px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-emerald-100">Ready to Import</div>
                            <h2 class="text-2xl font-black text-slate-800 tracking-tight leading-none uppercase">Pilih File Data Siswa</h2>
                            <p class="text-slate-400 font-bold text-xs">Pastikan data Anda sudah sesuai dengan template yang disediakan.</p>
                        </div>

                        <div class="relative group" onclick="document.getElementById('csv_file').click()">
                            <input id="csv_file" name="csv_file" type="file" class="hidden" accept=".csv" required onchange="handleFileSelect(this)">
                            
                            <div id="dropzone" class="border-[3px] border-dashed border-slate-200 rounded-[2rem] p-12 text-center cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/30 transition-all duration-300 group-hover:-translate-y-1">
                                <div class="space-y-6">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] mx-auto flex items-center justify-center text-slate-300 group-hover:bg-indigo-100 group-hover:text-indigo-500 group-hover:scale-110 transition-all duration-500 shadow-sm border border-slate-100 group-hover:border-indigo-200">
                                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm font-black text-slate-700 uppercase tracking-tight">Klik atau Drag File Ke Sini</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">HANYA FILE .CSV (MAKS. 2MB)</p>
                                    </div>
                                    <div id="file-info" class="hidden bg-emerald-50 border border-emerald-100 rounded-2xl p-4 flex items-center justify-center gap-3 animate-in zoom-in-95 duration-300">
                                        <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <span id="file-name-display" class="text-[10px] font-black text-emerald-700 uppercase tracking-widest truncate max-w-[200px]"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center pt-6">
                            <button id="submit-btn" class="w-full sm:w-auto px-10 py-5 bg-indigo-600 text-white font-black text-xs tracking-widest rounded-3xl shadow-2xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all duration-300 uppercase disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                MULAI PROSES IMPORT
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function handleFileSelect(input) {
    const file = input.files[0];
    const fileInfo = document.getElementById('file-info');
    const fileNameDisplay = document.getElementById('file-name-display');
    const dropzone = document.getElementById('dropzone');
    const submitBtn = document.getElementById('submit-btn');

    if (file) {
        fileNameDisplay.textContent = file.name;
        fileInfo.classList.remove('hidden');
        dropzone.classList.add('border-emerald-400', 'bg-emerald-50/20');
        dropzone.classList.remove('border-slate-200');
        
        // Add subtle animation to button
        submitBtn.classList.add('animate-bounce-once');
        setTimeout(() => submitBtn.classList.remove('animate-bounce-once'), 1000);
    } else {
        fileInfo.classList.add('hidden');
        dropzone.classList.remove('border-emerald-400', 'bg-emerald-50/20');
        dropzone.classList.add('border-slate-200');
    }
}
</script>

<style>
@keyframes bounce-once {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-4px); }
}
.animate-bounce-once {
    animation: bounce-once 0.5s ease-in-out;
}
</style>
<?= $this->endSection() ?>
