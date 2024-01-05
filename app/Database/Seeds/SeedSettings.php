<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedSettings extends Seeder
{
    public function run()
    {
        $data = [
            [
                'key'    => 'company_name',
                'value' => 'SisMonProd',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'company_email',
                'value' => 'saepulhidayat302@gmail.com',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],

            [
                'key'    => 'timezone',
                'value' => 'Asia/Jakarta',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'login_theme',
                'value' => '1',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'date_format',
                'value' => 'd F, Y',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'datetime_format',
                'value' => 'h:m a - d M, Y',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'google_recaptcha_enabled',
                'value' => '0',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'google_recaptcha_sitekey',
                'value' => '6LdIWswUAAAAAMRp6xt2wBu7V59jUvZvKWf_rbJc',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'google_recaptcha_secretkey',
                'value' => '6LdIWswUAAAAAIsdboq_76c63PHFsOPJHNR-z-75',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'bg_img_type',
                'value' => 'jpeg',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'default_lang',
                'value' => 'en',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'app_name',
                'value' => 'Sistem Informasi Monitoring Produksi',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'app_favicon',
                'value' => 'favicon.png',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'app_image',
                'value' => 'image.png',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'app_description',
                'value' => 'Mulai lakh dengan rebahan karena rebahan membuat mu, melas ^_^',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'app_version',
                'value' => 'v1.0.0',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'app_year',
                'value' => '2023',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'app_copyright',
                'value' => 'Saepulfariz',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'app_copyright_link',
                'value' => 'https://instagram.com/saepulfariz',
                'created_at' => '2023-10-16 20:00:00.000',
                'updated_at' => '2023-10-16 20:00:00.000',
            ],
            [
                'key'    => 'expired_password_reset',
                'value' => '5',
                'created_at' => '2023-12-13 17:22:00.000',
                'updated_at' => '2023-12-13 17:22:00.000',
            ],
            [
                'key'    => 'expired_cookie',
                'value' => '1',
                'created_at' => '2023-12-13 17:22:00.000',
                'updated_at' => '2023-12-13 17:22:00.000',
            ],
            [
                'key'    => 'page_register',
                'value' => '1',
                'created_at' => '2023-12-15 11:18:00.000',
                'updated_at' => '2023-12-15 11:18:00.000',
            ],
            [
                'key'    => 'page_forgot',
                'value' => '1',
                'created_at' => '2023-12-15 11:18:00.000',
                'updated_at' => '2023-12-15 11:18:00.000',
            ],
            [
                'key'    => 'activity_record',
                'value' => '1',
                'created_at' => '2023-12-16 06:44:00.000',
                'updated_at' => '2023-12-16 06:44:00.000',
            ],
            [
                'key'    => 'activity_error',
                'value' => '1',
                'created_at' => '2023-12-16 06:44:00.000',
                'updated_at' => '2023-12-16 06:44:00.000',
            ],
            [
                'key'    => 'activity_forbidden',
                'value' => '1',
                'created_at' => '2023-12-16 06:44:00.000',
                'updated_at' => '2023-12-16 06:44:00.000',
            ],

        ];

        $this->db->table('settings')->insertBatch($data);
    }
}
