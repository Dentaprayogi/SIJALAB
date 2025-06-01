<?php

namespace Database\Factories;

use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class TahunAjaranFactory extends Factory
{
    protected $model = TahunAjaran::class;

    public function definition(): array
    {
        return [
            'tahun_ajaran' => $this->faker->year . '/' . ($this->faker->year + 1),
            'semester' => $this->faker->randomElement(['ganjil', 'genap']),
            'status_tahunAjaran' => 'aktif',
        ];
    }
}
