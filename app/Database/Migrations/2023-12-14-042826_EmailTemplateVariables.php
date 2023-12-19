<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmailTemplateVariables extends Migration
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
            'variable_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('template_id', 'email_templates', 'id');

        $this->forge->createTable('email_template_variables');
    }

    public function down()
    {
        $this->forge->dropTable('email_template_variables');
    }
}
