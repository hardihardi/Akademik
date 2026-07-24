<?php

if (!function_exists('export_to_csv')) {
    /**
     * Export data to CSV and stream to browser
     */
    function export_to_csv($filename, $header, $data)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8 (Excel compatibility)
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Write headers
        fputcsv($output, $header);
        
        // Write data
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit;
    }
}

if (!function_exists('export_to_pdf')) {
    /**
     * Export data to PDF using Dompdf
     */
    function export_to_pdf($template, $data, $filename, $paper = 'A4', $orientation = 'portrait')
    {
        $dompdf = new \Dompdf\Dompdf([
            'isRemoteEnabled' => false,
            'chroot' => str_replace('\\', '/', FCPATH),
            'isHtml5ParserEnabled' => true,
            'isFontSubsettingEnabled' => true,
        ]);

        $html = view($template, $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $dompdf->output();
        exit;
    }
}
