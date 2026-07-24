<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-4 md:p-8 lg:p-10 space-y-6 md:space-y-8 animate-in fade-in slide-in-from-bottom-6 duration-700">
    
    <!-- Header Section -->
    <div class="bg-white rounded-3xl md:rounded-[2rem] p-5 md:p-8 shadow-sm border border-slate-100 relative overflow-hidden">
        <!-- Decorative Circle Background -->
        <div class="absolute -right-20 -top-20 w-48 md:w-64 h-48 md:h-64 bg-slate-50 rounded-full"></div>
        
        <div class="relative">
            <!-- Container Header: Menggunakan Flex untuk posisi kanan-kiri -->
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-5">
                
                <!-- Sisi Kiri: Informasi Judul -->
                <div class="flex-1 order-2 lg:order-1">
                    <div class="flex items-center gap-2 text-[11px] md:text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-3">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m3.243-4.243a4.49 4.49 0 016.364 0m-6.364 0a4.49 4.49 0 010 6.364m6.364-6.364a4.49 4.49 0 010 6.364" />
                        </svg>
                        <span>Akademik</span>
                    </div>
                    
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-slate-700 tracking-tight leading-tight uppercase">
                        Laporan Hasil Belajar
                    </h1>
                    
                    <p class="text-slate-500 text-sm md:text-base font-bold mt-2 leading-relaxed">
                        Pilih tahun akademik rapor <span class="text-indigo-600 font-black">"<?= $student['full_name'] ?>"</span>
                    </p>
                </div>

                <!-- Sisi Kanan: Badge TA Aktif -->
                <?php if($activeYear): ?>
                <div class="flex-shrink-0 order-1 lg:order-2 self-start">
                    <div class="inline-flex items-center px-4 py-2.5 bg-indigo-50 text-indigo-600 rounded-2xl border border-indigo-100 shadow-sm shadow-indigo-100/50 group/badge">
                        <span class="relative flex h-2.5 w-2.5 mr-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-600"></span>
                        </span>
                        <div class="flex flex-col items-start leading-none">
                            <span class="text-[9px] font-black uppercase tracking-[0.15em] opacity-70 mb-1">Tahun Pelajaran Aktif</span>
                            <span class="text-xs md:text-sm font-black uppercase tracking-wider">
                                <?= $activeYear['year'] ?> (<?= ($activeYear['semester'] == '1' || $activeYear['semester'] == 'Ganjil') ? 'Ganjil' : 'Genap' ?>)
                            </span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Info Notice -->
    <div class="bg-indigo-600 rounded-3xl p-5 md:p-6 text-white shadow-xl shadow-indigo-100 flex flex-col md:flex-row items-center gap-4 md:gap-6 relative overflow-hidden group">
        <div class="absolute -right-10 -top-10 w-32 md:w-48 h-32 md:h-48 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-700"></div>
        
        <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0 backdrop-blur-sm">
            <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        
        <div class="flex-1 text-center md:text-left z-10">
            <h3 class="font-black text-base md:text-lg tracking-tight uppercase leading-tight mb-1">Penting: Penilaian Kurikulum SD</h3>
            <p class="text-indigo-100 text-xs md:text-sm font-medium leading-relaxed opacity-95">
                Format rapor standar SD: Penilaian Harian (40%), UTS (30%), dan UAS (30%).
            </p>
        </div>
    </div>

    <!-- Reports Grid Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 md:gap-8">
        <?php if(!empty($academicYears)): ?>
            <?php foreach($academicYears as $year): ?>
            <?php 
                $isActive = ($year['status'] == 'Active' || (isset($activeYear) && $year['id'] == $activeYear['id']));
            ?>
            <div class="group relative flex flex-col bg-white rounded-[2.5rem] p-1 shadow-sm hover:shadow-2xl hover:shadow-indigo-100/40 transition-all duration-500 border border-slate-100 overflow-hidden">
                <!-- Status Badge (Floating) -->
                <?php if($isActive): ?>
                <div class="absolute top-6 right-6 z-20">
                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500 text-white text-[9px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-emerald-200 animate-in zoom-in duration-700">
                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                        Aktif
                    </span>
                </div>
                <?php endif; ?>

                <!-- Card Content -->
                <div class="p-7 md:p-9 flex flex-col h-full relative z-10">
                    <!-- Icon Box -->
                    <div class="w-16 h-16 rounded-[1.5rem] bg-slate-50 flex items-center justify-center mb-8 group-hover:bg-indigo-600 group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-inner">
                        <svg class="w-8 h-8 text-indigo-500 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-3xl md:text-4xl font-black text-slate-800 tracking-tighter mb-2 group-hover:text-indigo-600 transition-colors duration-300">
                            <?= $year['year'] ?>
                        </h3>
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Semester <?= $year['semester'] ?></span>
                            <span class="w-1.5 h-1.5 bg-slate-200 rounded-full"></span>
                            <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Digital Report</span>
                        </div>
                        
                        <!-- Mini Stats/Info -->
                        <div class="mt-8 grid grid-cols-2 gap-4">
                            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100/50">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Format</p>
                                <p class="text-[10px] font-black text-slate-700 uppercase">PDF Letter</p>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100/50">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Status</p>
                                <p class="text-[10px] font-black text-emerald-600 uppercase">Tersedia</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-10">
                        <a href="<?= base_url('parent/reports/download/' . $year['id']) ?>" 
                           class="group/btn relative flex items-center justify-between w-full p-1 bg-slate-50 hover:bg-indigo-600 rounded-2xl transition-all duration-500 shadow-inner overflow-hidden">
                            <span class="ml-6 py-4 text-[11px] font-black text-slate-600 group-hover/btn:text-white uppercase tracking-[0.2em] transition-colors duration-500">Unduh Rapor</span>
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-md group-hover/btn:rotate-90 transition-all duration-500">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            
                            <!-- Button Hover Effect -->
                            <div class="absolute inset-0 bg-white/20 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-1000"></div>
                        </a>
                    </div>
                </div>

                <!-- Abstract Decorative Patterns -->
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-indigo-50/50 rounded-full blur-3xl group-hover:bg-indigo-100/50 transition-colors duration-500"></div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Empty State -->
            <div class="col-span-full py-20 px-10 bg-white rounded-[3rem] text-center border-4 border-dashed border-slate-50 flex flex-col items-center">
                <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mb-8 mb-8 border border-slate-100 shadow-inner">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-700 uppercase tracking-tight mb-2">Data Rapor Belum Tersedia</h3>
                <p class="text-slate-400 font-bold max-w-md mx-auto leading-relaxed">Sistem belum menemukan data tahun akademik atau semester untuk diunduh. Silakan hubungi admin sekolah jika ini adalah kesalahan.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Help Notice -->
    <div class="pt-8 md:pt-12 border-t border-slate-50">
        <p class="text-center text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-[0.2em] leading-relaxed">
            Butuh bantuan? Silahkan hubungi <span class="text-indigo-500 font-black border-b-2 border-indigo-100 pb-0.5">Tata Usaha Sekolah</span> atau Wali Kelas masing-masing.
        </p>
    </div>

</div>
<?= $this->endSection() ?>