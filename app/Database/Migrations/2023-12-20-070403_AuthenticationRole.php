<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AuthenticationRole extends Migration
{
    public function up(){

        $this->forge->addField([
          'AuthRoleID' => [
            'type' => 'INT',
            'auto_increment' => true,  
          ],
          'AuthRoleName' => [
            'type' => 'TEXT',
            'null' => false,
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
      
        $this->forge->addKey('AuthRoleID', true);
        $this->forge->createTable('authentication_roles');
      
      }
      
      public function down(){
        $this->forge->dropTable('authentication_roles');
      }
}
