<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DetailedAttendanceSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // 1. Get Academic Years for 2025/2026
        $years = $db->table('academic_years')->where('year', '2025/2026')->get()->getResultArray();
        if (empty($years)) {
            echo "No 2025/2026 academic year found.\n";
            return;
        }

        echo "Populating attendance for 2025/2026 Ganjil and Genap...\n";

        // Pure reset for clean population
        $db->query('SET FOREIGN_KEY_CHECKS=0');
        $db->table('attendance')->truncate();
        $db->query('SET FOREIGN_KEY_CHECKS=1');

        $classes = $db->table('classes')->get()->getResultArray();
        
        $semesterRanges = [
            'Ganjil' => ['start' => '2025-07-21', 'end' => '2025-12-20'],
            'Genap'  => ['start' => '2026-01-05', 'end' => '2026-02-28'],
        ];

        foreach ($years as $year) {
            $academicYearId = $year['id'];
            $range = $semesterRanges[$year['semester']] ?? null;
            if (!$range) continue;

            echo "Targeting: {$year['year']} {$year['semester']} (ID: {$academicYearId}) from {$range['start']} to {$range['end']}\n";

            foreach ($classes as $class) {
                echo "Processing {$class['name']} for {$year['semester']}...\n";
                $students = $db->table('students')->where('class_id', $class['id'])->get()->getResultArray();
                if (empty($students)) continue;

                $currentDate = $range['start'];
                while (strtotime($currentDate) <= strtotime($range['end'])) {
                    $dayOfWeek = date('w', strtotime($currentDate));
                    
                    // Skip Sundays (0)
                    if ($dayOfWeek != 0) {
                        $insertData = [];
                        foreach ($students as $student) {
                            $rand = rand(1, 100);
                            $status = 'H';
                            $note = null;
                            $evidence = null;
                            $verified = 1;

                            if ($rand > 92) {
                                if ($rand <= 95) {
                                    $status = 'S';
                                    $note = 'Sakit demam/flu';
                                    $evidence = 'uploads/attendance/sakit_sample.jpg';
                                    $verified = rand(0, 1);
                                } elseif ($rand <= 98) {
                                    $status = 'I';
                                    $note = 'Izin keperluan keluarga';
                                    $evidence = 'uploads/attendance/izin_sample.jpg';
                                    $verified = rand(0, 1);
                                } else {
                                    $status = 'A';
                                    $note = 'Tanpa keterangan';
                                    $verified = 0;
                                }
                            }

                            $insertData[] = [
                                'student_id'       => $student['id'],
                                'class_id'         => $class['id'],
                                'academic_year_id' => $academicYearId,
                                'date'             => $currentDate,
                                'status'           => $status,
                                'note'             => $note,
                                'evidence_path'    => $evidence,
                                'is_verified'      => $verified,
                                'created_at'       => date('Y-m-d H:i:s'),
                                'updated_at'       => date('Y-m-d H:i:s'),
                            ];
                        }
                        
                        if (!empty($insertData)) {
                            $db->table('attendance')->insertBatch($insertData);
                        }
                    }
                    
                    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                }
            }
        }

        echo "Detailed attendance population completed successfully.\n";
    }
}
