<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="mb-6 lg:mb-10 lg:flex lg:items-center lg:justify-between gap-8">
        <div>
            <div class="flex items-center gap-2 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 lg:mb-4">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-indigo-600 transition-colors uppercase">DASHBOARD</a>
                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                <span class="text-indigo-600 uppercase">AUDIT LOGS</span>
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase"><?= $title ?></h1>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Memantau setiap aktivitas modifikasi data di sistem.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 lg:gap-3">
            <div class="flex gap-2">
                <a href="<?= base_url('audit-logs/exportCsv') ?>" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 lg:px-6 py-3.5 rounded-2xl bg-white text-emerald-600 border border-emerald-100 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-emerald-50 hover:border-emerald-200 transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    CSV
                </a>
                <a href="<?= base_url('audit-logs/exportPdf') ?>" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 lg:px-6 py-3.5 rounded-2xl bg-white text-rose-600 border border-rose-100 font-black text-[10px] lg:text-xs tracking-widest shadow-sm hover:bg-rose-50 hover:border-rose-200 transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Waktu</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">User</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 px-4">Aksi</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Deskripsi</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-300 mb-4">
                                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <p class="text-slate-400 font-bold">Belum ada riwayat aktivitas yang tercatat.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($logs as $log): ?>
                            <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                                <td class="p-6 text-[10px] font-mono text-slate-400">
                                    <?= date('d/m/Y H:i', strtotime($log['created_at'])) ?>
                                </td>
                                <td class="p-6">
                                    <span class="text-xs font-black text-indigo-600 uppercase tracking-tight"><?= $log['username'] ?? 'System' ?></span>
                                </td>
                                <td class="p-6 px-4">
                                    <?php 
                                        $badgeClass = 'bg-slate-100 text-slate-600 border-slate-100';
                                        if (str_contains($log['action'], 'create')) $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                                        if (str_contains($log['action'], 'delete')) $badgeClass = 'bg-rose-50 text-rose-600 border-rose-100';
                                        if (str_contains($log['action'], 'update')) $badgeClass = 'bg-indigo-50 text-indigo-600 border-indigo-100';
                                    ?>
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border <?= $badgeClass ?>">
                                        <?= str_replace('_', ' ', $log['action']) ?>
                                    </span>
                                </td>
                                <td class="p-6 text-sm text-slate-600 leading-relaxed font-medium">
                                    <?= $log['description'] ?>
                                </td>
                                <td class="p-6 text-[10px] font-mono text-slate-300 tracking-tighter text-right group-hover:text-indigo-400 transition-colors">
                                    <?= $log['ip_address'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3 mb-10 uppercase tracking-widest leading-none">
        <?php if(empty($logs)): ?>
            <div class="bg-white rounded-2xl border border-slate-100 p-8 text-center text-slate-400 font-bold text-sm lowercase">
                Belum ada riwayat aktivitas.
            </div>
        <?php else: ?>
            <?php foreach($logs as $log): ?>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[9px] font-mono text-slate-400"><?= date('d/m/y H:i', strtotime($log['created_at'])) ?></span>
                    <?php 
                        $badgeClass = 'bg-slate-100 text-slate-600 border-slate-100';
                        if (str_contains($log['action'], 'create')) $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                        if (str_contains($log['action'], 'delete')) $badgeClass = 'bg-rose-50 text-rose-600 border-rose-100';
                        if (str_contains($log['action'], 'update')) $badgeClass = 'bg-indigo-50 text-indigo-600 border-indigo-100';
                    ?>
                    <span class="px-2 py-0.5 rounded-lg text-[8px] font-black border <?= $badgeClass ?>"><?= str_replace('_', ' ', $log['action']) ?></span>
                </div>
                <div class="mb-2">
                    <span class="text-[10px] font-black text-indigo-600"><?= $log['username'] ?? 'SYSTEM' ?></span>
                </div>
                <p class="text-[10px] text-slate-600 leading-normal font-medium normal-case"><?= $log['description'] ?></p>
                <div class="mt-3 pt-3 border-t border-slate-50 flex justify-end">
                    <span class="text-[8px] font-mono text-slate-300"><?= $log['ip_address'] ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="mt-8 mb-12">
        <?= $pager->links('default', 'tailwind_pager') ?>
    </div>
<?= $this->endSection() ?>
