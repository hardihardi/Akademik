<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportCardsAndModifyAnnouncements extends Migration
{
    public function up()
    {
        // 1. Create report_cards table if it doesn't exist
        if (!$this->db->tableExists('report_cards')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'student_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'academic_year_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'semester' => [
                    'type'       => 'ENUM',
                    'constraint' => ['1', '2'],
                    'default'    => '1',
                ],
                'homeroom_notes' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['Draft', 'Submitted', 'Validated'],
                    'default'    => 'Draft',
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey(['student_id', 'academic_year_id', 'semester']);
            $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
            $this->forge->addForeignKey('academic_year_id', 'academic_years', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('report_cards');
        }

        // 2. Modify announcements table to add class_id if it doesn't exist
        try {
            if (!$this->db->fieldExists('class_id', 'announcements')) {
                $fields = [
                    'class_id' => [
                        'type'       => 'INT',
                        'constraint' => 11,
                        'unsigned'   => true,
                        'null'       => true,
                        'after'      => 'target_role',
                    ],
                ];
                $this->forge->addColumn('announcements', $fields);
            }
        } catch (\Exception $e) {
            // Column already exists, skip
        }

        // Add FK if not already present
        try {
            $this->db->query("ALTER TABLE announcements ADD CONSTRAINT fk_announcements_class_id FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL ON UPDATE CASCADE");
        } catch (\Exception $e) {
            // FK already exists, skip
        }
    }

    public function down()
    {
        if ($this->db->tableExists('report_cards')) {
            $this->forge->dropTable('report_cards');
        }
        if ($this->db->fieldExists('class_id', 'announcements')) {
            // Drop foreign key first
            $this->db->query("ALTER TABLE announcements DROP FOREIGN KEY fk_announcements_class_id");
            $this->forge->dropColumn('announcements', 'class_id');
        }
    }
}
