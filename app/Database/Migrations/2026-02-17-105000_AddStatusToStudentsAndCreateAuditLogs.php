<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToStudentsAndCreateAuditLogs extends Migration
{
    public function up()
    {
        // 1. Add status to students
        $fields = [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Aktif', 'Lulus', 'Pindah'],
                'default'    => 'Aktif',
                'after'      => 'photo'
            ],
        ];
        $this->forge->addColumn('students', $fields);

        // 2. Create audit_logs table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'action' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
                'null'       => true,
            ],
            'user_agent' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('audit_logs');
    }

    public function down()
    {
        $this->forge->dropTable('audit_logs');
        $this->forge->dropColumn('students', 'status');
    }
}
