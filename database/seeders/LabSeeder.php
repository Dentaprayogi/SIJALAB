<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lab;

class LabSeeder extends Seeder
{
    public function run(): void
    {
        $dataLab = [
            [
                'nama_lab' => 'Pemrograman',
                'fasilitas_lab' => 'Komputer dengan software pemrograman terbaru, proyektor, dan kursi nyaman.',
                'kapasitas_lab' => 30,
                'status_lab' => 'aktif',
            ],
            [
                'nama_lab' => 'Jaringan',
                'fasilitas_lab' => 'Router, switch, kabel jaringan, dan perangkat jaringan lainnya.',
                'kapasitas_lab' => 25,
                'status_lab' => 'aktif',
            ],
            [
                'nama_lab' => 'Sistem Operasi',
                'fasilitas_lab' => 'Komputer dengan berbagai sistem operasi, proyektor, dan meja kerja.',
                'kapasitas_lab' => 20,
                'status_lab' => 'aktif',
            ],
            [
                'nama_lab' => 'Keamanan Jaringan',
                'fasilitas_lab' => 'Perangkat keamanan jaringan dan alat-alat praktikum keamanan siber.',
                'kapasitas_lab' => 15,
                'status_lab' => 'aktif',
            ],
            [
                'nama_lab' => 'Bisnis Digital',
                'fasilitas_lab' => 'Komputer dengan software analisis bisnis dan akses internet cepat.',
                'kapasitas_lab' => 30,
                'status_lab' => 'aktif',
            ],
        ];

        foreach ($dataLab as $lab) {
            Lab::create([
                'nama_lab' => $lab['nama_lab'],
                'fasilitas_lab' => $lab['fasilitas_lab'],
                'kapasitas_lab' => $lab['kapasitas_lab'],
                'status_lab' => $lab['status_lab'],
            ]);
        }
    }
}
