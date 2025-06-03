<?php

namespace Database\Factories;

use App\Models\PeminjamanSelesai;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanSelesaiFactory extends Factory
{
    protected $model = PeminjamanSelesai::class;

    public function definition(): array
    {
        return [
            'id_peminjaman' => Peminjaman::factory(),
            'tgl_pengembalian' => $this->faker->date(),
            'jam_dikembalikan' => $this->faker->time('H:i:s'),
        ];
    }
}
