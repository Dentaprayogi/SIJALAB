<?php

namespace Database\Factories;

use App\Models\Peralatan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeralatanFactory extends Factory
{
    protected $model = Peralatan::class;

    public function definition(): array
    {
        return [
            'nama_peralatan' => $this->faker->unique()->word(),
        ];
    }
}
