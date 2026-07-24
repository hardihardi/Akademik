<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-3 sm:p-6 lg:p-10 space-y-6 sm:space-y-8 animate-in fade-in slide-in-from-bottom-6 duration-700">
    
    <!-- Header & Navigation -->
    <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-8 shadow-sm border border-slate-100 relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-48 sm:w-64 h-48 sm:h-64 bg-slate-50 rounded-full opacity-50"></div>
        <div class="relative">
            <nav class="flex mb-4 text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em]" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">DASHBOARD</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="<?= base_url('attendance') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">KEHADIRAN</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600">INPUT KEHADIRAN</span>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-2xl sm:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase">Input Kehadiran <?= $class['name'] ?></h1>
                    <p class="text-slate-500 font-bold mt-2 text-sm sm:text-base uppercase tracking-tight">Tahun Akademik: <span class="text-indigo-600"><?= $class['academic_year'] ?></span></p>
                </div>
                <div class="flex-shrink-0">
                    <a href="<?= base_url('attendance') ?>" class="inline-flex items-center justify-center w-full sm:w-auto gap-2 px-5 py-3 bg-slate-50 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 border border-slate-100 hover:border-indigo-100 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all group">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        KEMBALI KE MODUL
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Selection Card -->
    <div class="bg-white rounded-[1.5rem] sm:rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100 animate-in fade-in slide-in-from-top-4 duration-500 delay-150">
        <form action="<?= base_url('attendance/input/' . $class['id']) ?>" method="get" class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex-1 w-full sm:max-w-xs">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Pilih Tanggal Kehadiran</label>
                <div class="relative group">
                    <input type="date" name="date" value="<?= $date ?>" 
                           class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl font-black text-slate-700 outline-none focus:border-indigo-500 focus:bg-white transition-all duration-300 shadow-sm group-hover:border-slate-200"
                           onchange="this.form.submit()">
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300 group-focus-within:text-indigo-500 transition-colors hidden sm:block">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                </div>
            </div>
            <div class="flex-1 sm:max-w-md">
                <div class="flex items-center gap-4 p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100/50 text-indigo-600">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-widest leading-relaxed">
                        Data kehadiran akan diperbarui secara otomatis sesuai dengan tanggal yang Anda tentukan.
                    </p>
                </div>
            </div>
        </form>
    </div>

    <!-- Attendance Form Card -->
    <div class="bg-white rounded-[1.5rem] sm:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden animate-in fade-in slide-in-from-bottom-6 duration-700 delay-300">
        <!-- Card Header Info -->
        <div class="p-5 sm:p-8 bg-slate-50/50 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-5">
            <div class="flex items-center gap-4 self-start sm:self-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-indigo-600 shadow-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-black text-slate-800 tracking-tight uppercase">Daftar Siswa</h3>
                    <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5"><?= count($students) ?> Siswa Terdaftar</p>
                </div>
            </div>
            
            <button type="button" onclick="setAllPresent()" 
                    class="w-full sm:w-auto px-6 py-3.5 bg-white border-2 border-slate-100 text-[10px] font-black text-indigo-600 uppercase tracking-widest rounded-xl sm:rounded-2xl hover:border-indigo-600 hover:shadow-lg transition-all shadow-sm active:scale-95 group">
                SET SEMUA HADIR (H)
            </button>
        </div>

        <form action="<?= base_url('attendance/store') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
            <input type="hidden" name="date" value="<?= $date ?>">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr class="bg-indigo-50/50">
                            <th class="px-4 sm:px-6 py-5 text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-100 w-16 text-center">No.</th>
                            <th class="px-4 sm:px-6 py-5 text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-100 sticky left-0 bg-indigo-50 z-20 shadow-[2px_0_5px_rgba(0,0,0,0.02)]">Nama Siswa</th>
                            <th class="px-4 sm:px-6 py-5 text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-100 text-center">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if(empty($students)): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center opacity-50">
                                        <svg class="w-16 h-16 text-slate-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                        <p class="text-sm font-bold text-slate-400 uppercase">Tidak ada data siswa untuk kelas ini.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $i = 1; foreach($students as $student): 
                                $studentId = $student['id'];
                                $attRecord = $attendanceMap[$studentId] ?? null;
                                $currentStatus = $attRecord['status'] ?? '';
                            ?>
                            <tr class="group hover:bg-slate-50 transition-colors">
                                <td class="px-4 sm:px-6 py-5 text-xs font-black text-slate-400 text-center group-hover:text-slate-600"><?= $i++ ?></td>
                                <td class="px-4 sm:px-6 py-5 border-r border-slate-50 sticky left-0 bg-white z-10 group-hover:bg-slate-50 transition-colors shadow-[2px_0_5px_rgba(0,0,0,0.02)]">
                                    <div class="flex items-center gap-3">
                                        <div class="hidden sm:flex w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 items-center justify-center text-[10px] font-black flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                            <?= strtoupper(substr($student['full_name'], 0, 1)) ?>
                                        </div>
                                        <div class="min-w-[140px]">
                                            <p class="text-[11px] sm:text-xs font-black text-slate-700 tracking-tight leading-none mb-1 group-hover:text-indigo-600 transition-colors uppercase"><?= $student['full_name'] ?></p>
                                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">NIS: <?= $student['nis'] ?: '-' ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-5 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="inline-flex p-1 bg-slate-100 rounded-2xl shadow-inner">
                                            <!-- STATUS OPTION TEMPLATE -->
                                            <?php 
                                            $statuses = [
                                                'H' => ['label' => 'HADIR', 'color' => 'peer-checked:bg-emerald-500 peer-checked:shadow-emerald-200'],
                                                'I' => ['label' => 'IZIN', 'color' => 'peer-checked:bg-sky-500 peer-checked:shadow-sky-200'],
                                                'S' => ['label' => 'SAKIT', 'color' => 'peer-checked:bg-amber-500 peer-checked:shadow-amber-200'],
                                                'A' => ['label' => 'ALPHA', 'color' => 'peer-checked:bg-rose-500 peer-checked:shadow-rose-200'],
                                            ];
                                            foreach($statuses as $code => $data): ?>
                                            <label class="relative cursor-pointer group/opt">
                                                <input type="radio" name="attendance[<?= $studentId ?>]" value="<?= $code ?>" 
                                                       class="peer sr-only <?= $code == 'H' ? 'att-radio' : '' ?>" 
                                                       <?= $currentStatus == $code ? 'checked' : '' ?>>
                                                <span class="w-12 sm:w-16 h-10 sm:h-12 flex flex-col items-center justify-center rounded-xl sm:rounded-[14px] bg-transparent text-slate-400 text-[10px] font-black transition-all <?= $data['color'] ?> peer-checked:text-white peer-checked:shadow-lg group-hover/opt:bg-white/50">
                                                    <span class="leading-none"><?= $code ?></span>
                                                    <span class="text-[7px] hidden sm:block mt-0.5 opacity-0 peer-checked:opacity-100 transition-opacity"><?= $data['label'] ?></span>
                                                </span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>

                                        <?php if($attRecord && $attRecord['evidence_path']): ?>
                                            <div class="flex items-center gap-3 bg-white px-3 py-2 rounded-xl border border-slate-100 shadow-sm">
                                                <a href="<?= base_url('uploads/attendance/' . $attRecord['evidence_path']) ?>" target="_blank" class="text-[9px] font-black text-indigo-600 hover:text-indigo-800 flex items-center gap-1 uppercase tracking-widest transition-colors">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                    BUKTI
                                                </a>
                                                <div class="h-3 w-px bg-slate-200"></div>
                                                <label class="flex items-center gap-1.5 cursor-pointer">
                                                    <input type="checkbox" name="verified[<?= $studentId ?>]" value="1" <?= $attRecord['is_verified'] ? 'checked' : '' ?> class="w-3.5 h-3.5 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">VERIFIKASI</span>
                                                </label>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(!empty($students)): ?>
            <div class="p-6 sm:p-10 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center sm:text-left">
                    <svg class="w-5 h-5 text-indigo-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Pastikan semua data sudah terisi dengan benar.
                </div>
                <button type="submit" 
                        class="w-full sm:w-auto px-10 py-4.5 bg-indigo-600 text-white rounded-2xl text-[11px] font-black tracking-widest uppercase shadow-2xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all duration-300">
                    SIMPAN DATA KEHADIRAN
                </button>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<script>
    function setAllPresent() {
        const radios = document.querySelectorAll('.att-radio[value="H"]');
        radios.forEach(radio => {
            radio.checked = true;
        });
    }
</script>

<style>
    /* Reset all possible italics */
    * { font-style: normal !important; }

    /* Custom date picker premium look */
    input[type="date"]::-webkit-calendar-picker-indicator {
        background-color: transparent;
        cursor: pointer;
        opacity: 0.4;
        filter: invert(0.2);
    }

    /* Column Shadow for Sticky Column on Mobile */
    @media (max-width: 640px) {
        .sticky {
            background-color: white !important;
        }
        tr:hover .sticky {
            background-color: #f8fafc !important; /* slate-50 */
        }
    }

    /* Padding adjustment for submit button */
    .py-4\.5 { padding-top: 1.125rem; padding-bottom: 1.125rem; }
</style>

<?= $this->endSection() ?>