<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjarans = [
            ['tahun_ajaran' => '2023/2024', 'semester' => 'ganjil', 'status_tahunAjaran' => 'nonaktif'],
            ['tahun_ajaran' => '2023/2024', 'semester' => 'genap', 'status_tahunAjaran' => 'nonaktif'],
            ['tahun_ajaran' => '2024/2025', 'semester' => 'ganjil', 'status_tahunAjaran' => 'aktif'],
        ];

        foreach ($tahunAjarans as $ta) {
            TahunAjaran::create($ta);
        }
    }
}
