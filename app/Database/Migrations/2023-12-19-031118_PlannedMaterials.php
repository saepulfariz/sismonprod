<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PlannedMaterials extends Migration
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
            'ip_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'mat_sap_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'mat_desc' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'target_shift' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'target_hour' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'target_minute' => [
                'type'           => 'INT',
                'constraint'     => 11,
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
        $this->forge->createTable('planned_materials');
    }

    public function down()
    {
        $this->forge->dropTable('planned_materials');
    }
}
