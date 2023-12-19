<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedEmailTemplateVariables extends Seeder
{
  public function run()
  {
    $data = [
      [
        'template_id' => 1,
        'variable_name' => '{reset_link}',
      ],
      [
        'template_id' => 1,
        'variable_name' => '{name}',
      ],
      [
        'template_id' => 1,
        'variable_name' => '{username}',
      ],
      [
        'template_id' => 1,
        'variable_name' => '{email}',
      ],
      [
        'template_id' => 1,
        'variable_name' => '{company_name}',
      ],
      [
        'template_id' => 1,
        'variable_name' => '{expired_password_reset}',
      ],
    ];

    $this->db->table('email_template_variables')->insertBatch($data);
  }
}
