<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Training extends Migration
{
    public function up()
    {
        // Table structure
        $this->forge->addField([
            'training_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'period_from' => [
                'type' => 'DATE',
            ],
            'period_to' => [
                'type' => 'DATE',
            ],
            'number_of_hours' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'conducted_by' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addPrimaryKey('training_id');

        // Create the table
        $this->forge->createTable('training', true);
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('training', true);
    }
}
