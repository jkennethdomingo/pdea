<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVocationalAndGraduateStudiesToLevelEnum extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('educational_background', [
            'level' => [
                'type' => 'ENUM',
                'constraint' => ['Elementary', 'Secondary', 'Vocational', 'College', 'GraduateStudies'],
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('educational_background', [
            'level' => [
                'type' => 'ENUM',
                'constraint' => ['Elementary', 'Secondary', 'College'], // original ENUM values
                'null' => false,
            ],
        ]);
    }
}
