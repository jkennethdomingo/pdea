<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EducationalBackground extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'education_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'level' => [
                'type' => 'ENUM',
                'constraint' => ['Elementary', 'Secondary', 'College'],
            ],
            'name_of_school' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'degree_course' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'period_of_attendance_from' => [
                'type' => 'YEAR',
                'null' => true,
            ],
            'period_of_attendance_to' => [
                'type' => 'YEAR',
                'null' => true,
            ],
            'highest_level_units_earned' => [
                'type' => 'INT',
                'null' => true,
            ],
            'year_graduated' => [
                'type' => 'YEAR',
                'null' => true,
            ],
            'scholarship_academic_honors_received' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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

        $this->forge->addPrimaryKey('education_id');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        $this->forge->createTable('educational_background');
    }

    public function down()
    {
        $this->forge->dropTable('educational_background');
    }
}
