<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPromotionStatusToReportCards extends Migration
{
    public function up()
    {
        $fields = [
            'promotion_status' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'after'      => 'homeroom_notes',
            ],
        ];
        $this->forge->addColumn('report_cards', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('report_cards', 'promotion_status');
    }
}
