<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProcurementStatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'status_ID' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'procurement_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'status_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ]
        ]);

        $this->forge->addPrimaryKey('status_ID');
        $this->forge->createTable('procurement_status');
    }

    public function down()
    {
        $this->forge->dropTable('procurement_status');
    }
}
