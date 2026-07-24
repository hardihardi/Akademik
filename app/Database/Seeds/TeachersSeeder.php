<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TeachersSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $name = $faker->name($gender);
            $username = strtolower(str_replace([' ', '.', '\''], '', $name)) . $faker->numberBetween(1, 99);
            
            // Create User
            $this->db->table('users')->insert([
                'username'      => $username,
                'password_hash' => password_hash('guru123', PASSWORD_BCRYPT),
                'email'         => $username . '@sekolah.id',
                'role'          => 'guru',
                'active'        => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
            $userId = $this->db->insertID();

            // Create Teacher
            $this->db->table('teachers')->insert([
                'user_id'    => $userId,
                'nip'        => $faker->unique()->numberBetween(19800000, 19999999), 
                'full_name'  => $name . ($gender == 'male' ? ', S.Pd.' : ', M.Pd.'),
                'phone'      => $faker->phoneNumber,
                'address'    => $faker->address,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
