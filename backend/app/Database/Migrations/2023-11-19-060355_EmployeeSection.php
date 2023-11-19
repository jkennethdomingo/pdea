<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmployeeSection extends Migration
{
    public function up()
    {
        // Table structure
        $this->forge->addField([
            'EmpSectID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'SectionID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
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

        // Primary key
        $this->forge->addPrimaryKey('EmpSectID');

        // Foreign keys
        $this->forge->addForeignKey('SectionID', 'section', 'SectionID');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');

        // Create table
        $this->forge->createTable('employee_section');
    }

    public function down()
    {
        // Drop table
        $this->forge->dropTable('employee_section');
    }
}
