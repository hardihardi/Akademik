<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropCurriculumAssignments extends Migration
{
    public function up()
    {
        $this->forge->dropTable('curriculum_assignments', true);
    }

    public function down()
    {
        // No rollback needed as we want it gone
    }
}
