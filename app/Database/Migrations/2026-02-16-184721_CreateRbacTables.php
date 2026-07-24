<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRbacTables extends Migration
{
    public function up()
    {
        // 1. Create Roles Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
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
        $this->forge->createTable('roles');

        // 2. Create Permissions Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
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
        $this->forge->createTable('permissions');

        // 3. Create Role_Permissions Table
        $this->forge->addField([
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'permission_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey(['role_id', 'permission_id'], true); // Composite Key
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'permissions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('role_permissions');

        // 4. Create Users_Roles Table
        $this->forge->addField([
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey(['user_id', 'role_id'], true); // Composite Key
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users_roles');

        // --- MIGRATION DATA ---
        
        // Seed default roles
        $db = \Config\Database::connect();
        $builder = $db->table('roles');
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator with full access'],
            ['name' => 'guru', 'description' => 'Teacher with academic access'],
            ['name' => 'ortu', 'description' => 'Parent/Student with view access'], // Mapping 'ortu' to include student for now based on ENUM
            ['name' => 'siswa', 'description' => 'Student'], 
        ];
        $builder->insertBatch($roles);

        // Migrate existing users from 'role' column to 'users_roles' table
        $users = $db->table('users')->get()->getResultArray();
        $userRoles = [];
        
        // Get Role IDs
        $roleIds = [];
        foreach($roles as $r) {
            $roleQuery = $db->table('roles')->where('name', $r['name'])->get()->getRow();
            if($roleQuery) {
                $roleIds[$r['name']] = $roleQuery->id;
            }
        }

        foreach ($users as $user) {
            $roleName = $user['role']; // 'admin', 'guru', 'ortu'
            if (isset($roleIds[$roleName])) {
                $userRoles[] = [
                    'user_id' => $user['id'],
                    'role_id' => $roleIds[$roleName],
                ];
            }
        }

        if (!empty($userRoles)) {
            $db->table('users_roles')->insertBatch($userRoles);
        }
    }

    public function down()
    {
        $this->forge->dropTable('users_roles');
        $this->forge->dropTable('role_permissions');
        $this->forge->dropTable('permissions');
        $this->forge->dropTable('roles');
    }
}
