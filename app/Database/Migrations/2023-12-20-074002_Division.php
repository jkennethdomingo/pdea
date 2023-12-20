<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Division extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'DivisionID' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'DivisionName' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
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

        $this->forge->addPrimaryKey('DivisionID');
        $this->forge->createTable('division');
    }

    public function down()
    {
        $this->forge->dropTable('division');
    }
}
