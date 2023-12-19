<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PasswordResetTokens extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'token' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);
        $this->forge->createTable('password_reset_tokens');
    }

    public function down()
    {
        $this->forge->dropTable('password_reset_tokens');
    }
}
