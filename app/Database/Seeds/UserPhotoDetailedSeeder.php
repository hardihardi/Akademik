<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserPhotoDetailedSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $faker = \Faker\Factory::create('id_ID');

        // 1. Populate Principal (Kepsek) Photo
        $kepsek = $db->table('users')->where('role', 'kepsek')->get()->getRowArray();
        if ($kepsek) {
            // Using a specific ID for kepsek to get a consistent respectable looking photo
            $photoUrl = "https://i.pravatar.cc/150?u=kepsek_principal_" . $kepsek['id'];
            $db->table('users')->where('id', $kepsek['id'])->update(['photo' => $photoUrl]);
            echo "Updated Principal photo.\n";
            
            // If the principal is also a teacher, update the teachers table too
            $teacher = $db->table('teachers')->where('user_id', $kepsek['id'])->get()->getRowArray();
            if ($teacher) {
                $db->table('teachers')->where('id', $teacher['id'])->update(['photo' => $photoUrl]);
            }
        }

        // 2. Populate Parent (Ortu) Photos
        $parents = $db->table('users')->where('role', 'ortu')->get()->getResultArray();
        echo "Updating " . count($parents) . " parent photos...\n";

        foreach ($parents as $parent) {
            // Find linked student to get parent name/gender context
            $student = $db->table('students')->where('user_id', $parent['id'])->get()->getRowArray();
            
            $seed = $parent['username'];
            if ($student) {
                // Try to determine gender from parent_name if it exists
                $parentName = $student['parent_name'] ?: '';
                // Simple heuristic for Indonesian names
                $isFemale = false;
                if (preg_match('/(Ibu|Siti|Sri|Ani|Ratna|Dewi|Novi|Eka|Dwi)/i', $parentName)) {
                    $isFemale = true;
                }
                
                // If it's female, we can use a seed that likely returns a female from pravatar if we're lucky, 
                // or just rely on a unique seed for consistency. 
                // Pravatar doesn't have a gender parameter in the simple URL, but we can use specific ID ranges.
                // However, the ?u= parameter is just for randomness consistency.
            }
            
            $photoUrl = "https://i.pravatar.cc/150?u=parent_" . $parent['id'];
            $db->table('users')->where('id', $parent['id'])->update(['photo' => $photoUrl]);
        }

        echo "Successfully updated " . count($parents) . " parent photos.\n";
    }
}
