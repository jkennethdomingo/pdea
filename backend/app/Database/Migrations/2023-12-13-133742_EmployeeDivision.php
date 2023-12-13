<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmployeeDivision extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'EmpDivID' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'DivisionID' => [
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

        $this->forge->addPrimaryKey('EmpDivID');
        $this->forge->addForeignKey('DivisionID', 'division', 'DivisionID');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');

        $this->forge->createTable('employee_division');
    }

    public function down()
    {
        $this->forge->dropTable('employee_division');
    }
}
