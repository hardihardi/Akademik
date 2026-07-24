<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #334155; line-height: 1.4; margin: 0; padding: 0; }
        .header { margin-bottom: 25px; border-bottom: 3px solid #4f46e5; padding-bottom: 20px; position: relative; }
        .logo-box { position: absolute; left: 0; top: 0; }
        .school-name { font-size: 20px; font-weight: bold; color: #1e1b4b; text-transform: uppercase; margin-bottom: 3px; }
        .school-info { font-size: 10px; color: #64748b; margin-bottom: 8px; }
        .report-title { font-size: 15px; font-weight: bold; color: #4338ca; text-transform: uppercase; margin-top: 5px; }
        
        .metadata { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .metadata td { padding: 5px 0; vertical-align: top; }
        .metadata .label { font-weight: bold; width: 120px; color: #64748b; text-transform: uppercase; font-size: 9px; }
        .metadata .value { color: #1e293b; font-weight: bold; }

        table.main { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table.main th { background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 10px; text-align: left; font-size: 9px; font-weight: bold; text-transform: uppercase; color: #475569; letter-spacing: 0.05em; }
        table.main td { padding: 10px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .badge { display: inline-block; padding: 3px 8px; border-radius: 5px; font-weight: bold; font-size: 10px; }
        .bg-emerald { background-color: #ecfdf5; color: #059669; }
        .bg-sky { background-color: #f0f9ff; color: #0284c7; }
        .bg-rose { background-color: #fff1f2; color: #e11d48; }

        .summary-box { float: left; width: 23%; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px; text-align: center; margin-right: 2%; }
        .summary-box:last-child { margin-right: 0; }
        .summary-label { font-size: 8px; font-weight: bold; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px; }
        .summary-value { font-size: 18px; font-weight: bold; color: #1e293b; }

        .footer { margin-top: 50px; width: 100%; }
        .signature-box { width: 30%; float: left; text-align: center; }
        .signature-space { height: 60px; }
        .signature-name { font-weight: bold; text-decoration: underline; }
        .clearfix { clear: both; }
    </style>
</head>
<body>
    <div class="header">
        <?php if ($school_logo): ?>
            <div class="logo-box">
                <img src="<?= $school_logo ?>" style="height: 60px; width: auto;" alt="Logo">
            </div>
        <?php endif; ?>
        <div style="text-align: center; padding-left: <?= $school_logo ? '70px' : '0' ?>;">
            <div class="school-name"><?= $school_name ?></div>
            <div class="report-title"><?= $title ?></div>
        </div>
    </div>

    <table class="metadata">
        <tr>
            <td class="label">Kelas:</td>
            <td class="value"><?= $class['name'] ?></td>
            <td class="label">Tahun Ajaran:</td>
            <td class="value"><?= $year['year'] ?> (<?= ($year['semester'] == 1) ? 'Ganjil' : 'Genap' ?>)</td>
        </tr>
        <tr>
            <td class="label">Guru Wali:</td>
            <td class="value"><?= $homeroom ?></td>
            <td class="label">Dicetak Pada:</td>
            <td class="value"><?= date('d F Y, H:i') ?></td>
        </tr>
    </table>

    <div style="margin-bottom: 30px;">
        <div class="summary-box">
            <div class="summary-label">Total Hadir</div>
            <div class="summary-value" style="color: #059669;"><?= $totalClassH ?></div>
        </div>
        <div class="summary-box">
            <div class="summary-label">Total Sakit</div>
            <div class="summary-value" style="color: #0284c7;"><?= $totalClassS ?></div>
        </div>
        <div class="summary-box">
            <div class="summary-label">Total Izin</div>
            <div class="summary-value" style="color: #0284c7;"><?= $totalClassI ?></div>
        </div>
        <div class="summary-box">
            <div class="summary-label">Total Alpha</div>
            <div class="summary-value" style="color: #e11d48;"><?= $totalClassA ?></div>
        </div>
        <div class="clearfix"></div>
    </div>

    <table class="main">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="35%">Nama Siswa</th>
                <th width="10%" class="text-center">Hadir</th>
                <th width="10%" class="text-center">Sakit</th>
                <th width="10%" class="text-center">Izin</th>
                <th width="10%" class="text-center">Alpha</th>
                <th width="20%" class="text-right">% Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($students as $student): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="font-bold"><?= $student['full_name'] ?></td>
                <td class="text-center">
                    <span class="badge bg-emerald"><?= $attendanceStats[$student['id']]['summary']['H'] ?></span>
                </td>
                <td class="text-center"><?= $attendanceStats[$student['id']]['summary']['S'] ?></td>
                <td class="text-center"><?= $attendanceStats[$student['id']]['summary']['I'] ?></td>
                <td class="text-center" style="color: #e11d48; font-weight: bold;"><?= $attendanceStats[$student['id']]['summary']['A'] ?></td>
                <td class="text-right font-bold" style="color: #4f46e5;"><?= $attendanceStats[$student['id']]['percentage'] ?>%</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Kepala Sekolah</p>
            <div class="signature-space">
                <?php if (!empty($headmaster_signature)): ?>
                    <img src="<?= $headmaster_signature ?>" style="max-height: 50px; display: block; margin: 0 auto;" alt="Signature">
                <?php endif; ?>
            </div>
            <p class="signature-name"><?= $headmaster ?></p>
            <p>NIP. <?= $headmaster_nip ?></p>
        </div>
        
        <div style="width: 40%; float: left;">&nbsp;</div>
        
        <div class="signature-box">
            <p><?= !empty($school_city) ? $school_city : 'Ditetapkan' ?>, <?= date('d F Y') ?></p>
            <p>Wali Kelas</p>
            <div class="signature-space"></div>
            <p class="signature-name"><?= $homeroom ?></p>
            <p>NIP. <?= $homeroom_nip ?? '-' ?></p>
        </div>
        <div class="clearfix"></div>
    </div>
</body>
</html>
