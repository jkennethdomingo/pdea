<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CivilServiceAlter extends Migration
{
    public function up()
{
    // Add new column 'career_service'
    $this->forge->addColumn('civil_service_eligibility', [
        'career_service' => [
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'after'      => 'EmployeeID', // Specify the position of the new column
        ],
    ]);

    // Drop the old column 'civil_service'
    $this->forge->dropColumn('civil_service_eligibility', 'civil_service');
}


    public function down()
    {
        //
    }
}
