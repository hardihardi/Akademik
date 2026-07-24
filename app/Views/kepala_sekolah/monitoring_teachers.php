<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Monitoring Guru</h1>
            <p class="text-slate-500 mt-1">Memantau beban mengajar dan penugasan guru secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-indigo-50 px-6 py-3 rounded-2xl border border-indigo-100 hidden sm:flex items-center gap-3 shadow-sm">
                <div class="bg-indigo-600 p-2 rounded-lg text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <span class="block text-[10px] uppercase font-bold text-indigo-400 tracking-wider leading-none">Tahun Akademik</span>
                    <span class="block font-bold text-indigo-900 mt-0.5"><?= $activeYear['year'] ?> (<?= $activeYear['semester'] ?>)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="mb-8" x-data="{ search: '' }">
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" 
                   x-model="search"
                   @input="$dispatch('teacher-search', { query: search })"
                   placeholder="Cari nama guru atau NIP..." 
                   class="w-full pl-11 pr-4 py-4 bg-white border border-slate-100 rounded-[2rem] shadow-sm text-sm font-medium focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none">
        </div>
    </div>

    <!-- Teacher List Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-data="{ 
        query: '',
        visibleTeachers: []
    }" @teacher-search.window="query = $event.detail.query.toLowerCase()">
        
        <?php foreach($teachers as $teacher): ?>
        <div class="bg-white rounded-[2.5rem] p-6 border border-slate-50 shadow-sm hover:shadow-xl transition-all duration-300 group relative overflow-hidden"
             x-show="'<?= addslashes(strtolower($teacher['full_name'] . ' ' . $teacher['nip'])) ?>'.includes(query)">
            
            <!-- Decoration -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -translate-y-16 translate-x-16 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

            <div class="relative">
                <!-- User Info -->
                <div class="flex items-center gap-5 mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex-shrink-0 flex items-center justify-center text-indigo-600 border-4 border-white shadow-lg overflow-hidden transition-transform group-hover:scale-105">
                        <?php if($teacher['photo']): ?>
                            <img src="<?= get_photo_url($teacher['photo']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <?php endif; ?>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-black text-slate-800 text-lg leading-tight truncate"><?= $teacher['full_name'] ?></h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">NIP: <?= $teacher['nip'] ?></p>
                    </div>
                </div>

                <!-- Assignment Stats -->
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="bg-slate-50 p-4 rounded-3xl border border-white shadow-inner ring-1 ring-slate-100">
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 text-center">Kelas</span>
                        <span class="block text-xl font-black text-indigo-600 text-center">
                            <?= count(array_unique(array_column($teacher['assignments'], 'class_id'))) ?>
                        </span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-3xl border border-white shadow-inner ring-1 ring-slate-100">
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 text-center">Mapel</span>
                        <span class="block text-xl font-black text-emerald-600 text-center">
                            <?= count(array_unique(array_column($teacher['assignments'], 'subject_id'))) ?>
                        </span>
                    </div>
                </div>

                <!-- Assignment List -->
                <div class="space-y-4">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Daftar Penugasan</h4>
                    <?php if(empty($teacher['assignments'])): ?>
                        <div class="bg-rose-50 border border-rose-100 p-4 rounded-2xl flex items-center justify-center">
                            <p class="text-[10px] font-bold text-rose-500 uppercase tracking-widest">Belum ada penugasan</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-2 max-h-[180px] overflow-y-auto pr-2 sidebar-scroll">
                            <?php foreach($teacher['assignments'] as $assign): ?>
                            <div class="bg-white border border-slate-100 p-3 rounded-2xl hover:bg-slate-50 transition-colors flex items-center justify-between group/item">
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-700 truncate"><?= $assign['subject_name'] ?></p>
                                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-tighter mt-0.5">Kelas <?= $assign['class_name'] ?></p>
                                </div>
                                <div class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center opacity-0 group-hover/item:opacity-100 transition-opacity">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer Action -->
                <div class="mt-8 pt-6 border-t border-slate-50 hidden">
                    <button class="w-full py-3 bg-indigo-600 text-white rounded-2xl text-[10px] font-black tracking-[0.2em] shadow-lg shadow-indigo-100 transition-all hover:bg-indigo-700 hover:scale-[1.02] active:scale-[0.98]">
                        DETAIL AKTIVITAS
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Empty State -->
        <div x-show="visibleTeachers.length === 0 && query !== ''" class="col-span-full py-20 text-center" x-cloak>
            <div class="w-24 h-24 bg-slate-100 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6 shadow-inner ring-8 ring-white">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 tracking-tight mb-2">Guru Tidak Ditemukan</h3>
            <p class="text-slate-400 text-sm font-medium">Coba gunakan kata kunci pencarian yang berbeda.</p>
        </div>
    </div>
</div>

<style>
    /* Custom Scrollbar */
    .sidebar-scroll::-webkit-scrollbar { width: 4px; }
    .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
    .sidebar-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>
<?= $this->endSection() ?>
