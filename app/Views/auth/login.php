<?= $this->extend('layouts/login_layout') ?>

<?= $this->section('content') ?>
<?php $brand = school_branding(); ?>

<div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-0 bg-[#f8fafc]">
    <!-- Container Card -->
    <div class="flex flex-col lg:flex-row w-full max-w-[1000px] bg-white rounded-2xl shadow-2xl overflow-hidden min-h-[600px]">
        
        <!-- Left Side: Visual/Branding (Hidden on Mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-indigo-600 relative overflow-hidden items-center justify-center p-12">
            <!-- Dekorasi Pattern -->
            <svg class="absolute inset-0 opacity-20" width="100%" height="100%" fill="none" viewBox="0 0 400 400">
                <defs>
                    <pattern id="pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="white"></circle>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#pattern)"></rect>
            </svg>
            
            <div class="relative z-10 text-center text-white">
                <?php if($brand['logo']): ?>
                    <img src="<?= $brand['logo'] ?>" class="h-24 mx-auto mb-6 drop-shadow-lg" alt="Logo">
                <?php endif; ?>
                <h2 class="text-3xl font-bold mb-4"><?= $brand['name'] ?></h2>
                <p class="text-indigo-100 text-lg font-light leading-relaxed">
                    Selamat datang kembali! Silakan login untuk mengakses Sistem Informasi Akademik.
                </p>
            </div>
            
            <!-- Floating Decorative Circles -->
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-70"></div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-70"></div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 p-8 sm:p-12 md:p-16 flex flex-col justify-center">
            
            <!-- Mobile Logo (Only visible on mobile) -->
            <div class="lg:hidden flex flex-col items-center mb-8">
                <?php if($brand['logo']): ?>
                    <img src="<?= $brand['logo'] ?>" class="h-16 w-auto mb-3" alt="Logo">
                <?php else: ?>
                    <div class="bg-indigo-600 p-3 rounded-xl mb-3 text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                <?php endif; ?>
                <h2 class="text-indigo-700 font-bold text-xs uppercase tracking-[0.2em] text-center"><?= $brand['name'] ?></h2>
            </div>

            <div class="mb-10 text-center lg:text-left">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Login Member</h1>
                <p class="text-gray-500 mt-2">Masukkan kredensial Anda untuk masuk</p>
            </div>

            <?php if(session()->getFlashdata('error')):?>
                <div class="flex items-center bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                    <svg class="h-5 w-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-red-700 font-medium"><?= session()->getFlashdata('error') ?></p>
                </div>
            <?php endif;?>

            <form action="<?= base_url('auth/loginProcess') ?>" method="post" class="space-y-5" id="loginForm">
                <?= csrf_field() ?>
                
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="username" id="username" required 
                            class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all outline-none text-gray-900 placeholder-gray-400"
                            placeholder="Username Anda">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required 
                            class="block w-full pl-11 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all outline-none text-gray-900 placeholder-gray-400"
                            placeholder="••••••••">
                        
                        <!-- Toggle Password -->
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg id="eyeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between py-2">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-600">Ingat Saya</label>
                    </div>
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">Lupa Password?</a>
                </div>

                <button type="submit" id="btnSubmit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all duration-300 transform active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-indigo-500/30 flex justify-center items-center">
                    <span>Masuk ke Akun</span>
                </button>
            </form>

            <div class="mt-10 text-center text-sm text-gray-400">
                &copy; <?= date('Y') ?> <?= $brand['name'] ?>. 
                <div class="mt-1">Build with ❤️ for Education</div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi Toggle Show/Hide Password
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    }

    // Animasi Loading Sederhana saat submit
    document.getElementById('loginForm').onsubmit = function() {
        const btn = document.getElementById('btnSubmit');
        btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...`;
        btn.disabled = true;
        btn.classList.add('opacity-80', 'cursor-not-allowed');
    };
</script>
<?= $this->endSection() ?>