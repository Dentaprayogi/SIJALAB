<?php

namespace Database\Factories;

use App\Models\PeminjamanManual;
use App\Models\Peminjaman;
use App\Models\Lab;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanManualFactory extends Factory
{
    protected $model = PeminjamanManual::class;

    public function definition(): array
    {
        $jamMulai = $this->faker->time('H:i:s');
        $jamSelesai = $this->faker->time('H:i:s');

        return [
            'id_peminjaman' => Peminjaman::factory(),
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'id_lab' => Lab::factory(),
            'kegiatan' => $this->faker->sentence(3),
        ];
    }
}
