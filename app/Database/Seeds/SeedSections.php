<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedSections extends Seeder
{
    public function run()
    {
        $data = [
            [
                'dept_id'    => 1,
                'name'    => 'Staff',
            ],
            [
                'dept_id'    => 2,
                'name'    => 'Staff',
            ],
            [
                'dept_id'    => 3,
                'name'    => 'Enginer',
            ],
            [
                'dept_id'    => 3,
                'name'    => 'Trainer',
            ],
            [
                'dept_id'    => 4,
                'name'    => 'Staff',
            ],


        ];

        $this->db->table('sections')->insertBatch($data);
    }
}
