<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Updateaddressfk extends Migration
{
    public function up()
    {
        // This method can be empty if you're only focusing on dropping the table
    }

    public function down()
    {
        $this->forge->dropTable('address', true);
    }
}
