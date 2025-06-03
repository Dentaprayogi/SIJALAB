<?php

namespace Database\Factories;

use App\Models\PeminjamanJadwal;
use App\Models\Peminjaman;
use App\Models\JadwalLab;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanJadwalFactory extends Factory
{
    protected $model = PeminjamanJadwal::class;

    public function definition(): array
    {
        return [
            'id_peminjaman' => Peminjaman::factory(),
            'id_jadwalLab' => JadwalLab::factory(),
        ];
    }
}
