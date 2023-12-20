<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLeaveRequestNotesTable extends Migration
{
    public function up()
    {
        // Creating the 'leave_request_notes' table
        $this->forge->addField([
            'NoteID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'LeaveRequestID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'Note' => [
                'type' => 'TEXT',
            ],
            'CreatedBy' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'CreatedAt' => [
                'type' => 'DATETIME',
            ],
            'TypeOfNote' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('NoteID', true);
        $this->forge->addForeignKey('LeaveRequestID', 'employee_leaves', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('leave_request_notes');
    }

    public function down()
    {
        // Dropping the 'leave_request_notes' table
        $this->forge->dropTable('leave_request_notes');
    }
}
