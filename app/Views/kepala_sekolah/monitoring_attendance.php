<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Monitoring Absensi Harian</h1>
            <p class="text-gray-500 text-sm">Rekapitulasi kehadiran siswa sekolah hari ini.</p>
        </div>
        
        <form action="<?= base_url('kepsek/monitoring/attendance') ?>" method="get" class="flex gap-2">
            <input type="date" name="date" value="<?= $selectedDate ?>" class="px-4 py-2 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm font-semibold text-gray-700 shadow-sm">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl transition-all shadow-md active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach($attendanceData as $class): ?>
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-black text-slate-800 text-xl">Kelas <?= $class['name'] ?></h3>
                <div class="text-right">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Partisipasi</span>
                    <span class="text-sm font-bold text-indigo-600">
                        <?= $class['total_students'] > 0 ? round(($class['total_present'] / $class['total_students']) * 100) : 0 ?>%
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-4 gap-2 mb-6">
                <div class="bg-green-50 rounded-xl p-2 text-center border border-green-100">
                    <span class="block text-green-700 font-black text-lg"><?= $class['stats']['H'] ?></span>
                    <span class="text-[9px] font-bold text-green-600 uppercase">Hadir</span>
                </div>
                <div class="bg-amber-50 rounded-xl p-2 text-center border border-amber-100">
                    <span class="block text-amber-700 font-black text-lg"><?= $class['stats']['S'] ?></span>
                    <span class="text-[9px] font-bold text-amber-600 uppercase">Sakit</span>
                </div>
                <div class="bg-blue-50 rounded-xl p-2 text-center border border-blue-100">
                    <span class="block text-blue-700 font-black text-lg"><?= $class['stats']['I'] ?></span>
                    <span class="text-[9px] font-bold text-blue-600 uppercase">Izin</span>
                </div>
                <div class="bg-red-50 rounded-xl p-2 text-center border border-red-100">
                    <span class="block text-red-700 font-black text-lg"><?= $class['stats']['A'] ?></span>
                    <span class="text-[9px] font-bold text-red-600 uppercase">Alfa</span>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50 flex justify-between items-center">
                <span class="text-xs text-slate-400 font-medium tracking-tight">Total: <?= $class['total_students'] ?> Siswa</span>
                <a href="<?= base_url('attendance-recap/view/' . $class['id']) ?>" class="text-indigo-600 hover:text-indigo-800 text-[10px] font-bold flex items-center group">
                    DETAIL
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>
