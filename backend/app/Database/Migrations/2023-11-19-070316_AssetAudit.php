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
            'AuthRoleID' => [
                'type' => 'INT',
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
        $this->forge->addForeignKey('AuthRoleID', 'authentication_roles', 'AuthRoleID');
        $this->forge->createTable('asset_audit');
    }

    public function down()
    {
        $this->forge->dropTable('asset_audit');
    }
}
