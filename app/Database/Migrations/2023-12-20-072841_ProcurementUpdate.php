<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProcurementUpdate extends Migration
{
    public function up()
    {
        // Assuming 'procurement' is your table name
        $fields = [
            'item_status' => [
                'type'       => 'ENUM',
                'constraint' => ['Active', 'Archived'],
                'default'    => 'Active',
                'null'       => false,
            ],
        ];

        $this->forge->addColumn('procurement', $fields);
    }

    public function down()
    {
        // Drop the column 'item_status' from 'procurement' table
        $this->forge->dropColumn('procurement', 'item_status');
    }
}
