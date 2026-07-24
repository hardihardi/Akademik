<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-10 lg:mb-16 flex flex-col lg:flex-row lg:items-center justify-between gap-6 lg:gap-12">
    <div class="flex-1 min-w-0">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-widest mb-4">
            <i class="ph-bold ph-calendar-check"></i>
            T.A <?= $activeYear['year'] ?? '-' ?> - <?= $activeYear['semester'] ?? '-' ?>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight uppercase leading-tight">
            <?= $title ?>
        </h1>
        <p class="text-slate-500 mt-2 text-xs sm:text-sm font-medium leading-relaxed max-w-2xl capitalize">
            Pilih kelas untuk melihat ringkasan partisipasi kehadiran siswa secara mendalam.
        </p>
    </div>

    <!-- Global Action & Search -->
    <div class="w-full lg:w-auto">
        <form action="<?= base_url('attendance-recap') ?>" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1 sm:w-80">
                <input type="text" name="search" value="<?= $filters['search'] ?? '' ?>" placeholder="Cari nama kelas..." 
                    class="w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-2xl text-xs sm:text-sm font-bold focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-50 transition-all shadow-sm">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-5 h-5 transition-colors group-focus-within:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <?php if($filters['search'] ?? ''): ?>
                <a href="<?= base_url('attendance-recap') ?>" class="inline-flex items-center justify-center w-14 h-14 sm:h-auto bg-rose-50 text-rose-500 rounded-2xl hover:bg-rose-500 hover:text-white transition-all border border-rose-100 shadow-sm active:scale-95" title="Hapus Filter">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach($classes as $class): ?>
        <a href="<?= base_url('attendance-recap/view/' . $class['id']) ?>" class="group block p-8 bg-white rounded-[2rem] shadow-sm hover:shadow-xl hover:shadow-indigo-100 border border-slate-100 transition-all duration-500 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 group-hover:bg-indigo-600 transition-colors duration-500 opacity-20 group-hover:opacity-10"></div>
            
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                
                <h5 class="text-2xl font-black text-slate-800 tracking-tight mb-2 group-hover:text-indigo-600 transition-colors">Kelas <?= $class['name'] ?></h5>
                <p class="text-sm font-medium text-slate-400 normal-case mb-6">Kelola dan tinjau performa kehadiran siswa di kelas ini.</p>
                
                <div class="flex items-center text-indigo-600 font-black text-[10px] tracking-widest uppercase">
                    <span>LIHAT RINGKASAN</span>
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>
