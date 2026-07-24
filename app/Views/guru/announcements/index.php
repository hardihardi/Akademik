<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight"><?= $title ?></h1>
            <p class="text-gray-500 text-sm">Informasi dan berita khusus untuk kelas yang Anda ampu.</p>
        </div>
        <a href="<?= base_url('class-announcements/create') ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all duration-200 shadow-md flex items-center active:scale-95 shadow-indigo-100">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Pengumuman
        </a>
    </div>

    <?php if(session()->getFlashdata('message')):?>
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-8 rounded-r-xl shadow-sm" role="alert">
            <p class="font-bold text-sm">Berhasil</p>
            <p class="text-xs"><?= session()->getFlashdata('message') ?></p>
        </div>
    <?php endif;?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach($announcements as $ann): ?>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow">
            <div class="p-6 flex-grow">
                <div class="flex justify-between items-start mb-3">
                    <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase border border-indigo-100 font-bold">Kelas <?= $ann['class_name'] ?></span>
                    <span class="text-[10px] text-slate-400 font-mono"><?= date('d M Y', strtotime($ann['created_at'])) ?></span>
                </div>
                <h3 class="font-bold text-slate-800 mb-3 line-clamp-2"><?= $ann['title'] ?></h3>
                <div class="text-slate-600 text-sm line-clamp-4 mb-4">
                    <?= nl2br(htmlspecialchars($ann['content'])) ?>
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <form action="<?= base_url('class-announcements/delete/' . $ann['id']) ?>" method="post" onsubmit="confirmDelete(event, 'Hapus pengumuman ini?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="text-red-500 hover:text-red-700 p-1.5 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($announcements)): ?>
        <div class="col-span-full py-20 text-center">
            <div class="bg-slate-50 rounded-3xl p-10 inline-block border-2 border-dashed border-slate-200">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5h2M11 9h2m-7 4h12M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <p class="text-slate-500 font-medium">Belum ada pengumuman untuk kelas Anda.</p>
                <p class="text-slate-400 text-xs mt-1">Klik tombol "Buat Pengumuman" untuk memulai.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
