<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedDepartments extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'    => 'IT',
            ],
            [
                'name'    => 'Planner',
            ],
            [
                'name'    => 'IE',
            ],
            [
                'name'    => 'Production',
            ],

        ];

        $this->db->table('departments')->insertBatch($data);
    }
}
