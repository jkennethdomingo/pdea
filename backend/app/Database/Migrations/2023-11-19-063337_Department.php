<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Department extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'department_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'department_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('department_id');
        $this->forge->createTable('department');
    }

    public function down()
    {
        $this->forge->dropTable('department');
    }
}
