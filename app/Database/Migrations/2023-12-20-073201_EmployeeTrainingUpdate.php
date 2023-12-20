<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmployeeTrainingUpdate extends Migration
{
    public function up()
    {
        // Modify the 'attendance_date' column to allow null values
        $this->forge->modifyColumn('internal_employee_training', [
            'attendance_date' => [
                'type'       => 'DATE',
                'null'       => true,
                'default'    => null
            ],
        ]);
    }

    public function down()
    {
        // Revert the 'attendance_date' column to not allow null values
        $this->forge->modifyColumn('internal_employee_training', [
            'attendance_date' => [
                'type'       => 'DATE',
                'null'       => false,
                // You might want to set the previous default value if it was different
            ],
        ]);
    }
}
