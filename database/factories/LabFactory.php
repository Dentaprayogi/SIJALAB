<?php

namespace Database\Factories;

use App\Models\Lab;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabFactory extends Factory
{
    protected $model = Lab::class;

    public function definition(): array
    {
        return [
            'nama_lab' => $this->faker->unique()->word(),
            'status_lab' => $this->faker->randomElement(['aktif', 'nonaktif']),
        ];
    }
}
