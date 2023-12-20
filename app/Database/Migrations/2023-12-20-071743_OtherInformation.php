<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OtherInformation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'info_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'special_skills_hobbies' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'non_academic_distinctions_recognition' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'membership_association_organization' => [
                'type' => 'TEXT',
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

        $this->forge->addPrimaryKey('info_id');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        $this->forge->createTable('other_information');
    }

    public function down()
    {
        $this->forge->dropTable('other_information');
    }
}
