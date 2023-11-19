<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ReferencesTbl extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'reference_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'telephone_no' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
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

        $this->forge->addPrimaryKey('reference_id');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');

        $this->forge->createTable('references_tbl');
    }

    public function down()
    {
        $this->forge->dropTable('references_tbl');
    }
}
