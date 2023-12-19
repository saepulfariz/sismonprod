<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'default' => 'default.jpg'
            ],
            'address' => [
                'type'       => 'TEXT',
            ],
            // 'last_login' => [
            //     'type'       => 'DATETIME',
            //     // 'default' => 'CURRENT_TIMESTAMP',
            //     // 'on' => 'UPDATE CURRENT_TIMESTAMP'
            //     'null' => true
            // ],
            // 'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            // 'last_login DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'last_login DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            // https://www.petanikode.com/codeigniter4-migration/
            // current_timestamp()
            'role_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'is_active' => [
                'type'           => 'INT',
                'constraint'     => 1,
                'default'       => 1,
            ],
            'email_verified_at' => [
                'type'           => 'DATETIME',
                'null' => true,
            ],
            'cid' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null' => true,
                'unsigned'       => true,
            ],
            'uid' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null' => true,
                'unsigned'       => true,
            ],
            'did' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null' => true,
                'unsigned'       => true,
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type'           => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email', 'email');
        $this->forge->addUniqueKey('username', 'username');
        /*
        CASCADE
        SET_NULL
        NO_ACTION
        RESTRICT (Default)
        */
        $this->forge->addForeignKey('role_id', 'roles', 'id', '', '', 'users_role_id_roles_id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        // $this->forge->dropForeignKey('users', 'users_role_id_roles_id');
        $this->forge->dropTable('users');
    }
}
