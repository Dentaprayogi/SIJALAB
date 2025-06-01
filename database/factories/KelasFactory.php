<?php

namespace Database\Factories;

use App\Models\Prodi;
use Illuminate\Database\Eloquent\Factories\Factory;


class KelasFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_prodi' => Prodi::factory(), // Relasi ke Prodi
            'nama_kelas' => $this->faker->word,
        ];
    }
}
