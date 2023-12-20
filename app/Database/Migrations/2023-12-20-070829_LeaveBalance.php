<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LeaveBalance extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'LeaveBalanceID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'LeaveTypeID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'NumberofLeaves' => [
                'type' => 'INT',
                'constraint' => 11,
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

        $this->forge->addPrimaryKey('LeaveBalanceID');
        $this->forge->addForeignKey('LeaveTypeID', 'leave_type', 'LeaveTypeID');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        
        $this->forge->createTable('leave_balance');
    }

    public function down()
    {
        $this->forge->dropTable('leave_balance');
    }
}
