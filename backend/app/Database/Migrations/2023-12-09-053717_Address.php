<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Address extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'address_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'address_type' => [
                'type' => 'ENUM("Residential", "Permanent")',
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'city_municipality' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'barangay' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'subdivision_village' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'street' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'house_block_lot' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'zip_code' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
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

        $this->forge->addKey('address_id', true);
        $this->forge->createTable('address');
    }

    public function down()
    {
        $this->forge->dropTable('address');
    }
}
