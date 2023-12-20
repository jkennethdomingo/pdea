<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmployeeAddress extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'EmployeeAddressID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'address_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'address_type' => [
                'type' => 'ENUM',
                'constraint' => ['RESIDENTIAL', 'PERMANENT'],
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

        $this->forge->addPrimaryKey('EmployeeAddressID');
        $this->forge->createTable('employee_address');
    }

    public function down()
    {
        $this->forge->dropTable('employee_address');
    }
}
