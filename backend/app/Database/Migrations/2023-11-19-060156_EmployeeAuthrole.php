<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmployeeAuthrole extends Migration
{
    public function up(){

        $this->forge->addField([
          'AuthRoleID' => [
            'type' => 'INT',
            'null' => false,
          ],
          'EmpAuthID' => [
            'type' => 'INT',
            'auto_increment' => true,
          ],
          'EmployeeID' => [
            'type' => 'VARCHAR',
            'constraint' => '20',
            'null' => false,
          ]
        ]);
      
        $this->forge->addKey('EmpAuthID', true);
        $this->forge->addForeignKey('AuthRoleID', 'authentication_roles', 'AuthRoleID');
        $this->forge->addForeignKey('EmployeeID', 'personal_information', 'EmployeeID');
        
        $this->forge->createTable('employee_authroles');
      
      }
      
      public function down(){
        $this->forge->dropTable('employee_authroles');
      }
}
