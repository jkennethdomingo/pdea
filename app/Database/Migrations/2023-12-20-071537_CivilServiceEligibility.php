<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CivilServiceEligibility extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'eligibility_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'civil_service' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'rating' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'date_of_examination' => [
                'type' => 'DATE',
            ],
            'place_of_examination' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'license_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'license_date_of_validity' => [
                'type' => 'DATE',
                'null' => true,
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

        $this->forge->addPrimaryKey('eligibility_id');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');

        $this->forge->createTable('civil_service_eligibility', true);
    }

    public function down()
    {
        $this->forge->dropTable('civil_service_eligibility', true);
    }
}
