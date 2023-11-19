<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GovernmentIssuedIds extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'id_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'date_of_issuance' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'place_of_issuance' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');

        $this->forge->createTable('government_issued_ids', true);
    }

    public function down()
    {
        $this->forge->dropTable('government_issued_ids', true);
    }
}
