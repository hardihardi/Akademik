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
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 8px; font-weight: bold; text-transform: uppercase; }
        .badge-indigo { background-color: #e0e7ff; color: #4338ca; }
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
                <th width="5%" class="text-center">No</th>
                <th width="25%">Username</th>
                <th width="25%">Nama Lengkap</th>
                <th width="35%">Email</th>
                <th width="20%">Role</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($users as $row): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td style="font-weight: bold;"><?= $row['username'] ?></td>
                <td><?= $row['full_name'] ?: ($row['username']) ?></td>
                <td><?= $row['email'] ?></td>
                <td>
                    <?php if(!empty($row['roles'])): ?>
                        <?php foreach($row['roles'] as $role): ?>
                            <span class="badge badge-indigo"><?= $role['name'] ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?= $row['status'] ?? 'Active' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: <?= date('d F Y, H:i') ?>
    </div>
</body>
</html>
