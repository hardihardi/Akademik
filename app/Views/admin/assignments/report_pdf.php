<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #334155; line-height: 1.5; font-size: 11px; }
        .header { border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; margin-bottom: 20px; text-align: center; }
        .header img { height: 60px; margin-bottom: 5px; }
        .header h1 { font-size: 16px; margin: 0; color: #1e293b; text-transform: uppercase; }
        .header p { margin: 2px 0; color: #64748b; font-size: 10px; }
        
        .report-title { text-align: center; margin-bottom: 20px; }
        .report-title h2 { font-size: 14px; margin: 0; color: #4338ca; text-decoration: underline; }
        
        .info-grid { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-grid td { padding: 4px 8px; vertical-align: top; }
        .info-label { font-weight: bold; width: 120px; color: #64748b; }
        
        .stats-table { width: 100%; margin-bottom: 25px; border-collapse: collapse; background: #f8fafc; }
        .stats-table td { border: 1px solid #e2e8f0; padding: 10px; text-align: center; }
        .stats-num { font-size: 18px; font-weight: bold; display: block; margin-bottom: 3px; }
        .stats-label { font-size: 9px; text-transform: uppercase; color: #64748b; font-weight: bold; }
        
        .section-header { background: #f1f5f9; padding: 6px 10px; border-left: 4px solid #4338ca; margin: 20px 0 10px 0; }
        .section-header h3 { margin: 0; font-size: 11px; text-transform: uppercase; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th { background: #f8fafc; border: 1px solid #e2e8f0; padding: 8px; text-align: left; font-size: 9px; text-transform: uppercase; color: #64748b; }
        table.data-table td { border: 1px solid #e2e8f0; padding: 8px; vertical-align: middle; }
        
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 8px; font-weight: bold; text-transform: uppercase; }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-error { background: #fee2e2; color: #991b1b; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; color: #94a3b8; border-top: 1px solid #f1f5f9; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <?php if($brand['logo']): ?>
            <img src="<?= $brand['logo'] ?>" alt="Logo">
        <?php endif; ?>
        <h1><?= $brand['name'] ?></h1>
        <p><?= $brand['address'] ?></p>
        <p>Email: <?= $brand['email'] ?? '-' ?> | Telp: <?= $brand['phone'] ?? '-' ?></p>
    </div>

    <div class="report-title">
        <h2>LAPORAN PENYERAHAN <?= strtoupper($assignment['type']) ?></h2>
    </div>

    <table class="info-grid">
        <tr>
            <td class="info-label">Mata Pelajaran</td>
            <td>: <?= $assignment['subject_name'] ?></td>
            <td class="info-label">Kelas</td>
            <td>: <?= $assignment['class_name'] ?></td>
        </tr>
        <tr>
            <td class="info-label">Judul</td>
            <td>: <?= $assignment['title'] ?></td>
            <td class="info-label">Guru Pengampu</td>
            <td>: <?= $assignment['teacher_name'] ?></td>
        </tr>
        <tr>
            <td class="info-label">Batas Waktu</td>
            <td>: <?= date('d M Y, H:i', strtotime($assignment['deadline'])) ?></td>
            <td class="info-label">Tanggal Cetak</td>
            <td>: <?= date('d M Y, H:i') ?></td>
        </tr>
    </table>

    <table class="stats-table">
        <tr>
            <td>
                <span class="stats-num" style="color: #1e293b;"><?= $stats['total'] ?></span>
                <span class="stats-label">Total Siswa</span>
            </td>
            <td>
                <span class="stats-num" style="color: #166534;"><?= $stats['sudah'] ?></span>
                <span class="stats-label">Tepat Waktu</span>
            </td>
            <td>
                <span class="stats-num" style="color: #92400e;"><?= $stats['terlambat'] ?></span>
                <span class="stats-label">Terlambat</span>
            </td>
            <td>
                <span class="stats-num" style="color: #991b1b;"><?= $stats['belum'] ?></span>
                <span class="stats-label">Belum Kumpul</span>
            </td>
        </tr>
    </table>

    <?php 
    $cats = [
        ['label' => 'Sudah Mengumpulkan (Tepat Waktu)', 'data' => $reportData['sudah'], 'status' => 'Selesai', 'badge' => 'success'],
        ['label' => 'Sudah Mengumpulkan (Terlambat)', 'data' => $reportData['terlambat'], 'status' => 'Terlambat', 'badge' => 'warning'],
        ['label' => 'Belum Mengumpulkan', 'data' => $reportData['belum'], 'status' => 'Belum Ada', 'badge' => 'error'],
    ];

    foreach ($cats as $cat):
    ?>
    <div class="section-header">
        <h3><?= $cat['label'] ?> (<?= count($cat['data']) ?>)</h3>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 10%;">NIS</th>
                <th style="width: 35%;">Nama Siswa</th>
                <th style="width: 25%;">Waktu Penyerahan</th>
                <th style="width: 15%;">Nilai</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($cat['data'])): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #94a3b8; font-style: italic;">Tidak ada data.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($cat['data'] as $student): ?>
                <tr>
                    <td><?= $student['nis'] ?></td>
                    <td><strong style="color: #1e293b;"><?= $student['full_name'] ?></strong></td>
                    <td><?= $student['submit_time'] ? date('d/m/Y H:i', strtotime($student['submit_time'])) : '-' ?></td>
                    <td style="text-align: center;"><?= $student['grade'] ?? '-' ?></td>
                    <td style="text-align: center;">
                        <span class="badge badge-<?= $cat['badge'] ?>"><?= $cat['status'] ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php endforeach; ?>

    <div class="footer">
        Dihasilkan secara otomatis oleh <?= $brand['name'] ?> pada <?= date('d/m/Y H:i:s') ?>
    </div>
</body>
</html>
