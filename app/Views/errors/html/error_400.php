<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>400 - Permintaan Bermasalah</title>
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
    </style>
</head>
<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-amber-600/10 rounded-full blur-[120px]"></div>

    <div class="relative z-10 w-full max-w-lg text-center">
        <h1 class="text-[120px] font-[900] leading-none tracking-tighter text-white/10 mb-8">400</h1>

        <div class="glass p-8 md:p-12 rounded-[2.5rem] shadow-2xl border border-white/5">
            <h2 class="text-2xl font-black uppercase tracking-tight mb-4 leading-tight">Permintaan Bermasalah</h2>
            <p class="text-slate-400 font-medium text-sm md:text-base mb-10">
                Sistem tidak dapat memproses permintaan Anda karena format yang tidak sesuai. Silakan coba kembali atau hubungi administrator.
            </p>

            <a href="<?= base_url('/') ?>" class="inline-flex items-center justify-center px-8 py-4 bg-white text-slate-900 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-100 transition-all duration-300 active:scale-95 gap-2">
                <i class="ph-bold ph-house-line"></i>
                KE DASHBOARD
            </a>
        </div>
    </div>
</body>
</html>
