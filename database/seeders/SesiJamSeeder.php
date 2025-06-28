<?php

namespace Database\Seeders;

use App\Models\SesiJam;
use Illuminate\Database\Seeder;

class SesiJamSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_sesi' => 'Jam Ke 1', 'jam_mulai' => '07:30', 'jam_selesai' => '08:20'],
            ['nama_sesi' => 'Jam Ke 2', 'jam_mulai' => '08:20', 'jam_selesai' => '09:10'],
            ['nama_sesi' => 'Jam Ke 3', 'jam_mulai' => '09:10', 'jam_selesai' => '10:00'],
            ['nama_sesi' => 'Jam Ke 4', 'jam_mulai' => '10:00', 'jam_selesai' => '10:50'],
            ['nama_sesi' => 'Jam Ke 5', 'jam_mulai' => '10:50', 'jam_selesai' => '11:40'],
            ['nama_sesi' => 'Jam Ke 6', 'jam_mulai' => '12:30', 'jam_selesai' => '13:20'],
            ['nama_sesi' => 'Jam Ke 7', 'jam_mulai' => '13:20', 'jam_selesai' => '14:10'],
            ['nama_sesi' => 'Jam Ke 8', 'jam_mulai' => '14:10', 'jam_selesai' => '15:00'],
            ['nama_sesi' => 'Jam Ke 9', 'jam_mulai' => '15:00', 'jam_selesai' => '15:50'],
            ['nama_sesi' => 'Jam Ke 10', 'jam_mulai' => '15:50', 'jam_selesai' => '16:20'],
        ];

        foreach ($data as $item) {
            SesiJam::create($item);
        }
    }
}
