<?php

namespace Database\Factories;

use App\Models\UnitPeralatan;
use App\Models\Peralatan;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitPeralatanFactory extends Factory
{
    protected $model = UnitPeralatan::class;

    public function definition()
    {
        return [
            'id_peralatan' => Peralatan::factory(),

            'kode_unit' => $this->faker->unique()->bothify('UNIT-###'),

            'status_unit' => $this->faker->randomElement(['tersedia', 'dipinjam', 'rusak']),
        ];
    }
}
