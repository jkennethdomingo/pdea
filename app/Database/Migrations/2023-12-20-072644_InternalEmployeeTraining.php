<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InternalEmployeeTraining extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'internal_training_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'training_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'attendance_date' => [
                'type' => 'DATE',
            ],
        ]);

        $this->forge->addKey('internal_training_id', true);
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        $this->forge->addForeignKey('training_id', 'training', 'training_id');

        $this->forge->createTable('internal_employee_training');
    }

    public function down()
    {
        $this->forge->dropTable('internal_employee_training');
    }
}
