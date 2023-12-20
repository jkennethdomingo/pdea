<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Procurement extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'procurement_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'project_particulars' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'date_of_receipt_of_request' => [
                'type' => 'DATE',
            ],
            'purchase_work_job_request_no' => [
                'type' => 'INT',
            ],
            'purchase_work_job_request_date' => [
                'type' => 'DATE',
            ],
            'philgeps_posting' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'abstract_of_canvas_no' => [
                'type' => 'INT',
            ],
            'abstract_of_canvas_date' => [
                'type' => 'DATE',
            ],
            'price_quotation_no' => [
                'type' => 'INT',
            ],
            'price_quotation_date' => [
                'type' => 'DATE',
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'EmployeeID' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'department_id' => [
                'type' => 'INT',
            ],
            'provincial_office_id' => [
                'type' => 'INT',
            ],
            'regional_office_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'supplier' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'date_request_for_fund' => [
                'type' => 'DATE',
            ],
            'ideal_no_of_days_to_complete' => [
                'type' => 'INT',
            ],
            'actual_days_to_complete' => [
                'type' => 'INT',
            ],
            'difference' => [
                'type' => 'INT',
            ],
            'purchase_order' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'delivery_status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'remarks' => [
                'type' => 'TEXT',
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

        $this->forge->addPrimaryKey('procurement_id');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        $this->forge->addForeignKey('department_id', 'department', 'department_id');
        $this->forge->addForeignKey('provincial_office_id', 'provincial_office', 'provincial_office_id');
        $this->forge->addForeignKey('regional_office_id', 'regional_office', 'regional_office_id');

        $this->forge->createTable('procurement');
    }

    public function down()
    {
        $this->forge->dropTable('procurement');
    }
}
