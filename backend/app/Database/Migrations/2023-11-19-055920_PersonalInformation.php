<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PersonalInformation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ],
            'surname' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'name_extension' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
                'default' => null,
            ],
            'middle_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'default' => null,
            ],
            'date_of_birth' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'place_of_birth' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => null,
            ],
            'sex' => [
                'type' => 'ENUM',
                'constraint' => ['M', 'F'],
                'null' => false,
            ],
            'civil_status' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'default' => null,
            ],
            'height' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
                'default' => null,
            ],
            'weight' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
                'default' => null,
            ],
            'blood_type' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
                'null' => true,
                'default' => null,
            ],
            'gsis_id_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'default' => null,
            ],
            'pag_ibig_id_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'default' => null,
            ],
            'philhealth_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'default' => null,
            ],
            'sss_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'default' => null,
            ],
            'tin_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'default' => null,
            ],
            'agency_employee_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'default' => null,
            ],
            'citizenship' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'telephone_no' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true,
                'default' => null,
            ],
            'mobile_no' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true,
                'default' => null,
            ],
            'Email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => null,
            ],
            'Password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => null,
            ],
            'DateOfEntry' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'IPCR' => [
                'type' => 'INT',
                'null' => true,
                'default' => null,
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
        
        $this->forge->addKey('EmployeeID', true);
        $this->forge->createTable('personal_information');
    }

    public function down()
    {
        $this->forge->dropTable('personal_information');
    }
}
