<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-8">
        <div>
            <div class="flex items-center gap-2 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 lg:mb-4">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600">PENGUMUMAN</span>
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight"><?= $title ?></h1>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Buat dan kelola pengumuman untuk siswa, guru, dan orang tua.</p>
        </div>
        <div>
            <a href="<?= base_url('announcements/create') ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 rounded-xl lg:rounded-2xl bg-indigo-600 text-white font-black text-[10px] lg:text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 hover:-translate-y-0.5 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 lg:mr-3 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                BUAT PENGUMUMAN
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('message')):?>
        <div class="mb-6 p-4 sm:p-5 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-600 shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                </div>
                <p class="text-sm font-bold text-emerald-800"><?= session()->getFlashdata('message') ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    <?php endif;?>

    <?php if(session()->getFlashdata('error')):?>
        <div class="mb-6 p-4 sm:p-5 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-rose-600 shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01" /></svg>
                </div>
                <p class="text-sm font-bold text-rose-800"><?= session()->getFlashdata('error') ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600 transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    <?php endif;?>

    <!-- Announcements List -->
    <div class="space-y-4 mb-10">
        <?php if(empty($announcements)): ?>
            <div class="bg-white rounded-2xl lg:rounded-[2rem] border border-slate-100 p-12 lg:p-16 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                    </div>
                    <p class="text-slate-400 font-bold text-sm">Belum ada pengumuman.</p>
                    <p class="text-slate-300 text-xs mt-1">Buat pengumuman pertama dengan menekan tombol di atas.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($announcements as $row): ?>
            <div class="bg-white rounded-2xl lg:rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden hover:shadow-md hover:border-slate-200 transition-all duration-300 group">
                <div class="p-4 sm:p-6 lg:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-lg lg:text-xl font-black text-slate-800 tracking-tight group-hover:text-indigo-600 transition-colors"><?= $row['title'] ?></h2>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-600 border border-indigo-100"><?= $row['target_role'] ?></span>
                                <span class="text-[10px] text-slate-400 font-medium"><?= date('d M Y H:i', strtotime($row['created_at'])) ?></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <a href="<?= base_url('announcements/edit/' . $row['id']) ?>" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-md rounded-xl transition-all duration-300" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                            <form action="<?= base_url('announcements/delete/' . $row['id']) ?>" method="post" class="inline" onsubmit="confirmDelete(event, 'Hapus pengumuman ini?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-white hover:text-rose-600 hover:shadow-md rounded-xl transition-all duration-300" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="prose prose-sm max-w-none text-slate-600 leading-relaxed text-sm">
                        <?= nl2br($row['content']) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="mb-12">
        <?= $pager->links('announcements', 'tailwind_pager') ?>
    </div>
<?= $this->endSection() ?>
