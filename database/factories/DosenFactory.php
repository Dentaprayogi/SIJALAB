<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Database\Eloquent\Factories\Factory;

class DosenFactory extends Factory
{
    protected $model = Dosen::class;

    public function definition(): array
    {
        return [
            'nama_dosen' => $this->faker->name(),
            'telepon' => $this->faker->phoneNumber(),
            'id_prodi' => Prodi::factory(), // Buat prodi baru secara otomatis
        ];
    }
}
