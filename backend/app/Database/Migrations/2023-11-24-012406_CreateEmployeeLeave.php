<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeeLeave extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'leave_type_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'start_date' => [
                'type' => 'DATE',
            ],
            'end_date' => [
                'type' => 'DATE',
            ],
            'reason' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['upcoming', 'current', 'past'],
                'default'    => 'upcoming',
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

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('leave_type_id', 'leave_type', 'LeaveTypeID', 'CASCADE', 'CASCADE');
        $this->forge->createTable('employee_leaves');
    }

    public function down()
    {
        $this->forge->dropTable('employee_leaves');
    }
}
