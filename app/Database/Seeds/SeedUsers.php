<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedUsers extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'    => 'anonymous',
                'username' => 'anony',
                'email'    => 'anony@gmail.com',
                'password' => password_hash('anony', PASSWORD_DEFAULT),
                'address'    => '',
                'phone'    => '',
                'image' => 'default.jpg',
                'is_active' => 1,
                'role_id' => 1,
                'cid' => 1,
                'uid' => 1,
                'last_login' => '2023-12-11 17:27:00.000',
                'created_at' => '2023-12-11 17:27:00.000',
                'updated_at' => '2023-12-11 17:27:00.000',
            ],
            [
                'name'    => 'Administrator',
                'username' => 'admin',
                'email'    => 'administrator@gmail.com',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'address'    => '',
                'phone'    => '',
                'image' => 'default.jpg',
                'is_active' => 1,
                'role_id' => 1,
                'cid' => 1,
                'uid' => 1,
                'last_login' => '2023-12-11 17:27:00.000',
                'created_at' => '2023-12-11 17:27:00.000',
                'updated_at' => '2023-12-11 17:27:00.000',
            ],
            [
                'name'    => 'Member',
                'username' => 'member',
                'email'    => 'member@gmail.com',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'address'    => '',
                'phone'    => '',
                'image' => 'default.jpg',
                'is_active' => 1,
                'role_id' => 2,
                'cid' => 1,
                'uid' => 1,
                'last_login' => '2023-12-11 17:27:00.000',
                'created_at' => '2023-12-13 10:17:00.000',
                'updated_at' => '2023-12-13 10:17:00.000',
            ],
            [
                'name'    => 'Saepul Hidayat',
                'username' => 'saepul',
                'email'    => 'saepulhidayat302@gmail.com',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'address'    => '',
                'phone'    => '',
                'image' => 'default.jpg',
                'is_active' => 1,
                'role_id' => 2,
                'cid' => 1,
                'uid' => 1,
                'last_login' => '2023-12-11 17:27:00.000',
                'created_at' => '2023-12-13 10:17:00.000',
                'updated_at' => '2023-12-13 10:17:00.000',
            ],

        ];

        $this->db->table('users')->insertBatch($data);
    }
}
