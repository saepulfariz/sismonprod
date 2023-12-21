<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PlannedCuring extends Migration
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
            'ip_seven' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'ip_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'cost_center' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'brand' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'mch_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'rim' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'p_date' => [
                'type'           => 'DATE',
            ],
            'week' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'qty' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
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
        $this->forge->addForeignKey('cid', 'users', 'id', '', '', 'planned_curing_cid_users_id');
        // $this->forge->addForeignKey('uid', 'users', 'id', '', '', 'planned_curing_uid_users_id');
        $this->forge->createTable('planned_curing');
    }

    public function down()
    {
        $this->forge->dropTable('planned_curing');
    }
}
