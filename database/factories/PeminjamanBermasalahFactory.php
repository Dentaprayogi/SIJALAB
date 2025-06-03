<?php

namespace Database\Factories;

use App\Models\PeminjamanBermasalah;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanBermasalahFactory extends Factory
{
    protected $model = PeminjamanBermasalah::class;

    public function definition(): array
    {
        return [
            'id_peminjaman' => Peminjaman::factory(), // Akan membuat peminjaman jika belum ada
            'tgl_pengembalian' => $this->faker->date('Y-m-d'),
            'jam_dikembalikan' => $this->faker->time('H:i:s'),
            'alasan_bermasalah' => $this->faker->randomElement([
                'Peralatan rusak saat dikembalikan',
                'Keterlambatan pengembalian',
                'Unit hilang',
                'Kondisi tidak sesuai',
            ]),
        ];
    }
}
