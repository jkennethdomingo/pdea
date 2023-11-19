<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AssetLocation extends Migration
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
            ],
            'department_id' => [
                'type' => 'INT',
            ],
            'provincial_office_id' => [
                'type' => 'INT',
            ],
            'regional_office_id' => [
                'type' => 'INT',
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
        $this->forge->addForeignKey('asset_id', 'asset', 'asset_id');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        $this->forge->addForeignKey('department_id', 'department', 'department_id');
        $this->forge->addForeignKey('provincial_office_id', 'provincial_office', 'provincial_office_id');
        $this->forge->addForeignKey('regional_office_id', 'regional_office', 'regional_office_id');

        $this->forge->createTable('asset_location');
    }

    public function down()
    {
        $this->forge->dropTable('asset_location');
    }
}
