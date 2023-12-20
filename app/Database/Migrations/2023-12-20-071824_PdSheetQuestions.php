<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PdSheetQuestions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'question_id'      => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'EmployeeID'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],
            'question_code'    => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],
            'question_text'    => [
                'type'           => 'TEXT',
            ],
            'answer'           => [
                'type'           => 'ENUM',
                'constraint'     => ['Yes', 'No'],
            ],
            'details'          => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'date_of_event'    => [
                'type'           => 'DATE',
                'null'           => true,
            ],
            'status_or_remarks' => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => null,
            ],
            'updated_at' => [
                  'type' => 'TIMESTAMP',
                  'null' => true,
                  'default' => null,
            ],
        ]);

        $this->forge->addKey('question_id', true);
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        $this->forge->createTable('pd_sheet_questions');
    }

    public function down()
    {
        $this->forge->dropTable('pd_sheet_questions');
    }
}
