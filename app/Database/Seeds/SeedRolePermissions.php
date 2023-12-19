<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedRolePermissions extends Seeder
{
    public function run()
    {
        $data = [
            // Users
            [
                'role_id'    => 1,
                'permission_id'    => 1,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 2,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 3,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 4,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 5,
            ],


            // roles
            [
                'role_id'    => 1,
                'permission_id'    => 6,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 7,
            ],

            [
                'role_id'    => 1,
                'permission_id'    => 8,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 9,
            ],

            // Permission
            [
                'role_id'    => 1,
                'permission_id'    => 10,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 11,
            ],

            [
                'role_id'    => 1,
                'permission_id'    => 12,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 13,
            ],


            // settings
            [
                'role_id'    => 1,
                'permission_id'    => 14,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 15,
            ],

            // backup
            [
                'role_id'    => 1,
                'permission_id'    => 16,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 17,
            ],

            // activity
            [
                'role_id'    => 1,
                'permission_id'    => 18,
            ],

            // email templates
            [
                'role_id'    => 1,
                'permission_id'    => 19,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 20,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 21,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 22,
            ],

            // email template send
            [
                'role_id'    => 1,
                'permission_id'    => 23,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 24,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 25,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 26,
            ],

            // email template variable
            [
                'role_id'    => 1,
                'permission_id'    => 27,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 28,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 29,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 30,
            ],


            // departments
            [
                'role_id'    => 1,
                'permission_id'    => 31,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 32,
            ],

            [
                'role_id'    => 1,
                'permission_id'    => 33,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 34,
            ],

            // planned materials
            [
                'role_id'    => 1,
                'permission_id'    => 35,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 36,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 37,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 37,
            ],
            [
                'role_id'    => 1,
                'permission_id'    => 38,
            ],
        ];

        $this->db->table('role_permissions')->insertBatch($data);
    }
}
