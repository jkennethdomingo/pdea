<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Trainingupdate1 extends Migration
{
    public function up()
{
    $this->forge->modifyColumn('training', [
        'title' => [
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'unique'     => true,
        ],
    ]);
}


public function down()
{
    // This part may vary based on the database you are using.
    $this->forge->dropKey('training', 'training_title_unique');
}

}
