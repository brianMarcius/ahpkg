<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'level'  => 'Pengawas',
            ],
            [
                'level'  => 'Kepala Sekolah',
            ],
        ];
        $this->db->table('levels')->insertBatch($data);

    }
}
