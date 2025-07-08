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
                'nama_lab' => 'Pemrograman 1',
                'status_lab' => 'aktif',
            ],
            [
                'nama_lab' => 'Pemrograman 2',
                'status_lab' => 'aktif',
            ],
            [
                'nama_lab' => 'Basis Data',
                'status_lab' => 'aktif',
            ],
            [
                'nama_lab' => 'Hardware',
                'status_lab' => 'aktif',
            ],
            [
                'nama_lab' => 'Multimedia',
                'status_lab' => 'aktif',
            ],
            [
                'nama_lab' => 'Coworking',
                'status_lab' => 'aktif',
            ],
            [
                'nama_lab' => 'Design',
                'status_lab' => 'aktif',
            ],
            [
                'nama_lab' => 'TUK',
                'status_lab' => 'aktif',
            ],
        ];

        foreach ($dataLab as $lab) {
            Lab::create([
                'nama_lab' => $lab['nama_lab'],
                'status_lab' => $lab['status_lab'],
            ]);
        }
    }
}
