<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RolePermissions extends Migration
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
            'role_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'permission_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('role_id', 'roles', 'id', '', '', 'role_permissions_role_id_roles_id');
        $this->forge->addForeignKey('permission_id', 'permissions', 'id', '', '', 'role_permissions_permission_id_permissions_id');
        $this->forge->createTable('role_permissions');
    }

    public function down()
    {
        // $this->forge->dropForeignKey('role_permissions', 'role_permissions_role_id_roles_id');
        // $this->forge->dropForeignKey('role_permissions', 'role_permissions_permission_id_permissions_id');
        $this->forge->dropTable('role_permissions');
    }
}
