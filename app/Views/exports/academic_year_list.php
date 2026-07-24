<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #334155; line-height: 1.4; margin: 0; padding: 0; }
        .header { margin-bottom: 25px; border-bottom: 3px solid #4f46e5; padding-bottom: 20px; text-align: center; }
        .school-name { font-size: 20px; font-weight: bold; color: #1e1b4b; text-transform: uppercase; margin-bottom: 3px; }
        .report-title { font-size: 15px; font-weight: bold; color: #4338ca; text-transform: uppercase; margin-top: 5px; }
        table.main { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table.main th { background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 10px; text-align: left; font-size: 9px; font-weight: bold; text-transform: uppercase; color: #475569; }
        table.main td { padding: 10px; border-bottom: 1px solid #f1f5f9; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; font-size: 9px; color: #94a3b8; text-align: center; }
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
                <th width="10%" class="text-center">No</th>
                <th width="40%">Tahun Pelajaran</th>
                <th width="25%">Semester</th>
                <th width="25%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($years as $row): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td style="font-weight: bold;"><?= $row['year'] ?></td>
                <td><?= $row['semester'] ?></td>
                <td><?= $row['status'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: <?= date('d F Y, H:i') ?>
    </div>
</body>
</html>
