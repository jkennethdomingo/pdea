<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FamilyBackground extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'family_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'spouse_first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'spouse_name_extension' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'spouse_middle_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'spouse_surname' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'spouse_occupation' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'spouse_employer_business_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'spouse_business_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'spouse_telephone_no' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
            ],
            'father_surname' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'father_first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'father_middle_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'father_name_extension' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'mother_maiden_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'mother_surname' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'mother_first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'mother_middle_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
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

        $this->forge->addKey('family_id', true);
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        $this->forge->createTable('family_background');
    }

    public function down()
    {
        $this->forge->dropTable('family_background');
    }
}
