<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RegionalOffice extends Migration
{
    public function up()
    {
        // Define the regional_office table
        $this->forge->addField([
            'regional_office_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'regional_office_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
        ]);

        // Set the primary key
        $this->forge->addPrimaryKey('regional_office_id');

        // Create the regional_office table
        $this->forge->createTable('regional_office', true);
    }

    public function down()
    {
        // Drop the regional_office table
        $this->forge->dropTable('regional_office');
    }
}
