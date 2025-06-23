<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prodi;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'kode_prodi' => '58302',
                'singkatan_prodi' => 'TRPL',
            ],
            [
                'nama_prodi' => 'Teknologi Rekayasa Komputer dan jaringan',
                'kode_prodi' => '56301',
                'singkatan_prodi' => 'TRK',
            ],
            [
                'nama_prodi' => 'Bisnis Digital',
                'kode_prodi' => '61316',
                'singkatan_prodi' => 'BSD',
            ],
        ];

        foreach ($data as $item) {
            Prodi::create($item);
        }
    }
}
