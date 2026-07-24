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
                        <span class="text-indigo-600 font-black">Informasi</span>
                    </li>
                </ol>
            </nav>
            <h3 class="text-slate-800 text-3xl sm:text-4xl lg:text-5xl font-black tracking-tighter">Pusat Informasi</h3>
            <p class="text-slate-500 mt-2 font-medium tracking-tight">Kanal pengumuman resmi dan berita terbaru untuk orang tua.</p>
        </div>
        <div class="flex items-center space-x-4">
             <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center">
                <div class="w-2 h-2 rounded-full bg-indigo-600 mr-2 animate-pulse"></div>
                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Live Updates</span>
             </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
        
        <!-- School Wide Announcements -->
        <div class="flex flex-col">
            <div class="flex items-center mb-6 px-4">
                <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-100 mr-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <h4 class="text-2xl font-black text-slate-800 tracking-tight">Agenda Sekolah</h4>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Informasi Institusi Utama</p>
                </div>
            </div>

            <div class="space-y-6">
                <?php if(!empty($schoolAnnouncements)): ?>
                    <?php foreach($schoolAnnouncements as $post): ?>
                        <a href="<?= base_url('parent/announcements/view/' . $post['id']) ?>" class="block bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-xl hover:translate-y-[-4px] transition-all duration-300 group">
                            <div class="flex justify-between items-start mb-4">
                                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1.5 rounded-xl border border-indigo-100">Portal Sekolah</span>
                                <div class="flex items-center text-xs font-bold text-slate-400 tabular-nums">
                                    <svg class="h-4 w-4 mr-1.5 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <?= date('d M Y', strtotime($post['created_at'])) ?>
                                </div>
                            </div>
                            <h5 class="text-xl font-black text-slate-800 mb-3 tracking-tight group-hover:text-indigo-700 transition-colors"><?= $post['title'] ?></h5>
                            <div class="text-slate-500 text-sm leading-relaxed mb-6 font-medium line-clamp-3">
                                <?= strip_tags($post['content']) ?>
                            </div>
                            <div class="flex items-center text-indigo-600 text-[10px] font-black uppercase tracking-widest group-hover:translate-x-1 transition-transform">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </div>
                        </a>
                    <?php endforeach; ?>
                    <div class="mt-4">
                        <?= $pager->links('school', 'tailwind_pager') ?>
                    </div>
                <?php else: ?>
                    <div class="bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 p-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="font-black tracking-tight opacity-50 uppercase text-[10px]">Belum ada pengumuman sekolah yang dipublikasikan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Class Specific Announcements -->
        <div class="flex flex-col">
            <div class="flex items-center mb-6 px-4">
                <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-100 mr-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-2xl font-black text-slate-800 tracking-tight">Info Wali Kelas</h4>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Update Kelas <?= $student['class_name'] ?></p>
                </div>
            </div>

            <div class="space-y-6">
                <?php if(!empty($classAnnouncements)): ?>
                    <?php foreach($classAnnouncements as $post): ?>
                        <a href="<?= base_url('parent/announcements/view/' . $post['id']) ?>" class="block bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 border-l-[6px] border-l-emerald-500 hover:shadow-xl hover:translate-y-[-4px] transition-all duration-300 group">
                            <div class="flex justify-between items-start mb-4">
                                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-100">Pesan Wali Kelas</span>
                                <div class="flex items-center text-xs font-bold text-slate-400 tabular-nums">
                                    <svg class="h-4 w-4 mr-1.5 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <?= date('d M Y - H:i', strtotime($post['created_at'])) ?>
                                </div>
                            </div>
                            <h5 class="text-xl font-black text-slate-800 mb-3 tracking-tight group-hover:text-emerald-700 transition-colors"><?= $post['title'] ?></h5>
                            <div class="text-slate-500 text-sm leading-relaxed mb-6 font-medium line-clamp-3">
                                <?= strip_tags($post['content']) ?>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200">
                                        <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Oleh Wali Kelas</span>
                                </div>
                                <div class="flex items-center text-emerald-600 text-[10px] font-black uppercase tracking-widest group-hover:translate-x-1 transition-transform">
                                    Lihat Detail
                                    <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                    <div class="mt-4">
                        <?= $pager->links('class', 'tailwind_pager') ?>
                    </div>
                <?php else: ?>
                    <div class="bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 p-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        <p class="font-black tracking-tight opacity-50 uppercase text-[10px]">Belum ada pesan khusus dari wali kelas Anda.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

<?= $this->endSection() ?>
