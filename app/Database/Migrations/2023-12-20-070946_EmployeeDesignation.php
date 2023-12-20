<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmployeeDesignation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'EmpDesigID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'DesignationID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
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

        $this->forge->addPrimaryKey('EmpDesigID');
        $this->forge->addForeignKey('DesignationID', 'designation', 'DesignationID');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        $this->forge->createTable('employee_designation');
    }

    public function down()
    {
        $this->forge->dropTable('employee_designation');
    }
}
