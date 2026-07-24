<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-20 text-center">
    <div class="max-w-md mx-auto bg-white rounded-3xl p-10 shadow-sm border border-slate-100">
        <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-amber-100">
            <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h2 class="text-xl font-black text-slate-800 mb-2">Akses Terbatas</h2>
        <p class="text-slate-500 text-sm leading-relaxed mb-8">Maaf, fitur Rekap Absensi hanya tersedia untuk Guru yang ditugaskan sebagai **Wali Kelas**. Silakan hubungi Administrator untuk informasi lebih lanjut mengenai penugasan Anda.</p>
        <a href="<?= base_url('dashboard') ?>" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-2xl transition-all shadow-lg shadow-indigo-100 active:scale-95">
            Kembali ke Dashboard
        </a>
    </div>
</div>
<?= $this->endSection() ?>
