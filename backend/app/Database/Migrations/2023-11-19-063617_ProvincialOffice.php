<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProvincialOffice extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'provincial_office_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'office_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'location' => [
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->addKey('provincial_office_id', true);
        $this->forge->addUniqueKey('office_name');
        $this->forge->createTable('provincial_office');
    }

    public function down()
    {
        $this->forge->dropTable('provincial_office');
    }
}
