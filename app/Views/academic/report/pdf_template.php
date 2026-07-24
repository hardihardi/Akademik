<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor_<?= $student['full_name'] ?></title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.3;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .underline { text-decoration: underline; }
        
        .kop-table {
            width: 100%;
            border-bottom: 2pt double #000;
            margin-bottom: 10pt;
            padding-bottom: 5pt;
        }
        .logo-box {
            width: 80pt;
            text-align: center;
        }
        .logo-box img {
            width: 70pt;
        }
        
        .identity-table {
            width: 100%;
            margin-bottom: 10pt;
            font-weight: bold;
        }
        .identity-table td {
            vertical-align: top;
            padding: 2pt 0;
        }
        
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10pt;
        }
        .report-table th, .report-table td {
            border: 1pt solid #000;
            padding: 5pt 8pt;
        }
        .report-table th {
            background-color: #eee;
            text-align: center;
        }
        
        .attendance-notes-table {
            width: 100%;
            margin-bottom: 10pt;
        }
        .attendance-notes-table td {
            vertical-align: top;
        }
        .box-container {
            border: 1pt solid #000;
            padding: 6pt;
            min-height: 35pt;
        }
        
        .signature-table {
            width: 100%;
            margin-top: 20pt;
        }
        .signature-table td {
            text-align: center;
            width: 33%;
            vertical-align: top;
        }
        .signature-box {
            display: inline-block;
            text-align: left;
            margin-top: 10pt;
        }
        .signature-box p {
            margin: 2pt 0;
        }
        .signature-space {
            height: 35pt;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .signature-img {
            max-height: 50pt;
            display: block;
            margin: 0 auto;
        }

        /* Prevent table row splitting */
        .report-table tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    <!-- KOP SEKOLAH -->
    <table class="kop-table">
        <tr>
            <?php if(!empty($school['logo'])): ?>
            <td class="logo-box">
                <img src="<?= $school['logo'] ?>" alt="Logo">
            </td>
            <?php endif; ?>
            <td class="text-center">
                <div style="font-size: 14pt;" class="font-bold uppercase"><?= $school['name'] ?></div>
                <div style="font-size: 10pt;"><?= $school['address'] ?></div>
                <div style="font-size: 10pt;">Email: <?= $school['email'] ?></div>
            </td>
        </tr>
    </table>

    <div class="text-center" style="margin-bottom: 15pt;">
        <div class="font-bold uppercase underline" style="font-size: 12pt;">LAPORAN HASIL BELAJAR PESERTA DIDIK</div>
        <div class="font-bold" style="font-size: 10pt; margin-top: 4pt;">
            Semester: <?= $semester == '1' ? '1 (Ganjil)' : '2 (Genap)' ?> &nbsp;&nbsp;&nbsp;&nbsp; Tahun Pelajaran: <?= $year ?>
        </div>
    </div>

    <!-- IDENTITAS -->
    <table class="identity-table" style="font-size: 10pt;">
        <tr>
            <td width="20%">Nama Siswa</td>
            <td width="2%">:</td>
            <td width="38%"><?= $student['full_name'] ?></td>
            <td width="15%">Kelas</td>
            <td width="2%">:</td>
            <td width="23%"><?= $class['name'] ?></td>
        </tr>
        <tr>
            <td>NIS / NISN</td>
            <td>:</td>
            <td><?= $student['nis'] ?> / <?= $student['nisn'] ?? '-' ?></td>
            <td>ID Siswa</td>
            <td>:</td>
            <td style="font-family: monospace;"><?= str_pad($student['id'], 6, '0', STR_PAD_LEFT) ?></td>
        </tr>
    </table>

    <!-- A. SIKAP -->
    <div class="font-bold" style="font-size: 11pt; margin-bottom: 5pt;">A. SIKAP</div>
    <table class="report-table" style="font-size: 10pt;">
        <thead>
            <tr>
                <th width="30%">Dimensi Sikap</th>
                <th>Deskripsi Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">Spiritual</td>
                <td>Sangat baik dalam ketaatan beribadah, berperilaku syukur, dan berdoa sebelum/sesudah kegiatan.</td>
            </tr>
            <tr>
                <td class="text-center">Sosial</td>
                <td>Menunjukkan sikap jujur, disiplin, tanggung jawab, dan santun dalam berinteraksi dengan orang lain.</td>
            </tr>
        </tbody>
    </table>

    <!-- B. PENGETAHUAN DAN KETERAMPILAN -->
    <div class="font-bold" style="font-size: 11pt; margin-bottom: 5pt;">B. NILAI AKADEMIK</div>
    <table class="report-table" style="font-size: 9pt;">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Mata Pelajaran</th>
                <th width="10%">KKM</th>
                <th width="10%">Nilai Akhir</th>
                <th width="40%">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($reportData as $row): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="font-bold"><?= $row['subject'] ?></td>
                <td class="text-center"><?= $row['kkm'] ?></td>
                <td class="text-center font-bold" style="font-size: 11pt;"><?= $row['score'] ?></td>
                <td style="font-size: 8.5pt; line-height: 1.2;">
                    <?php 
                    if ($row['score'] >= 90) echo "Menunjukkan penguasaan yang sangat baik dalam " . strtolower($row['subject']) . ".";
                    elseif ($row['score'] >= 80) echo "Menunjukkan penguasaan yang baik dalam " . strtolower($row['subject']) . ".";
                    elseif ($row['score'] >= 70) echo "Menunjukkan penguasaan yang cukup dalam " . strtolower($row['subject']) . ".";
                    else echo "Perlu pendampingan lebih lanjut dalam memahami materi " . strtolower($row['subject']) . ".";
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Bagian Akhir: Kehadiran, Catatan, dan Tanda Tangan -->
    <div style="margin-top: 10pt;">
        <!-- C & D -->
        <table class="attendance-notes-table" style="font-size: 10pt;">
            <tr>
                <td width="40%">
                    <div class="font-bold" style="margin-bottom: 5pt;">C. KEHADIRAN</div>
                    <table class="report-table" style="width: 100%;">
                        <tr>
                            <td width="60%">Sakit</td>
                            <td class="text-center font-bold"><?= $attendance['S'] ?> Hari</td>
                        </tr>
                        <tr>
                            <td>Izin</td>
                            <td class="text-center font-bold"><?= $attendance['I'] ?> Hari</td>
                        </tr>
                        <tr>
                            <td>Tanpa Keterangan</td>
                            <td class="text-center font-bold"><?= $attendance['A'] ?> Hari</td>
                        </tr>
                    </table>
                </td>
                <td width="5%"></td>
                <td width="55%">
                    <div class="font-bold" style="margin-bottom: 5pt;">D. CATATAN WALI KELAS</div>
                    <div class="box-container" style="font-size: 8.5pt; border: 1pt solid #000; padding: 8pt; min-height: 35pt;">
                        <?= $reportCard['homeroom_notes'] ?? 'Ananda menunjukkan semangat belajar yang baik. Pertahankan prestasimu dan teruslah disiplin dalam mengerjakan tugas.' ?>
                    </div>
                </td>
            </tr>
        </table>

        <?php if($semester == '2'): ?>
        <div class="text-center font-bold uppercase" style="border: 1pt solid #000; padding: 8pt; background: #f9f9f9; margin-top: 10pt; margin-bottom: 10pt; page-break-inside: avoid;">
            Keputusan: Dinyatakan <span class="underline" style="font-size: 11pt;"><?= $reportCard['promotion_status'] ?? 'NAIK' ?></span> ke Kelas <?= (int)filter_var($class['name'], FILTER_SANITIZE_NUMBER_INT) + 1 ?>
        </div>
        <?php endif; ?>

        <!-- TANDA TANGAN LEVEL 1 -->
        <table class="signature-table" style="font-size: 10pt; page-break-inside: avoid;">
            <tr>
                <td width="50%">
                    Mengetahui,<br>Orang Tua / Wali
                    <div class="signature-space"></div>
                    <div class="font-bold uppercase" style="border-bottom: 1pt solid #000; width: 140pt; margin: 0 auto;"><?= $student['parent_name'] ?? '........................' ?></div>
                </td>
                <td width="50%">
                    <div class="signature-box" style="text-align: center; display: block; margin: 0 auto;">
                        <p><?= !empty($school_city) ? $school_city : 'Ditetapkan' ?>, <?= $date ?></p>
                        <p>Wali Kelas</p>
                        <div class="signature-space"></div>
                        <p class="font-bold uppercase" style="border-bottom: 1pt solid #000; width: 170pt; margin: 0 auto;"><?= $homeroom ?></p>
                        <p>NIP. <?= $homeroom_nip ?? '-' ?></p>
                    </div>
                </td>
            </tr>
        </table>

        <!-- TANDA TANGAN LEVEL 2 (KEPALA SEKOLAH) -->
        <div style="margin-top: 15pt; text-align: center; page-break-inside: avoid;">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="text-align: center;">
                        Mengetahui,<br>Kepala Sekolah
                        <div class="signature-space" style="height: 40pt;">
                            <?php if(!empty($school['headmaster_signature'])): ?>
                                <img src="<?= $school['headmaster_signature'] ?>" class="signature-img" style="max-height: 40pt; display: block; margin: 0 auto;" alt="Sign">
                            <?php endif; ?>
                        </div>
                        <div class="font-bold uppercase" style="border-bottom: 1pt solid #000; width: 170pt; margin: 0 auto;">
                            <?= $school['headmaster'] ?>
                        </div>
                        <div style="margin-top: 2pt; font-size: 9pt;">NIP. <?= $school['headmaster_nip'] ?></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>
