<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6 uppercase tracking-widest">
    <div>
        <nav class="flex mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[10px] font-black">
                <li class="inline-flex items-center">
                    <a href="<?= base_url('teachers') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Manajemen Guru</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-indigo-600">Profil Guru</span>
                </li>
            </ol>
        </nav>
        <h3 class="text-slate-800 text-4xl font-black tracking-tight normal-case">Detail Profil Tenaga Pendidik</h3>
        <p class="text-slate-500 mt-2 font-medium normal-case">Informasi lengkap, riwayat mengajar, dan penugasan akademik.</p>
    </div>
    <div class="flex gap-3">
        <a href="<?= base_url('teachers/' . $teacher['id'] . '/edit') ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-xs shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all duration-300">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            Edit Profil
        </a>
        <a href="<?= base_url('teachers') ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-slate-50 text-slate-500 font-bold text-xs border border-slate-100 hover:bg-white hover:shadow-md transition-all duration-300">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
    <!-- Profile Card (Left) -->
    <div class="lg:col-span-1 space-y-8">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative group">
            <div class="h-32 bg-gradient-to-br from-indigo-500 to-indigo-700"></div>
            <div class="px-8 pb-8 -mt-16 relative">
                <div class="flex justify-center mb-6">
                    <div class="w-32 h-32 rounded-[2.5rem] bg-white p-1 shadow-xl">
                        <div class="w-full h-full rounded-[2.2rem] bg-slate-50 overflow-hidden flex items-center justify-center">
                            <?php if(!empty($teacher['photo'])): ?>
                                <img src="<?= get_photo_url($teacher['photo']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-indigo-600 font-black text-4xl"><?= substr($teacher['full_name'], 0, 1) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <h4 class="text-xl font-black text-slate-800 tracking-tight"><?= $teacher['full_name'] ?></h4>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">NIP: <?= $teacher['nip'] ?></p>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-0.5">NUPTK: <?= $teacher['nuptk'] ?: '-' ?></p>
                    <div class="mt-4 flex justify-center">
                        <?php if($teacher['status'] == 'Aktif'): ?>
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-lg border border-emerald-100 uppercase tracking-wider">Status: Aktif</span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-black rounded-lg border border-rose-100 uppercase tracking-wider">Status: Non-Aktif</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-8 space-y-4 pt-8 border-t border-slate-50">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 text-indigo-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 21a9.003 9.003 0 008.315-5.647L16 11.315V7a1 1 0 10-2 0v4.243l-4.243 4.242a1 1 0 101.415 1.415L14 13.914V11a1 1 0 112 0v2.914l4.243-4.243a1 1 0 00-1.415-1.415L14.586 12.5a9 9 0 10-2.586 8.5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 12a3 3 0 100-6 3 3 0 000 6z" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Agama</p>
                            <p class="text-sm font-bold text-slate-700"><?= $teacher['religion'] ?: '-' ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Telepon</p>
                            <p class="text-sm font-bold text-slate-700"><?= $teacher['phone'] ?: '-' ?></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center mt-1">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Alamat</p>
                            <p class="text-sm font-bold text-slate-700 leading-relaxed"><?= $teacher['address'] ?: 'Alamat belum diatur' ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Sync Info -->
        <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-indigo-100 flex items-center gap-6">
            <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0 border border-white/30 backdrop-blur-sm">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 3c1.288 0 2.514.24 3.644.678" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest">Akun Sistem</p>
                <p class="text-xs font-bold mt-1 opacity-90">Terhubung secara otomatis dengan akun login di platform akademik.</p>
            </div>
        </div>
    </div>

    <!-- Assignments & History (Right) -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Current Assignments -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                <div>
                    <h4 class="font-black text-slate-800 tracking-tight">Penugasan Saat Ini</h4>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Tahun Pelajaran: <?= $activeYear['year'] ?? '-' ?> (<?= $activeYear['semester'] ?? '-' ?>)</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
            </div>
            <div class="p-8">
                <?php if(empty($currentAssignments)): ?>
                    <div class="flex flex-col items-center py-6 text-slate-400">
                        <svg class="w-12 h-12 mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <p class="text-xs font-bold">Belum ada mata pelajaran yang diampu semester ini.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach($currentAssignments as $asgn): ?>
                            <div class="p-5 rounded-3xl bg-slate-50 border-2 border-slate-100 flex items-center gap-4 hover:border-indigo-100 hover:bg-white transition-all duration-300">
                                <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-indigo-600 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800 tracking-tight"><?= $asgn['subject_name'] ?></p>
                                    <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mt-0.5">Kelas <?= $asgn['class_name'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- History -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                <div>
                    <h4 class="font-black text-slate-800 tracking-tight">Histori Mengajar</h4>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Rekam Jejak Akademik Seluruh Periode</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <div class="p-8">
                <?php if(empty($history)): ?>
                    <p class="text-center py-6 text-slate-400 text-xs font-bold uppercase tracking-widest">Belum ada riwayat mengajar tersimpan.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php 
                        $currentYear = '';
                        $isFirst = true;
                        foreach($history as $index => $h): 
                            if($currentYear != $h['year'] . ' - ' . $h['semester']):
                                $currentYear = $h['year'] . ' - ' . $h['semester'];
                        ?>
                            <details class="group bg-white border border-slate-100 rounded-3xl overflow-hidden transition-all duration-300 hover:border-indigo-200 shadow-sm" <?= $isFirst ? 'open' : '' ?>>
                                <summary class="flex items-center justify-between p-6 cursor-pointer hover:bg-slate-50 transition-colors list-none outline-none">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shadow-sm">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                        <div>
                                            <h5 class="text-xs font-black text-slate-800 uppercase tracking-widest"><?= $currentYear ?></h5>
                                            <?php 
                                            // Count subjects in this period
                                            $count = 0;
                                            foreach($history as $item) if($item['year'] . ' - ' . $item['semester'] == $currentYear) $count++;
                                            ?>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter mt-0.5"><?= $count ?> Mata Pelajaran Diampu</p>
                                        </div>
                                    </div>
                                    <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 transition-transform duration-300 group-open:rotate-180 group-open:bg-indigo-600 group-open:text-white group-open:shadow-lg group-open:shadow-indigo-100">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </summary>
                                <div class="px-6 pb-6 pt-2">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 border-t border-slate-50 pt-6">
                        <?php 
                            $isFirst = false;
                            endif; ?>

                            <div class="p-4 rounded-2xl border border-slate-50 bg-slate-50/50 flex items-center justify-between group/item hover:bg-white hover:border-indigo-100 hover:shadow-sm transition-all duration-300">
                                <div>
                                    <p class="text-xs font-black text-slate-700 uppercase tracking-tight"><?= $h['subject_name'] ?></p>
                                    <p class="text-[10px] font-bold text-slate-400">Kelas <?= $h['class_name'] ?></p>
                                </div>
                                <span class="w-6 h-6 rounded-lg bg-white shadow-inner flex items-center justify-center text-slate-200 group-hover/item:text-emerald-500 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4" /></svg>
                                </span>
                            </div>

                        <?php 
                            $next = $history[$index + 1] ?? null;
                            if(!$next || ($next['year'] . ' - ' . $next['semester']) != $currentYear):
                        ?>
                                    </div>
                                </div>
                            </details>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<style>
    /* Remove default details arrow */
    details summary::-webkit-details-marker { display: none; }
    details summary { list-style: none; }
</style>
<?= $this->endSection() ?>
