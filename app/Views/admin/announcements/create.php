<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-6 lg:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-8 animate-in fade-in slide-in-from-top-4 duration-700">
        <div>
            <nav class="flex mb-3 lg:mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[9px] lg:text-[10px] font-black uppercase tracking-[0.2em]">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('dashboard') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase">Dashboard</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="<?= base_url('announcements') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors uppercase">Pengumuman</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-indigo-600 uppercase">Buat Pengumuman</span>
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight leading-tight uppercase"><?= $title ?></h1>
            <p class="text-slate-500 mt-2 font-medium text-xs lg:text-sm">Terbitkan informasi penting untuk seluruh civitas akademik.</p>
        </div>
        <div>
            <a href="<?= base_url('announcements') ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 text-slate-500 font-black text-[10px] tracking-widest hover:bg-slate-200 transition-all uppercase text-center min-w-[120px]">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                KEMBALI
            </a>
        </div>
    </div>

    <div class="animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="bg-white rounded-2xl lg:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 lg:p-10">
                <form action="<?= base_url('announcements/store') ?>" method="post" class="space-y-6 lg:space-y-8">
                    <?= csrf_field() ?>
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="title">
                            Judul Pengumuman <span class="text-rose-500">*</span>
                        </label>
                        <input class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-sm font-bold text-slate-800 placeholder:text-slate-300" id="title" name="title" type="text" placeholder="Contoh: Jadwal Libur Semester Ganjil" required>
                    </div>

                    <div x-data="{ target: 'all' }">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="target_role">
                            Target Audience <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select x-model="target" class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-sm font-bold text-slate-800 appearance-none bg-white" id="target_role" name="target_role" required>
                                <option value="all">SEMUA (GURU & SISWA)</option>
                                <option value="student">KHUSUS SISWA</option>
                                <option value="teacher">KHUSUS GURU</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>

                        <!-- Class Selection Dropdown (Conditional) -->
                        <div x-show="target === 'student'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-6">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="class_id">
                                Pilih Kelas (Opsional)
                            </label>
                            <div class="relative">
                                <select class="w-full px-5 py-3 lg:py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-sm font-bold text-slate-800 appearance-none bg-white" id="class_id" name="class_id">
                                    <option value="">-- SEMUA KELAS --</option>
                                    <?php foreach($classes as $c): ?>
                                        <option value="<?= $c['id'] ?>">Kelas <?= $c['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                            <p class="mt-2 text-[10px] text-slate-400 font-bold uppercase tracking-wider italic">* Kosongkan untuk kirim ke seluruh kelas</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3" for="content">
                            Isi Pengumuman <span class="text-rose-500">*</span>
                        </label>
                        <textarea class="w-full px-5 py-4 rounded-xl lg:rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-sm font-bold text-slate-800 placeholder:text-slate-300 min-h-[200px]" id="content" name="content" placeholder="Tuliskan isi pengumuman secara detail di sini..." required></textarea>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex flex-col sm:flex-row items-center gap-4">
                        <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-10 rounded-xl lg:rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-100 hover:shadow-indigo-200 hover:-translate-y-1 active:scale-95 flex items-center justify-center text-[10px] lg:text-xs tracking-[0.2em] uppercase" type="submit">
                            <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            TERBITKAN SEKARANG
                        </button>
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Akan segera muncul di dashboard user</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
