<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WorkExperience extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'experience_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'inclusive_dates_from' => [
                'type' => 'DATE',
            ],
            'inclusive_dates_to' => [
                'type' => 'DATE',
            ],
            'position_title' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'department_agency_office_company' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'monthly_salary' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'salary_grade_step_increment' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'status_of_appointment' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'govt_service' => [
                'type' => 'TINYINT',
                'constraint' => 1,
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

        $this->forge->addPrimaryKey('experience_id');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        $this->forge->createTable('work_experience');
    }

    public function down()
    {
        $this->forge->dropTable('work_experience');
    }
}
