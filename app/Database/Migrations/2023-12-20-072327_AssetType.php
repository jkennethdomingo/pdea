<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AssetType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'asset_type_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'type_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
        ]);

        $this->forge->addKey('asset_type_id', true);
        $this->forge->createTable('asset_type');
    }

    public function down()
    {
        $this->forge->dropTable('asset_type');
    }
}
