<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TrainingPrograms extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'training_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'period_from' => [
                'type' => 'DATE',
            ],
            'period_to' => [
                'type' => 'DATE',
            ],
            'number_of_hours' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'conducted_by' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'is_company_provided' => [
                'type' => 'BOOLEAN',
                'default' => false,
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

        $this->forge->addPrimaryKey('training_id');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');

        $this->forge->createTable('training_programs');
    }

    public function down()
    {
        $this->forge->dropTable('training_programs');
    }
}
