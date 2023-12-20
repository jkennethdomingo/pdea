<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LeaveType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'LeaveTypeID'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'LeaveTypeName'       => [
                'type'       => 'TEXT',
            ],
            'DefaultLeaveCount'    => [
                'type'       => 'INT',
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

        $this->forge->addPrimaryKey('LeaveTypeID');
        $this->forge->createTable('leave_type');
    }

    public function down()
    {
        $this->forge->dropTable('leave_type');
    }
}
