<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TeacherPhotoSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $teachers = $db->table('teachers')->get()->getResultArray();

        foreach ($teachers as $teacher) {
            // Using pravatar.cc with the teacher's ID as a seed to get consistent photos
            // We use different starting offsets for genders if we could detect them, 
            // but for now, we'll just use the ID.
            $photoUrl = "https://i.pravatar.cc/150?u=" . $teacher['nip'];
            
            $db->table('teachers')
               ->where('id', $teacher['id'])
               ->update(['photo' => $photoUrl]);
               
            // Also update the user table if it has a photo column and is used for the same thing
            $db->table('users')
               ->where('id', $teacher['user_id'])
               ->update(['photo' => $photoUrl]);
        }

        echo "Successfully updated " . count($teachers) . " teacher photos.\n";
    }
}
