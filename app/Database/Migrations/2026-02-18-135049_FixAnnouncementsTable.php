<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixAnnouncementsTable extends Migration
{
    public function up()
    {
        // 1. Ensure target_role exists
        if (!$this->db->fieldExists('target_role', 'announcements')) {
            $this->forge->addColumn('announcements', [
                'target_role' => [
                    'type'       => 'ENUM',
                    'constraint' => ['all', 'student', 'teacher'],
                    'default'    => 'all',
                    'after'      => 'content',
                ],
            ]);
        }

        // 2. Ensure class_id exists
        if (!$this->db->fieldExists('class_id', 'announcements')) {
            $this->forge->addColumn('announcements', [
                'class_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'target_role',
                ],
            ]);
            
            // Add Foreign Key
            $this->db->query("ALTER TABLE announcements ADD CONSTRAINT fk_announcements_class_id FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL ON UPDATE CASCADE");
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('class_id', 'announcements')) {
            // Drop foreign key first
            try {
                $this->db->query("ALTER TABLE announcements DROP FOREIGN KEY fk_announcements_class_id");
            } catch (\Exception $e) {}
            $this->forge->dropColumn('announcements', 'class_id');
        }

        if ($this->db->fieldExists('target_role', 'announcements')) {
            $this->forge->dropColumn('announcements', 'target_role');
        }
    }
}
