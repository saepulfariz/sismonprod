<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class All extends Seeder
{
    public function run()
    {
        $this->call('SeedSettings');
        $this->call('SeedRoles');
        $this->call('SeedUsers');
        $this->call('SeedPermissions');
        $this->call('SeedRolePermissions');
        $this->call('SeedEmailTemplates');
        $this->call('SeedEmailTemplateVariables');
    }
}
