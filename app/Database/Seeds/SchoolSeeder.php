<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'schoolname'  => 'SMKN 7 Semarang',
                'npsn'  => '123123123',
                'address'     => 'Jl. Simpang Lima',
                'telp'  =>  '08127283728',
                'logo' => ''
            ],
            [
                'schoolname'  => 'SMKN 8 Semarang',
                'npsn'  => '123123123',
                'address'     => 'Jl. nin aja dulu',
                'telp'  =>  '08127283728',
                'logo' => ''
            ],        ];
        $this->db->table('schools')->insertBatch($data);

    }
}
