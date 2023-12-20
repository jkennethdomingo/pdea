<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AssetAudit extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'audit_id'      => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'asset_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'audit_date'    => [
                'type'       => 'TIMESTAMP',
            ],
            'EmployeeID' => [ // Changing AuthRoleID to EmployeeID
                'type' => 'VARCHAR', // Assuming EmployeeID is a VARCHAR based on your JSON payload
                'constraint' => 20, // Adjust the constraint as per your column definition in personal_information
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

        $this->forge->addKey('audit_id', true);
        $this->forge->addForeignKey('asset_id', 'asset', 'asset_id');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID', 'CASCADE', 'CASCADE'); // Adjust the onDelete and onUpdate actions as needed
        $this->forge->createTable('asset_audit');
    }

    public function down()
    {
        $this->forge->dropForeignKey('asset_audit', 'asset_audit_asset_id_foreign');
        $this->forge->dropForeignKey('asset_audit', 'asset_audit_EmployeeID_foreign');
        $this->forge->dropTable('asset_audit');
    }
}
