<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PersonalInformationPhoto extends Migration
{
    public function up()
    {
        $this->forge->addColumn('personal_information', [
            'photo' => [
                'type' => 'TEXT', // You can change the data type based on your storage needs
                'null' => true,
                'default' => null,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('personal_information', 'photo');
    }
}
