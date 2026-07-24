<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; color: #334155; line-height: 1.4; margin: 0; padding: 0; }
        .header { margin-bottom: 25px; border-bottom: 3px solid #4f46e5; padding-bottom: 20px; text-align: center; }
        .school-name { font-size: 18px; font-weight: bold; color: #1e1b4b; text-transform: uppercase; margin-bottom: 3px; }
        .report-title { font-size: 13px; font-weight: bold; color: #4338ca; text-transform: uppercase; margin-top: 5px; }
        table.main { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table.main th { background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 8px; text-align: left; font-size: 8px; font-weight: bold; text-transform: uppercase; color: #475569; }
        table.main td { padding: 8px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; font-size: 8px; color: #94a3b8; text-align: center; }
        .timestamp { color: #64748b; font-size: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name"><?= $school['name'] ?? 'SD Al-Ukhuwah' ?></div>
        <div class="report-title"><?= $title ?></div>
    </div>

    <table class="main">
        <thead>
            <tr>
                <th width="15%">Waktu</th>
                <th width="15%">Pengguna</th>
                <th width="15%">Aksi</th>
                <th width="55%">Detail Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($logs as $row): ?>
            <tr>
                <td class="timestamp"><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                <td style="font-weight: bold;"><?= $row['username'] ?: 'System' ?></td>
                <td><?= $row['action'] ?></td>
                <td><?= $row['details'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: <?= date('d F Y, H:i') ?>
    </div>
</body>
</html>
