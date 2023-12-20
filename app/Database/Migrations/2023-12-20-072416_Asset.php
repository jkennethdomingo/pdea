<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Asset extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'asset_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'asset_type_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'yr_acquired' => [
                'type' => 'DATE',
            ],
            'serial_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'property_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'unit_of_measure' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'unit_value' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'item_status' => [
                'type' => 'ENUM',
                'constraint' => ['Active', 'Archived'],
                'default' => 'Active',
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

        $this->forge->addKey('asset_id', true);
        $this->forge->addForeignKey('asset_type_id', 'asset_type', 'asset_type_id');
        $this->forge->createTable('asset');
    }

    public function down()
    {
        $this->forge->dropTable('asset');
    }
}
