<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    public function definition(): array
    {
        return [
            'id' => User::factory(), // relasi ke users.id
            'id_prodi' => Prodi::factory(), // relasi ke prodi
            'id_kelas' => Kelas::factory(), // relasi ke kelas
            'nim' => $this->faker->unique()->numerify('2023####'),
            'telepon' => $this->faker->phoneNumber(),
            'foto_ktm' => 'uploads/ktm/' . $this->faker->uuid . '.jpg', // hanya path sesuai struktur penyimpanan
        ];
    }
}
