<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none"><?= $title ?></h1>
            </div>
            <p class="text-sm text-slate-500 font-bold opacity-80 pl-1">Pantau semua aktivitas dan pemberitahuan penting sistem Anda.</p>
        </div>
        <div class="w-full sm:w-auto">
            <a href="<?= base_url('notifications/read-all') ?>" class="inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] bg-indigo-50/50 hover:bg-indigo-600 hover:text-white rounded-[1.5rem] transition-all duration-300 shadow-sm border border-indigo-100/50">
                Tandai Semua Dibaca
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('message')):?>
        <div class="bg-indigo-600 border-none text-white p-5 mb-8 shadow-xl shadow-indigo-100 rounded-[1.5rem] flex items-center gap-4 animate-in slide-in-from-top duration-500">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <p class="text-xs font-black uppercase tracking-widest"><?= session()->getFlashdata('message') ?></p>
        </div>
    <?php endif;?>

    <!-- Notifications List -->
    <div class="space-y-4">
        <?php if(empty($notifications)): ?>
            <div class="bg-white rounded-[2.5rem] p-16 text-center border border-slate-100 shadow-sm">
                <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-inner ring-8 ring-white">
                    <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-2 tracking-tight">Kotak Masuk Kosong</h3>
                <p class="text-sm text-slate-400 font-bold">Anda akan menerima notifikasi di sini jika ada aktivitas baru.</p>
            </div>
        <?php else: ?>
            <?php foreach($notifications as $n): ?>
            <div class="group bg-white rounded-[2rem] p-5 md:p-6 border border-slate-100 hover:border-indigo-100 hover:shadow-2xl hover:shadow-indigo-50/50 transition-all duration-500 relative overflow-hidden <?= $n['is_read'] ? 'opacity-60' : '' ?>">
                <?php if(!$n['is_read']): ?>
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-600"></div>
                <?php endif; ?>
                
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="flex-shrink-0 relative">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center ring-4 ring-slate-50 transition-all group-hover:scale-110 <?= !$n['is_read'] ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-100' : 'bg-slate-100 text-slate-400' ?>">
                            <?php if($n['type'] == 'announcement'): ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            <?php elseif($n['type'] == 'assignment'): ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <?php else: ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <?php endif; ?>
                        </div>
                        <?php if(!$n['is_read']): ?>
                            <span class="absolute -top-1 -right-1 flex h-4 w-4">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-500 border-2 border-white"></span>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col sm:flex-row justify-between items-start mb-3 gap-2">
                            <h3 class="text-lg font-black text-slate-800 break-words w-full sm:w-auto transition-colors group-hover:text-indigo-600"><?= $n['title'] ?></h3>
                            <div class="flex items-center gap-2 px-3 py-1 bg-slate-50 rounded-lg group-hover:bg-white transition-colors border border-transparent group-hover:border-slate-100">
                                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span class="text-[10px] text-slate-500 font-black uppercase tracking-widest whitespace-nowrap italic">
                                    <?= date('d M Y, H:i', strtotime($n['created_at'])) ?>
                                </span>
                            </div>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed mb-6 font-medium italic opacity-90"><?= $n['message'] ?></p>
                        
                        <div class="flex flex-wrap items-center gap-4 pt-4 border-t border-slate-50">
                            <?php if(!$n['is_read']): ?>
                            <a href="<?= base_url('notifications/read/' . $n['id']) ?>" class="inline-flex items-center text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] group/btn hover:translate-x-1 transition-all">
                                Tandai Dibaca
                                <svg class="w-4 h-4 ml-2 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>
                            <?php elseif($n['link']): ?>
                            <a href="<?= $n['link'] ?>" class="inline-flex items-center text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] hover:text-indigo-600 transition-all">
                                Buka Tautan
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                            <?php endif; ?>

                            <div class="h-4 w-px bg-slate-100"></div>

                            <form action="<?= base_url('notifications/delete/' . $n['id']) ?>" method="post" onsubmit="confirmDelete(event, 'Hapus notifikasi ini selamanya?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-[10px] font-black text-rose-300 uppercase tracking-[0.2em] hover:text-rose-600 transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</div>
<?= $this->endSection() ?>
