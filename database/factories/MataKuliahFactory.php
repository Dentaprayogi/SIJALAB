<?php

namespace Database\Factories;

use App\Models\Matakuliah;
use App\Models\Prodi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matakuliah>
 */
class MataKuliahFactory extends Factory
{
    protected $model = Matakuliah::class;

    public function definition(): array
    {
        return [
            'nama_mk' => $this->faker->unique()->words(2, true), // contoh: "Sistem Informasi"
            'id_prodi' => Prodi::factory(), // akan otomatis membuat data Prodi terkait
        ];
    }
}
