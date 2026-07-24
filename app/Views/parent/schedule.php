<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
        <div>
            <nav class="flex mb-3" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[10px] font-black uppercase tracking-[0.2em]">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">Dashboard</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 font-black">Jadwal</span>
                    </li>
                </ol>
            </nav>
            <h3 class="text-slate-800 text-3xl sm:text-4xl lg:text-5xl font-black tracking-tighter">Agenda Belajar</h3>
            <p class="text-slate-500 mt-2 font-medium tracking-tight">Rencana pengajaran mingguan Kelas <strong><?= $student['class_name'] ?></strong></p>
        </div>
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 px-8 py-4 rounded-[2rem] shadow-xl shadow-indigo-100 text-white flex items-center border-4 border-indigo-50">
             <div class="p-2.5 bg-white/20 rounded-xl mr-4 backdrop-blur-sm">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
             </div>
             <div>
                <span class="block text-[10px] font-black text-indigo-200 uppercase tracking-widest leading-none mb-1">Tahun Ajaran</span>
                <span class="text-xl font-black tracking-tighter leading-none">2024 / 2025</span>
             </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-8 mb-12">
        <?php 
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
            $icons = [
                'Senin' => 'blue',
                'Selasa' => 'emerald',
                'Rabu' => 'amber',
                'Kamis' => 'purple',
                'Jumat' => 'rose'
            ];
            
            $daySubjects = [];
            $allSubjects = array_column($subjects, 'name');
            if (empty($allSubjects)) $allSubjects = ['Pendidikan Agama', 'Matematika', 'B. Indonesia', 'B. Inggris', 'Sains', 'Seni Budaya'];
            
            foreach($days as $day) {
                shuffle($allSubjects);
                $daySubjects[$day] = array_slice($allSubjects, 0, 3);
            }
        ?>

        <?php foreach($days as $day): ?>
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden flex flex-col group hover:shadow-2xl hover:translate-y-[-8px] transition-all duration-500">
                <div class="bg-<?= $icons[$day] ?>-50/50 px-6 py-6 border-b border-<?= $icons[$day] ?>-100 text-center group-hover:bg-<?= $icons[$day] ?>-100 transition-colors">
                    <h4 class="font-black text-<?= $icons[$day] ?>-700 text-2xl tracking-tighter uppercase"><?= $day ?></h4>
                </div>
                <div class="p-6 space-y-4 flex-grow bg-white">
                    <?php $times = ['07:30 - 09:00', '09:30 - 11:00', '11:00 - 12:30']; ?>
                    <?php foreach($daySubjects[$day] as $idx => $subj): ?>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 shadow-sm group/item hover:bg-white hover:border-indigo-200 hover:shadow-md transition-all duration-300">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover/item:text-indigo-400 transition-colors"><?= $times[$idx] ?></p>
                            <p class="font-black text-slate-800 tracking-tight group-hover/item:text-indigo-700 transition-colors line-clamp-1"><?= $subj ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="p-4 bg-slate-50/50 border-t border-slate-100">
                     <p class="text-[9px] text-center text-slate-400 uppercase font-black tracking-widest group-hover:text-slate-600 transition-colors">Pulang: 12:30 WIB</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Note Box -->
    <div class="mt-8 bg-white border border-slate-100 shadow-sm rounded-[2rem] p-8 flex flex-col md:flex-row items-center md:items-start text-center md:text-left gap-6 hover:shadow-md transition-shadow duration-300">
        <div class="p-5 bg-amber-50 rounded-[1.5rem] text-amber-500 shadow-inner border border-amber-100 shrink-0">
             <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="flex-grow">
            <h5 class="text-2xl font-black text-slate-800 mb-2 mt-1 tracking-tight">Catatan Akademik</h5>
            <p class="text-slate-500 text-base leading-relaxed font-medium">
                Jadwal di atas adalah rutinitas pembelajaran harian yang berlaku selama satu semester. Untuk perubahan jadwal dikarenakan kegiatan sekolah, libur nasional, atau agenda lainnya, silakan pantau secara rutin menu <a href="<?= base_url('parent/announcements') ?>" class="text-indigo-600 font-bold hover:underline">Pengumuman Terintegrasi</a> atau melalui kanal komunikasi resmi sekolah.
            </p>
        </div>
    </div>

<?= $this->endSection() ?>
