<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddArticleToAsset extends Migration
{
    public function up()
    {
        $fields = [
            'article' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'description', // Specify the column after which the new column should be added
            ],
        ];
        $this->forge->addColumn('asset', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('asset', 'article');
    }
}
