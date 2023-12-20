<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Section extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'SectionID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'SectionName' => [
                'type' => 'TEXT',
                'null' => false,
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

        $this->forge->addKey('SectionID', true);
        $this->forge->createTable('section', true);
    }

    public function down()
    {
        $this->forge->dropTable('section', true);
    }
}
