<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HariFactory extends Factory
{
    public function definition(): array
    {
        // Pilih hari yang belum pernah dipakai
        static $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Ambil nilai pertama dari array dan hilangkan dari daftar agar tidak duplikat
        $namaHari = array_shift($hariList) ?? $this->faker->unique()->word;

        return [
            'nama_hari' => $namaHari,
        ];
    }
}
