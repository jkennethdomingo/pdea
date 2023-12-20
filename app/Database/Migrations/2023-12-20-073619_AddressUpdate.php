<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddressUpdate extends Migration
{
    public function up()
    {
        // Modify the 'address_type' column to have new ENUM values.
        $fields = [
            'address_type' => [
                'type' => 'ENUM',
                'constraint' => ['Residential', 'Permanent', 'Business', 'Other'], // Add or remove the values you need in your ENUM
                'null' => false,
            ],
        ];

        $this->forge->modifyColumn('address', $fields);
    }

    public function down()
    {
        // Revert the 'address_type' column back to its original ENUM values.
        $fields = [
            'address_type' => [
                'type' => 'ENUM',
                'constraint' => ['Residential', 'Permanent'],
                'null' => false,
            ],
        ];

        $this->forge->modifyColumn('address', $fields);
    }
}
