<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Nilai - <?= $class['name'] ?></title>
    <style>
        /* Setup Halaman Landscape */
        @page {
            size: A4 landscape;
            margin: 30px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9px; /* Ukuran dasar lebih kecil */
            color: #333;
            line-height: 1.4;
        }

        .header { margin-bottom: 20px; border-bottom: 2px solid #444; padding-bottom: 10px; position: relative; }
        .logo-box { position: absolute; left: 0; top: 0; }

        .header h1 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
        }

        /* Tabel Info */
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .info-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        /* Tabel Utama */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            /* Table layout auto agar menyesuaikan isi */
            table-layout: auto; 
        }

        table.main-table th, 
        table.main-table td {
            border: 1px solid #000;
            padding: 4px 2px;
            text-align: center;
        }

        table.main-table th {
            background-color: #f2f2f2;
            font-size: 8px;
            text-transform: uppercase;
        }

        /* Nama Siswa Rata Kiri */
        .name-col {
            text-align: left !important;
            padding-left: 8px !important;
            width: 180px; /* Lebar tetap untuk nama agar tidak terlalu sempit */
        }

        .no-col { width: 25px; }
        
        /* Mata Pelajaran Kolom Sempit */
        .subject-header {
            height: 80px; /* Tinggi header untuk teks vertikal jika diperlukan */
            white-space: nowrap;
            font-size: 7px;
        }

        /* Nilai di bawah KKM */
        .below-kkm {
            color: #d00;
            font-weight: bold;
        }

        .avg-col {
            background-color: #f9f9f9;
            font-weight: bold;
            width: 45px;
        }

        .rank-col {
            background-color: #f0f0f0;
            font-weight: bold;
            width: 35px;
        }

        /* Tanda Tangan */
        .footer-section {
            margin-top: 30px;
            width: 100%;
        }

        .sig-container {
            float: right;
            width: 250px;
            text-align: center;
        }

        .sig-space {
            height: 50px;
        }

        /* Clearfix */
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="header">
        <?php if ($school_logo): ?>
            <div class="logo-box">
                <img src="<?= $school_logo ?>" style="height: 50px; width: auto;" alt="Logo">
            </div>
        <?php endif; ?>
        <div style="text-align: center;">
            <h1>REKAPITULASI NILAI HASIL BELAJAR SISWA</h1>
            <p>SEMESTER <?= strtoupper($year['semester']) ?> TAHUN PELAJARAN <?= $year['year'] ?></p>
        </div>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 12%;">Nama Sekolah</td>
            <td style="width: 38%;">: <?= $school_name ?></td>
            <td style="width: 12%;">Kelas</td>
            <td style="width: 38%;">: <?= $class['name'] ?></td>
        </tr>
        <tr>
            <td>Wali Kelas</td>
            <td>: <?= $homeroom ?></td>
            <td>Semester</td>
            <td>: <?= ucfirst($year['semester']) ?></td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th class="no-col">No</th>
                <th class="name-col">Nama Siswa</th>
                <?php foreach($subjects as $subject): ?>
                    <!-- Nama mapel dibuat kecil agar muat banyak kolom -->
                    <th class="subject-header">
                        <?= strlen($subject['name']) > 15 ? substr($subject['name'],0,12).'..' : $subject['name'] ?>
                    </th>
                <?php endforeach; ?>
                <th class="avg-col">Rata-rata</th>
                <th class="rank-col">Rank</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($students as $student): $sid = $student['id']; ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="name-col"><strong><?= strtoupper($student['full_name']) ?></strong></td>
                    
                    <?php foreach($subjects as $subject): 
                        $val = $ledger[$sid][$subject['id']] ?? 0;
                        $kkm = $subject['kkm'] ?? 70;
                        $isBelowKKM = ($val > 0 && $val < $kkm);
                    ?>
                        <td class="<?= $isBelowKKM ? 'below-kkm' : '' ?>">
                            <?= $val ?: '-' ?>
                        </td>
                    <?php endforeach; ?>

                    <td class="avg-col"><?= number_format($averages[$sid] ?? 0, 1) ?></td>
                    <td class="rank-col"><?= $ranks[$sid] ?? '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer-section" style="page-break-inside: avoid;">
        <div class="sig-container">
            <p><?= $school_location ?? 'Ditetapkan di' ?>, <?= date('d F Y') ?></p>
            <p>Wali Kelas,</p>
            <div class="sig-space"></div>
            <p><strong><u><?= $homeroom ?></u></strong></p>
            <p>NIP. <?= $homeroom_nip ?></p>
        </div>

        <div style="float: left; width: 250px; text-align: center;">
            <p style="margin-top: 15px;">Mengetahui,</p>
            <p>Kepala Sekolah</p>
            <div class="sig-space">
                <?php if (!empty($headmaster_signature)): ?>
                    <img src="<?= $headmaster_signature ?>" style="max-height: 45px; display: block; margin: 0 auto;" alt="Signature">
                <?php endif; ?>
            </div>
            <p><strong><u><?= $headmaster ?></u></strong></p>
            <p>NIP. <?= $headmaster_nip ?></p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>