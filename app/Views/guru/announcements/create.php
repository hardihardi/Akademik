<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight"><?= $title ?></h1>
            <p class="text-gray-500 text-sm">Bagikan perkembangan kelas atau informasi penting kepada orang tua.</p>
        </div>
        <a href="<?= base_url('class-announcements') ?>" class="text-gray-600 hover:text-indigo-600 flex items-center transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-2xl border border-slate-100 p-8">
        <form action="<?= base_url('class-announcements/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2" for="class_id">
                    Pilih Kelas
                </label>
                <div class="relative">
                    <select class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none appearance-none font-semibold text-slate-700" id="class_id" name="class_id" required>
                        <option value="">-- Pilih Kelas Terintegrasi --</option>
                        <?php foreach($classes as $class): ?>
                            <option value="<?= $class['id'] ?>">Kelas <?= $class['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2" for="title">
                    Judul Pengumuman
                </label>
                <input class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-800" id="title" name="title" type="text" placeholder="Contoh: Jadwal Ujian Harian" required>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2" for="content">
                    Isi Pengumuman
                </label>
                <textarea class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none min-h-[200px]" id="content" name="content" placeholder="Tuliskan detail informasi di sini..." required></textarea>
            </div>

            <div class="flex items-center justify-end">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-10 rounded-2xl transition-all duration-200 shadow-lg shadow-indigo-100 active:scale-95 text-sm uppercase tracking-widest" type="submit">
                    Publikasikan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
