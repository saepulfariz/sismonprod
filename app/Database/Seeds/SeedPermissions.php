<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedPermissions extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title'    => 'Users List',
                'code'    => 'users_list',
            ],
            [
                'title'    => 'Users Add',
                'code'    => 'users_add',
            ],
            [
                'title'    => 'Users Edit',
                'code'    => 'users_edit',
            ],
            [
                'title'    => 'Users Delete',
                'code'    => 'users_delete',
            ],
            [
                'title'    => 'Users View',
                'code'    => 'users_view',
            ],


            [
                'title'    => 'Roles List',
                'code'    => 'roles_list',
            ],
            [
                'title'    => 'Roles Add',
                'code'    => 'roles_add',
            ],
            [
                'title'    => 'Roles Edit',
                'code'    => 'roles_edit',
            ],
            [
                'title'    => 'Roles Delete',
                'code'    => 'roles_delete',
            ],


            [
                'title'    => 'Permissions List',
                'code'    => 'permissions_list',
            ],
            [
                'title'    => 'Permissions Add',
                'code'    => 'permissions_add',
            ],
            [
                'title'    => 'Permissions Edit',
                'code'    => 'permissions_edit',
            ],
            [
                'title'    => 'Permissions Delete',
                'code'    => 'permissions_delete',
            ],

            [
                'title'    => 'Company Settings',
                'code'    => 'company_settings',
            ],
            [
                'title'    => 'General Settings',
                'code'    => 'general_settings',
            ],
            [
                'title'    => 'Backup',
                'code'    => 'backup_db',
            ],

            [
                'title'    => 'Activity Logs List',
                'code'    => 'activity_log_list',
            ],
            [
                'title'    => 'Acivity Log View',
                'code'    => 'activity_log_view',
            ],

            [
                'title'    => 'Email Templates List',
                'code'    => 'email_templates_list',
            ],
            [
                'title'    => 'Email Templates Add',
                'code'    => 'email_templates_add',
            ],
            [
                'title'    => 'Email Templates Edit',
                'code'    => 'email_templates_edit',
            ],
            [
                'title'    => 'Email Templates Delete',
                'code'    => 'email_templates_delete',
            ],

            [
                'title'    => 'Email Template Send List',
                'code'    => 'email_template_send_list',
            ],
            [
                'title'    => 'Email Template Send Add',
                'code'    => 'email_template_send_add',
            ],
            [
                'title'    => 'Email Template Send Edit ',
                'code'    => 'email_template_send_edit',
            ],
            [
                'title'    => 'Email Template Send Delete ',
                'code'    => 'email_template_send_delete',
            ],

            [
                'title'    => 'Email Template Variables List',
                'code'    => 'email_template_variables_list',
            ],
            [
                'title'    => 'Email Template Variables Add ',
                'code'    => 'email_template_variables_add',
            ],
            [
                'title'    => 'Email Template Variables Edit ',
                'code'    => 'email_template_variables_edit',
            ],
            [
                'title'    => 'Email Template Variables Delete',
                'code'    => 'email_template_variables_delete',
            ],

            [
                'title'    => 'Planned Materials List',
                'code'    => 'planned_materials_list',
            ],
            [
                'title'    => 'Planned Materials Add',
                'code'    => 'planned_materials_add',
            ],
            [
                'title'    => 'Planned Materials Edit',
                'code'    => 'planned_materials_edit',
            ],
            [
                'title'    => 'Planned Materials Delete',
                'code'    => 'planned_materials_delete',
            ],
            [
                'title'    => 'Planned Materials Import',
                'code'    => 'planned_materials_import',
            ],

        ];

        $this->db->table('permissions')->insertBatch($data);
    }
}
