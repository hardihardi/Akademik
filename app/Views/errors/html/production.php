<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Sistem Sedang Terkendala</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800;900&display=swap" rel="stylesheet"></noscript>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .anim-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Animated Gradients (Warm/Red for 500) -->
    <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-rose-600/20 rounded-full blur-[120px] anim-float"></div>
    <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-amber-600/20 rounded-full blur-[120px] anim-float" style="animation-delay: -3s"></div>

    <div class="relative z-10 w-full max-w-lg text-center">
        <!-- Error Code -->
        <div class="inline-block relative mb-8">
            <h1 class="text-[120px] md:text-[180px] font-[900] leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-b from-white to-white/10 opacity-20">500</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <i class="ph-duotone ph-warning-octagon text-7xl md:text-9xl text-rose-400 opacity-80 anim-float"></i>
            </div>
        </div>

        <!-- Content Card -->
        <div class="glass p-8 md:p-12 rounded-[2.5rem] shadow-2xl relative overflow-hidden group border border-white/5">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
            
            <div class="relative z-10">
                <h2 class="text-2xl md:text-3xl font-black uppercase tracking-tight mb-4 leading-tight text-rose-100">Sistem Sedang Terkendala</h2>
                <p class="text-slate-400 font-medium text-sm md:text-base mb-10 leading-relaxed">
                    Mohon maaf, terjadi kesalahan pada sistem kami. Tim teknis sedang berupaya memperbaikinya. Silakan coba muat ulang halaman atau kembali beberapa saat lagi.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="<?= base_url('/') ?>" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-900 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rose-50 hover:shadow-[0_20px_40px_rgba(255,0,0,0.1)] transition-all duration-300 active:scale-95 flex items-center justify-center gap-2">
                        <i class="ph-bold ph-house-line"></i>
                        KE DASHBOARD
                    </a>
                    <button onclick="location.reload()" class="w-full sm:w-auto px-8 py-4 bg-slate-800 text-white border border-slate-700 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-700 transition-all duration-300 active:scale-95 flex items-center justify-center gap-2">
                        <i class="ph-bold ph-arrow-clockwise"></i>
                        MUAT ULANG
                    </button>
                </div>
            </div>
        </div>

        <p class="mt-12 text-slate-400 font-bold text-[10px] uppercase tracking-[0.3em] bg-white/5 py-2 px-4 rounded-full inline-block backdrop-blur-sm">
            ID Eror: <span class="text-rose-400">#<?= substr(md5(time()), 0, 8) ?></span>
        </p>
    </div>
</body>
</html>
