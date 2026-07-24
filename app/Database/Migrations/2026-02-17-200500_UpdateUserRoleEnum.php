<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserRoleEnum extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru', 'ortu', 'kepsek') DEFAULT 'ortu'");
        
        // Ensure kepsek user has the correct role if it was failed/defaulted
        $this->db->table('users')
             ->where('username', 'kepsek')
             ->update(['role' => 'kepsek']);
    }

    public function down()
    {
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru', 'ortu') DEFAULT 'ortu'");
    }
}
