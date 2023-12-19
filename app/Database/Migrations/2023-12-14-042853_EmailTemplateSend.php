<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmailTemplateSend extends Migration
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
            'template_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'is_send' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default' => 1
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('template_id', 'email_templates', 'id');

        $this->forge->createTable('email_template_send');
    }

    public function down()
    {
        $this->forge->dropTable('email_template_send');
    }
}
