<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class VoluntaryWork extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'voluntary_work_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'organization_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'position' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'period_from' => [
                'type' => 'DATE',
            ],
            'period_to' => [
                'type' => 'DATE',
            ],
            'number_of_hours' => [
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

        $this->forge->addPrimaryKey('voluntary_work_id');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        $this->forge->createTable('voluntary_work');
    }

    public function down()
    {
        $this->forge->dropTable('voluntary_work');
    }
}
