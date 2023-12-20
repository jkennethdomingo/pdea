<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Position extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'PositionID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'PositionName' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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

        $this->forge->addPrimaryKey('PositionID');

        $this->forge->createTable('position');
    }

    public function down()
    {
        $this->forge->dropTable('position');
    }
}
