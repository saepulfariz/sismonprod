<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AcitivityLogs extends Migration
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
            'title' => [
                'type'       => 'TEXT',
            ],
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'ip_address' => [
                'type'       => 'TEXT',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', '', 'activity_logs_user_id_users_id');
        $this->forge->createTable('activity_logs');
    }

    public function down()
    {
        // $this->forge->dropForeignKey('activity_logs', 'activity_logs_user_id_users_id');
        $this->forge->dropTable('activity_logs');
    }
}
