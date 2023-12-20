<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProcurementStatusUpdate extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('procurement', [
            'department_id' => [
                'type' => 'INT',
                'null' => true, // Allowing null values
            ],
            'provincial_office_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'regional_office_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('procurement', [
            'department_id' => [
                'type' => 'INT',
                'null' => false, // Assuming original was NOT NULL
            ],
            'provincial_office_id' => [
                'type' => 'INT',
                'null' => false,
            ],
            'regional_office_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
        ]);
    }
}
