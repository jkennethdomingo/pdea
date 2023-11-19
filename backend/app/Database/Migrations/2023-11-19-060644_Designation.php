<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Designation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'DesignationID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'DesignationName' => [
                'type' => 'TEXT',
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
        $this->forge->addKey('DesignationID', true);
        $this->forge->createTable('designation');
    }

    public function down()
    {
        $this->forge->dropTable('designation');
    }
}
