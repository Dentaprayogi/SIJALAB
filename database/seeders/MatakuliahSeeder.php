<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matakuliah;
use App\Models\Prodi;

class MatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        $dataMatakuliah = [
            'Teknologi Rekayasa Perangkat Lunak' => [
                'Pemrograman Dasar',
                'Pemrograman Web',
                'Basis Data',
                'Rekayasa Perangkat Lunak',
                'Struktur Data',
            ],
            'Teknologi Rekayasa Komputer dan jaringan' => [
                'Jaringan Komputer',
                'Keamanan Jaringan',
                'Sistem Operasi',
                'Pemrograman Jaringan',
                'Administrasi Server',
            ],
            'Bisnis Digital' => [
                'Pengantar Bisnis Digital',
                'E-Commerce',
                'Digital Marketing',
                'Manajemen Inovasi',
                'Analisis Data Bisnis',
            ],
        ];

        foreach ($dataMatakuliah as $namaProdi => $matkuls) {
            $prodi = Prodi::where('nama_prodi', $namaProdi)->first();

            if ($prodi) {
                foreach ($matkuls as $mk) {
                    Matakuliah::create([
                        'nama_mk' => $mk,
                        'id_prodi' => $prodi->id_prodi,
                    ]);
                }
            }
        }
    }
}
