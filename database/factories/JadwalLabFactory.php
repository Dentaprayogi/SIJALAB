<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Lab;
use App\Models\Matakuliah;
use App\Models\Prodi;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalLabFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_lab' => Lab::factory(),
            //  jam mulai
            // jam selesai
            'id_mk' => Matakuliah::factory(),
            'id_dosen' => Dosen::factory(),
            'id_prodi' => Prodi::factory(),
            'id_kelas' => Kelas::factory(),
            'id_tahunAjaran' => TahunAjaran::factory(),
            'status_jadwalLab' => 'aktif',
        ];
    }
}
