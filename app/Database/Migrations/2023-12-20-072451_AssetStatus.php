<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AssetStatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'status_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'asset_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,

            ],
            'qty_per_property_card' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'physical_count' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'shortage_overage_qty' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'shortage_overage_value' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => null,
            ],
            'updated_at' => [
                  'type' => 'TIMESTAMP',
                  'null' => true,
                  'default' => null,
            ],
        ]);

        $this->forge->addPrimaryKey('status_id');
        $this->forge->addForeignKey('asset_id', 'asset', 'asset_id');

        $this->forge->createTable('asset_status', true);
    }

    public function down()
    {
        $this->forge->dropTable('asset_status', true);
    }
}
