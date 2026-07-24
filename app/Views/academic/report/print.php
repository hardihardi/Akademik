<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor_<?= $student['full_name'] ?>_S<?= $semester ?></title>
    <?php $cssVersion = filemtime(FCPATH . 'css/style.css') ?: time(); ?>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>?v=<?= $cssVersion ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet"></noscript>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 15mm;
            }
            body {
                background-color: white !important;
                padding: 0 !important;
            }
            .no-print { display: none !important; }
            .report-container {
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
        }
        
        .report-container {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.4;
            background-color: white;
        }

        .table-report {
            width: 100%;
            border-collapse: collapse;
        }
        .table-report th, .table-report td {
            border: 1px solid black;
            padding: 8px;
            font-size: 13px;
        }
        .table-report th {
            background-color: #f8fafc;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        
        .kop-header {
            border-bottom: 3px double black;
        }

        /* Custom Scrollbar for mobile table */
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>
<body class="p-0 md:p-8">

    <!-- Browser Controls (Responsive) -->
    <div class="max-w-[210mm] mx-auto mb-6 no-print bg-white p-4 md:p-6 rounded-2xl md:rounded-3xl shadow-lg border border-slate-200">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-center md:text-left">
                <h2 class="text-lg md:text-xl font-black text-slate-800 tracking-tight uppercase">Pratinjau Rapor</h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Format Resmi A4</p>
            </div>
            <div class="flex flex-wrap justify-center gap-2">
                <a href="<?= base_url('report/download-pdf/' . $student['id'] . '?semester=' . $semester) ?>" class="px-4 py-2 md:px-6 md:h-12 rounded-xl bg-slate-100 text-slate-600 font-black text-[10px] tracking-widest hover:bg-slate-200 uppercase flex items-center gap-2 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    PDF
                </a>
                <button onclick="window.print()" class="px-5 py-2 md:px-8 md:h-12 rounded-xl bg-indigo-600 text-white font-black text-[10px] tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 uppercase flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    CETAK
                </button>
            </div>
        </div>
    </div>

    <!-- Official Paper -->
    <div class="max-w-[210mm] min-h-[297mm] mx-auto p-6 md:p-[20mm] shadow-2xl report-container border border-gray-100">
        
        <!-- Official KOP -->
        <div class="kop-header flex flex-row items-center gap-4 md:gap-6 pb-4 mb-6">
            <?php if(!empty($school['logo'])): ?>
                <img src="<?= $school['logo'] ?>" class="w-16 h-16 md:w-24 md:h-24 object-contain" alt="Logo">
            <?php endif; ?>
            <div class="flex-1 text-center">
                <h1 class="text-base md:text-xl font-bold uppercase tracking-widest"><?= $school['name'] ?></h1>
                <p class="text-[10px] md:text-sm font-bold uppercase mt-1">Lembaga Pendidikan Dasar Al-Ukhuwah</p>
                <p class="text-[9px] md:text-[11px] font-medium mt-1 leading-tight"><?= $school['address'] ?></p>
                <p class="text-[9px] md:text-[11px] font-medium">Email: <?= $school['email'] ?></p>
            </div>
        </div>

        <div class="text-center mb-8">
            <h2 class="text-md md:text-lg font-bold underline uppercase">LAPORAN HASIL BELAJAR PESERTA DIDIK</h2>
            <div class="flex flex-col md:flex-row justify-center items-center gap-1 md:gap-10 text-[11px] md:text-[12px] font-bold mt-2">
                <span>Semester: <?= $semester == '1' ? '1 (Ganjil)' : '2 (Genap)' ?></span>
                <span>Tahun Pelajaran: <?= $year ?></span>
            </div>
        </div>

        <!-- Identity Grid (Responsive) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-2 mb-8 text-[12px] md:text-[13px]">
            <div class="flex justify-between border-b border-gray-100 md:border-none pb-1">
                <span class="w-1/2 font-bold uppercase text-[10px] text-gray-500 md:text-black md:text-[13px] md:w-40">Nama Lengkap</span>
                <span class="hidden md:inline mr-2">:</span>
                <span class="w-1/2 md:w-full font-bold md:border-b border-black text-right md:text-left"><?= $student['full_name'] ?></span>
            </div>
            <div class="flex justify-between border-b border-gray-100 md:border-none pb-1">
                <span class="w-1/2 font-bold uppercase text-[10px] text-gray-500 md:text-black md:text-[13px] md:w-32">Kelas</span>
                <span class="hidden md:inline mr-2">:</span>
                <span class="w-1/2 md:w-full font-bold md:border-b border-black text-right md:text-left"><?= $class['name'] ?></span>
            </div>
            <div class="flex justify-between border-b border-gray-100 md:border-none pb-1">
                <span class="w-1/2 font-bold uppercase text-[10px] text-gray-500 md:text-black md:text-[13px] md:w-40">NIS / NISN</span>
                <span class="hidden md:inline mr-2">:</span>
                <span class="w-1/2 md:w-full font-bold md:border-b border-black text-right md:text-left"><?= $student['nis'] ?> / <?= $student['nisn'] ?? '-' ?></span>
            </div>
            <div class="flex justify-between border-b border-gray-100 md:border-none pb-1">
                <span class="w-1/2 font-bold uppercase text-[10px] text-gray-500 md:text-black md:text-[13px] md:w-32">ID Siswa</span>
                <span class="hidden md:inline mr-2">:</span>
                <span class="w-1/2 md:w-full font-mono text-gray-400 md:border-b border-black text-right md:text-left"><?= str_pad($student['id'], 6, '0', STR_PAD_LEFT) ?></span>
            </div>
        </div>

        <!-- A. Sikap -->
        <div class="mb-6">
            <p class="font-bold text-[14px] mb-2">A. SIKAP</p>
            <div class="table-wrapper">
                <table class="table-report">
                    <thead>
                        <tr>
                            <th class="w-32">Dimensi</th>
                            <th>Deskripsi Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-bold text-center bg-gray-50">Spiritual</td>
                            <td class="text-justify">Sangat baik dalam ketaatan beribadah, berperilaku syukur, dan berdoa sebelum/sesudah kegiatan.</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-center bg-gray-50">Sosial</td>
                            <td class="text-justify">Menunjukkan sikap jujur, disiplin, tanggung jawab, dan santun dalam berinteraksi dengan orang lain.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- B. Nilai Akademik -->
        <div class="mb-6">
            <p class="font-bold text-[14px] mb-2 uppercase">B. Nilai Akademik</p>
            <div class="table-wrapper">
                <table class="table-report">
                    <thead>
                        <tr>
                            <th class="w-8">No</th>
                            <th class="min-w-[150px] text-left">Mata Pelajaran</th>
                            <th class="w-12">KKM</th>
                            <th class="w-12">Nilai</th>
                            <th class="min-w-[200px]">Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($reportData as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-left font-bold"><?= $row['subject'] ?></td>
                            <td class="text-center"><?= $row['kkm'] ?></td>
                            <td class="text-center font-bold"><?= $row['score'] ?></td>
                            <td class="text-[11px] leading-snug">
                                <?php 
                                if ($row['score'] >= 90) echo "Menunjukkan penguasaan yang sangat baik dalam " . strtolower($row['subject']) . ".";
                                elseif ($row['score'] >= 80) echo "Menunjukkan penguasaan yang baik dalam " . strtolower($row['subject']) . ".";
                                elseif ($row['score'] >= 70) echo "Menunjukkan penguasaan yang cukup dalam " . strtolower($row['subject']) . ".";
                                else echo "Perlu pendampingan lebih lanjut dalam materi " . strtolower($row['subject']) . ".";
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- C & D Section (Responsive Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 mb-10">
            <div>
                <p class="font-bold text-[14px] mb-2">C. KEHADIRAN</p>
                <table class="table-report">
                    <tr>
                        <td class="w-2/3">Sakit (S)</td>
                        <td class="text-center font-bold"><?= $attendance['S'] ?> Hari</td>
                    </tr>
                    <tr>
                        <td>Izin (I)</td>
                        <td class="text-center font-bold"><?= $attendance['I'] ?> Hari</td>
                    </tr>
                    <tr>
                        <td>Tanpa Keterangan (A)</td>
                        <td class="text-center font-bold"><?= $attendance['A'] ?> Hari</td>
                    </tr>
                </table>
            </div>
            <div>
                <p class="font-bold text-[14px] mb-2">D. CATATAN WALI KELAS</p>
                <div class="border border-black p-3 min-h-[85px] text-[12px] leading-relaxed">
                    "<?= $reportCard['homeroom_notes'] ?? 'Pertahankan prestasimu dan teruslah belajar dengan giat.' ?>"
                </div>
            </div>
        </div>

        <!-- E. Keputusan -->
        <?php if($semester == '2'): ?>
        <div class="mb-10 p-4 border-2 border-black font-bold text-center uppercase tracking-widest bg-gray-50 text-sm md:text-base">
            Keputusan: Siswa dinyatakan <span class="underline mx-2"><?= $reportCard['promotion_status'] ?? 'NAIK' ?></span> Ke Kelas Berikutnya
        </div>
        <?php endif; ?>

        <!-- Signatures (Responsive) -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8 text-center text-[13px] md:text-[14px]">
            <!-- Orang Tua -->
            <div class="order-2 md:order-1">
                <p class="font-bold mb-20 md:mb-24">Mengetahui,<br>Orang Tua / Wali</p>
                <div class="border-b border-black w-48 mx-auto"></div>
            </div>

            <!-- Wali Kelas -->
            <div class="order-1 md:order-2">
                <div class="font-bold">
                    <p><?= !empty($school_city) ? $school_city : 'Ditetapkan' ?>, <?= $date ?></p>
                    <p class="mb-20 md:mb-24">Wali Kelas</p>
                    <p class="uppercase underline font-black"><?= $homeroom ?></p>
                    <p class="font-normal">NIP. <?= $homeroom_nip ?? '-' ?></p>
                </div>
            </div>
        </div>

        <!-- Headmaster (Centered) -->
        <div class="mt-12 text-center text-[13px] md:text-[14px]">
            <div class="inline-block relative">
                <p class="font-bold mb-20 md:mb-24">Mengetahui,<br>Kepala Sekolah</p>
                <?php if(!empty($school['headmaster_signature'])): ?>
                    <img src="<?= base_url($school['headmaster_signature']) ?>" class="h-20 absolute top-10 left-1/2 -translate-x-1/2 mix-blend-multiply" alt="TTD">
                <?php endif; ?>
                <p class="font-bold uppercase underline"><?= $school['headmaster'] ?></p>
                <p>NIP. <?= $school['headmaster_nip'] ?></p>
            </div>
        </div>
    </div>

    <!-- Footer Mobile Only -->
    <div class="md:hidden text-center p-6 text-slate-400 text-[10px] font-bold uppercase tracking-widest">
        &copy; <?= date('Y') ?> Sistem Akademik Sekolah
    </div>

    <!-- Digital Footer Print -->
    <div class="hidden md:block max-w-[210mm] mx-auto mt-10 mb-20 text-center no-print border-t border-slate-200 pt-8 opacity-40">
        <p class="text-[10px] font-black uppercase tracking-[0.3em]">Dokumen Digital Resmi &bull; Generated on <?= date('d/m/Y H:i') ?></p>
    </div>

</body>
</html>