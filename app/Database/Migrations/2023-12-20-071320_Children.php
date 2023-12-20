<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Children extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'child_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'family_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'date_of_birth' => [
                'type' => 'DATE',
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

        $this->forge->addPrimaryKey('child_id');
        $this->forge->addForeignKey('family_id', 'family_background', 'family_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('children', true);
    }

    public function down()
    {
        $this->forge->dropTable('children', true);
    }
}
