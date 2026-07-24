<?php $brand = school_branding(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login' ?> - <?= $brand['name'] ?></title>
    
    <?php if ($brand['favicon']): ?>
        <link rel="icon" type="image/x-icon" href="<?= $brand['favicon'] ?>">
    <?php endif; ?>

    <!-- Local CSS (Tailwind Compiled) -->
    <?php $cssVersion = filemtime(FCPATH . 'css/style.css') ?: time(); ?>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>?v=<?= $cssVersion ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet"></noscript>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-slate-50 antialiased">
    <?= $this->renderSection('content') ?>
</body>
</html>