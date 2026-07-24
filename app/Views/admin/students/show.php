<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb & Back button -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
            <a href="<?= base_url('students') ?>" class="p-2 bg-white rounded-xl shadow-sm border border-slate-200 text-slate-500 hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight"><?= $title ?></h1>
                <p class="text-sm text-slate-500 font-medium">Informasi lengkap data akademik dan personal siswa.</p>
            </div>
        </div>
        
        <?php if(session()->get('role') == 'admin'): ?>
        <div class="flex gap-2">
            <a href="<?= base_url('students/' . $student['id'] . '/edit') ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-indigo-100 flex items-center active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Data
            </a>
        </div>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Sidebar: Profile Identity -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 flex flex-col items-center text-center">
                <div class="relative mb-6">
                    <div class="w-40 h-40 rounded-3xl overflow-hidden border-4 border-indigo-50 shadow-inner">
                        <?php if(!empty($student['photo'])): ?>
                            <img src="<?= get_photo_url($student['photo']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-5xl font-black">
                                <?= substr($student['full_name'], 0, 1) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="absolute -bottom-3 -right-3 bg-emerald-500 text-white p-2.5 rounded-2xl shadow-lg border-4 border-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
                
                <h2 class="text-xl font-black text-slate-800 mb-1"><?= $student['full_name'] ?></h2>
                <p class="text-slate-400 font-mono text-sm mb-4">NIS: <?= $student['nis'] ?></p>
                
                <div class="flex flex-wrap justify-center gap-2 mb-6">
                    <span class="bg-indigo-50 text-indigo-700 px-4 py-1.5 rounded-xl text-xs font-black uppercase tracking-widest border border-indigo-100">
                        Kelas <?= $student['class_name'] ?? '-' ?>
                    </span>
                    <span class="bg-emerald-50 text-emerald-700 px-4 py-1.5 rounded-xl text-xs font-black uppercase tracking-widest border border-emerald-100">
                        <?= $student['status'] ?>
                    </span>
                </div>

                <div class="w-full space-y-3">
                    <a href="<?= base_url('report/print/' . $student['id'] . '?semester=1') ?>" class="flex items-center justify-between p-4 bg-slate-50 hover:bg-slate-100 rounded-2xl transition-colors group">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-slate-400 mr-3 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            <span class="text-sm font-bold text-slate-600">Download Rapor Ganjil</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="<?= base_url('report/print/' . $student['id'] . '?semester=2') ?>" class="flex items-center justify-between p-4 bg-slate-50 hover:bg-slate-100 rounded-2xl transition-colors group">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-slate-400 mr-3 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            <span class="text-sm font-bold text-slate-600">Download Rapor Genap</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Attendance Stats Card -->
             <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Ringkasan Absensi
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <?php 
                    $recap = [
                        'H' => 0, 'S' => 0, 'I' => 0, 'A' => 0
                    ];
                    foreach($attendanceStats as $stat) {
                        if(isset($recap[$stat['status']])) $recap[$stat['status']] = $stat['count'];
                    }
                    ?>
                    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="text-[10px] font-black uppercase text-emerald-600 tracking-wider mb-1">Hadir</div>
                        <div class="text-2xl font-black text-emerald-700"><?= $recap['H'] ?></div>
                    </div>
                    <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                        <div class="text-[10px] font-black uppercase text-blue-600 tracking-wider mb-1">Izin/Sakit</div>
                        <div class="text-2xl font-black text-blue-700"><?= $recap['I'] + $recap['S'] ?></div>
                    </div>
                    <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100">
                        <div class="text-[10px] font-black uppercase text-rose-600 tracking-wider mb-1">Absen/Alfa</div>
                        <div class="text-2xl font-black text-rose-700"><?= $recap['A'] ?></div>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                        <div class="text-[10px] font-black uppercase text-slate-500 tracking-wider mb-1">TA Aktif</div>
                        <div class="text-sm font-black text-slate-700"><?= $activeYear['year'] ?? '-' ?></div>
                    </div>
                </div>
             </div>
        </div>

        <!-- Right Side: Detailed Info -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Basic Information -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-black text-slate-800">Biodata Lengkap</h3>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Tempat, Tanggal Lahir</label>
                            <p class="text-slate-700 font-semibold"><?= $student['birth_place'] ?>, <?= date('d F Y', strtotime($student['birth_date'])) ?></p>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Jenis Kelamin</label>
                            <p class="text-slate-700 font-semibold"><?= ($student['gender'] == 'L') ? 'Laki-laki' : 'Perempuan' ?></p>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Agama</label>
                            <p class="text-slate-700 font-semibold"><?= $student['religion'] ?: '-' ?></p>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">NIS / NISN</label>
                            <p class="text-slate-700 font-semibold"><?= $student['nis'] ?> / <?= $student['nisn'] ?: '-' ?></p>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Nama Orang Tua</label>
                            <p class="text-slate-700 font-semibold"><?= $student['parent_name'] ?: '-' ?></p>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Telepon Orang Tua</label>
                            <p class="text-slate-700 font-semibold"><?= $student['parent_phone'] ?: '-' ?></p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Alamat Domisili</label>
                            <p class="text-slate-700 font-semibold leading-relaxed"><?= $student['address'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Class History Information -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-black text-slate-800">Riwayat Perkembangan Kelas</h3>
                    <span class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border border-indigo-100">Historical Timeline</span>
                </div>
                <div class="p-8">
                    <?php if(empty($history)): ?>
                        <div class="flex flex-col items-center py-10 opacity-40">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-3">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            </div>
                            <p class="text-sm font-bold tracking-tight">Belum ada riwayat kelas yang tercatat.</p>
                        </div>
                    <?php else: ?>
                        <div class="relative space-y-8 before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                            <?php foreach($history as $h): ?>
                            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-100 text-slate-400 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-slate-50/50 p-6 rounded-2xl border border-slate-100 group-hover:bg-white group-hover:shadow-xl group-hover:shadow-indigo-50/50 transition-all duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="font-black text-slate-400 text-[10px] uppercase tracking-widest"><?= $h['academic_year'] ?></div>
                                        <span class="px-2 py-0.5 bg-white border border-slate-100 rounded-lg text-[9px] font-black text-indigo-600 uppercase tracking-widest"><?= $h['class_name'] ?></span>
                                    </div>
                                    <div class="text-slate-800 font-bold text-sm"><?= $h['promotion_status'] ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Note section -->
            <div class="bg-indigo-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-indigo-100">
                <div class="relative z-10">
                    <h3 class="text-xl font-black mb-2">Informasi Penting</h3>
                    <p class="text-indigo-200 text-sm leading-relaxed max-w-lg">Pastikan data NIS dan penempatan kelas sudah sesuai dengan SK pembagian kelas terbaru. Perubahan data master hanya dapat dilakukan oleh Administrator.</p>
                </div>
                <svg class="absolute -right-8 -bottom-8 w-48 h-48 text-indigo-800 opacity-50 transform rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
