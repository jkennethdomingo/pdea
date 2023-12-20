<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterLeaveRequestNotesTable extends Migration
{
    public function up()
    {
        // Modify the 'Note' column to allow NULL values
        $fields = [
            'Note' => [
                'type'       => 'TEXT',
                'null'       => true, // Allow NULL values
                'default'    => null, // Set default to NULL
            ],
        ];
        $this->forge->modifyColumn('leave_request_notes', $fields);
    }

    public function down()
    {
        // Revert the 'Note' column to not allow NULL values
        $fields = [
            'Note' => [
                'type'       => 'TEXT',
                'null'       => false, // Disallow NULL values
            ],
        ];
        $this->forge->modifyColumn('leave_request_notes', $fields);
    }
}
