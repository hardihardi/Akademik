<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HomeroomSyncSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Active year ID is 2 (2025/2026 Genap)
        $activeYearId = 2;
        
        // Get existing assignments from year 1
        $oldAssignments = $db->table('homeroom_assignments')->where('academic_year_id', 1)->get()->getResultArray();
        
        foreach ($oldAssignments as $assignment) {
            // Check if already exists for year 2
            $exists = $db->table('homeroom_assignments')
                         ->where('class_id', $assignment['class_id'])
                         ->where('academic_year_id', $activeYearId)
                         ->countAllResults();
            
            if ($exists === 0) {
                unset($assignment['id']);
                $assignment['academic_year_id'] = $activeYearId;
                $assignment['created_at'] = date('Y-m-d H:i:s');
                $assignment['updated_at'] = date('Y-m-d H:i:s');
                $db->table('homeroom_assignments')->insert($assignment);
            }
        }
    }
}
