<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight"><?= $title ?></h1>
            <p class="text-slate-500 mt-1">Kelola informasi akun dan keamanan profil Anda.</p>
        </div>
    </div>

    <?php if(session()->getFlashdata('message')):?>
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-8 rounded-r-xl shadow-sm animate-fade-in-down" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-emerald-800"><?= session()->getFlashdata('message') ?></p>
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if ($validation->getErrors()): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-xl shadow-sm">
            <ul class="list-disc ml-5 text-sm text-red-700">
                <?php foreach ($validation->getErrors() as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data" class="p-6 md:p-10">
            <?= csrf_field() ?>
            
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-16">
                <!-- Left Column: Photo & Basic Info -->
                <div class="flex flex-col items-center lg:items-start space-y-6 flex-shrink-0 w-full lg:w-64">
                    <div class="relative group">
                        <div id="photo-preview" class="w-40 h-40 sm:w-48 sm:h-48 rounded-[2.5rem] border-4 border-slate-50 shadow-inner bg-slate-100 flex items-center justify-center overflow-hidden transition-all group-hover:border-indigo-100 group-hover:shadow-indigo-50/50">
                            <?php if(!empty($user['photo'])): ?>
                                <img src="<?= get_photo_url($user['photo']) ?>" class="object-cover w-full h-full" alt="Profile Photo">
                            <?php else: ?>
                                <div class="text-indigo-300">
                                    <svg class="h-16 w-16 sm:h-20 sm:w-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <label class="absolute -bottom-2 -right-2 p-3 bg-indigo-600 rounded-2xl text-white cursor-pointer hover:bg-indigo-700 shadow-xl hover:scale-110 transition-all z-10 border-4 border-white active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <input type="file" name="photo" class="hidden" accept="image/*" onchange="previewProfileImage(this)">
                        </label>
                    </div>
                    <div class="text-center lg:text-left w-full">
                        <h2 class="text-2xl font-black text-slate-800 break-words tracking-tight"><?= $full_name ?></h2>
                        <div class="flex flex-wrap justify-center lg:justify-start gap-2 mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black bg-indigo-600 text-white uppercase tracking-widest shadow-lg shadow-indigo-100">
                                <?= $user['role'] ?>
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black bg-slate-100 text-slate-400 uppercase tracking-widest">
                                @<?= $user['username'] ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Settings Form -->
                <div class="flex-1 space-y-10 min-w-0">
                    <!-- Account Info section -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Informasi Akun</h3>
                            <div class="h-px bg-slate-100 w-full"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-slate-700 font-bold text-xs uppercase tracking-wider mb-2">Username</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <input type="text" value="<?= $user['username'] ?>" class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-slate-400 cursor-not-allowed font-bold text-sm" readonly title="Username tidak dapat diubah">
                                </div>
                                <p class="mt-2 text-[10px] text-slate-400 font-bold italic">Username dikunci oleh sistem untuk keamanan data.</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-slate-700 font-bold text-xs uppercase tracking-wider mb-2">Nama Lengkap</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-300 group-focus-within:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </div>
                                    <input type="text" name="full_name" value="<?= old('full_name', $full_name) ?>" class="w-full pl-11 pr-4 py-3.5 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-sm text-slate-800 placeholder:text-slate-300" placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-slate-700 font-bold text-xs uppercase tracking-wider mb-2">Email Aktif</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-300 group-focus-within:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <input type="email" name="email" value="<?= old('email', $user['email']) ?>" class="w-full pl-11 pr-4 py-3.5 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-sm text-slate-800 placeholder:text-slate-300" placeholder="Masukkan email aktif" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security section -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Keamanan Akun</h3>
                            <div class="h-px bg-slate-100 w-full"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-slate-700 font-bold text-xs uppercase tracking-wider mb-2">Password Baru</label>
                                <input type="password" name="password" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-sm text-slate-800" placeholder="••••••••">
                            </div>

                            <div>
                                <label class="block text-slate-700 font-bold text-xs uppercase tracking-wider mb-2">Konfirmasi Password</label>
                                <input type="password" name="password_confirm" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold text-sm text-slate-800" placeholder="••••••••">
                            </div>
                        </div>
                        <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100 flex gap-3 shadow-sm shadow-amber-100/50">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-[11px] text-amber-700 font-bold italic leading-relaxed">Kosongkan kolom password jika Anda tidak ingin mengubah password saat ini.</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-8 border-t border-slate-50">
                        <a href="<?= base_url('dashboard') ?>" class="w-full sm:w-auto px-8 py-4 text-xs font-black text-slate-400 hover:text-slate-600 transition-colors text-center uppercase tracking-widest">
                            Batalkan
                        </a>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-10 py-4 text-xs font-black text-white bg-indigo-600 rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 active:translate-y-0 transition-all duration-300 uppercase tracking-widest">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Profil
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewProfileImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photo-preview').innerHTML = '<img src="' + e.target.result + '" class="object-cover w-full h-full">';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
@keyframes fade-in-down {
    0% { opacity: 0; transform: translateY(-10px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-down {
    animation: fade-in-down 0.5s ease-out forwards;
}
</style>
<?= $this->endSection() ?>
