<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedEmailTemplates extends Seeder
{
  public function run()
  {
    $data = [
      [
        'name' => 'Reset Password Template',
        'code' => 'reset_password',
        'subject' => 'Reset Password',
        'body' => '<h1><strong>{company_name}</strong></h1>
        <h3>Click on Reset Link to Proceed : <a href="{reset_link}">Reset Now</a></h3>
        <p>Expired link reset <b>{expired_password_reset} minutes.</b></p>',
        'created_at' => '2023-12-14 17:39:00',
        'updated_at' => '2023-12-14 17:39:00',
      ],

    ];

    $this->db->table('email_templates')->insertBatch($data);
  }
}
