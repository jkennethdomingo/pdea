<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Updateonemployeeleave extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['approved', 'pending', 'rejected'],
                'default'    => 'pending',
            ],
        ];

        $this->forge->modifyColumn('employee_leaves', $fields);
    }

    public function down()
    {
        $fields = [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['upcoming', 'current', 'past'],
                'default'    => 'upcoming',
            ],
        ];

        $this->forge->modifyColumn('employee_leaves', $fields);
    }
}
