<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peralatan;

class PeralatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_peralatan' => 'Proyektor'],
            ['nama_peralatan' => 'Remot AC'],
            ['nama_peralatan' => 'Kunci Lab'],
        ];

        foreach ($data as $item) {
            Peralatan::create($item);
        }
    }
}
