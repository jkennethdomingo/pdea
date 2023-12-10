<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemakeAssetLocation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'location_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'asset_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true, // Making it nullable
            ],
            'department_id' => [
                'type' => 'INT',
                'null' => true, // Making it nullable
            ],
            'provincial_office_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true, // Making it nullable
            ],
            'regional_office_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true, // Making it nullable
            ],
            'remarks_whereabouts' => [
                'type' => 'TEXT',
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

        $this->forge->addKey('location_id', true);
        $this->forge->addForeignKey('asset_id', 'asset', 'asset_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('department_id', 'department', 'department_id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('provincial_office_id', 'provincial_office', 'provincial_office_id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('regional_office_id', 'regional_office', 'regional_office_id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('asset_location');
    }

    public function down()
    {
        //
    }
}
