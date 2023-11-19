<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Additional extends Migration
{public function up()
    {
        // Add new columns to the personal_information table
        $fields = [
            'dual_citizenship_type' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => true,
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
        ];
    
        $this->forge->addColumn('personal_information', $fields);
    }
    
    public function down()
    {
        // Drop the added columns if needed
        $this->forge->dropColumn('personal_information', 'dual_citizenship_type');
        $this->forge->dropColumn('personal_information', 'country');
    }
    
}
