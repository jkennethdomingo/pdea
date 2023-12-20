<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jwtblacklist extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'jti' => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ],
            'iat' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'exp' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('jti'); // Adding index to 'jti' for faster searches
        $this->forge->createTable('jwt_blacklist');
    }

    public function down()
    {
        $this->forge->dropTable('jwt_blacklist');
    }
}
