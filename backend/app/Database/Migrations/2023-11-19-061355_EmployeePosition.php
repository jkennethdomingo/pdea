<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmployeePosition extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'EmpPosID' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'PositionID' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
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

        $this->forge->addPrimaryKey('EmpPosID');
        $this->forge->addForeignKey('PositionID', 'position', 'PositionID');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');

        $this->forge->createTable('employee_position');
    }

    public function down()
    {
        $this->forge->dropTable('employee_position');
    }
}
