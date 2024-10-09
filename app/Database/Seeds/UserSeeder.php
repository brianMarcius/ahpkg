<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
class UserSeeder extends Seeder
{
    public function run()
    {
            $data = [
                [
                    'username'  => 'Pengawas1',
                    'fullname'  => 'Endah Riyanto',
                    'email'     => 'endahr23@gmail.com',
                    'password'  =>  password_hash(123456, PASSWORD_DEFAULT),
                    'decrypted_password' => '123456',
                    'level'     => 1,
                    'school_id' => 0
                ],
                [
                    'username'  => 'Kepsek1',
                    'fullname'  => 'Joko Santoso',
                    'email'     => 'jokosantoso@gmail.com',
                    'password'  =>  password_hash(123456, PASSWORD_DEFAULT),
                    'decrypted_password' => '123456',
                    'level'     => 2,
                    'school_id' => 1
                ],
            ];
            $this->db->table('users')->insertBatch($data);
    }
}
