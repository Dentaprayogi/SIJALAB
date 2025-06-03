<?php

namespace Database\Factories;

use App\Models\JadwalLab;
use App\Models\Hari;
use App\Models\Lab;
use App\Models\Matakuliah;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalLabFactory extends Factory
{
    protected $model = JadwalLab::class;

    public function definition(): array
    {
        // Generate jam mulai dan jam selesai
        $jamMulai = $this->faker->time('H:i:s');
        $jamSelesai = date('H:i:s', strtotime($jamMulai . ' +2 hours'));

        return [
            'id_hari' => Hari::factory(),
            'id_lab' => Lab::factory(),
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'id_mk' => Matakuliah::factory(),
            'id_dosen' => Dosen::factory(),
            'id_prodi' => Prodi::factory(),
            'id_kelas' => Kelas::factory(),
            'id_tahunAjaran' => TahunAjaran::factory(),
            'status_jadwalLab' => $this->faker->randomElement(['aktif', 'nonaktif']),
        ];
    }
}
