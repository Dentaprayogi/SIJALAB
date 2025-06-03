<?php

namespace Database\Factories;

use App\Models\PeminjamanDitolak;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanDitolakFactory extends Factory
{
    protected $model = PeminjamanDitolak::class;

    public function definition(): array
    {
        return [
            'id_peminjaman' => Peminjaman::factory(),
            'alasan_ditolak' => $this->faker->randomElement([
                'Jadwal laboratorium bentrok',
                'Laboratorium tidak tersedia',
                'Dokumen peminjaman tidak lengkap',
                'Peralatan tidak tersedia',
                'Permintaan tidak sesuai prosedur',
            ]),
        ];
    }
}
