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
                ['kode' => 'TRPL101', 'nama' => 'Pemrograman Dasar'],
                ['kode' => 'TRPL102', 'nama' => 'Pemrograman Web'],
                ['kode' => 'TRPL103', 'nama' => 'Basis Data'],
                ['kode' => 'TRPL104', 'nama' => 'Rekayasa Perangkat Lunak'],
                ['kode' => 'TRPL105', 'nama' => 'Struktur Data'],
            ],
            'Teknologi Rekayasa Komputer dan jaringan' => [
                ['kode' => 'TRK201', 'nama' => 'Jaringan Komputer'],
                ['kode' => 'TRK202', 'nama' => 'Keamanan Jaringan'],
                ['kode' => 'TRK203', 'nama' => 'Sistem Operasi'],
                ['kode' => 'TRK204', 'nama' => 'Pemrograman Jaringan'],
                ['kode' => 'TRK205', 'nama' => 'Administrasi Server'],
            ],
            'Bisnis Digital' => [
                ['kode' => 'BD301', 'nama' => 'Pengantar Bisnis Digital'],
                ['kode' => 'BD302', 'nama' => 'E-Commerce'],
                ['kode' => 'BD303', 'nama' => 'Digital Marketing'],
                ['kode' => 'BD304', 'nama' => 'Manajemen Inovasi'],
                ['kode' => 'BD305', 'nama' => 'Analisis Data Bisnis'],
            ],
        ];

        foreach ($dataMatakuliah as $namaProdi => $matkuls) {
            $prodi = Prodi::where('nama_prodi', $namaProdi)->first();

            if ($prodi) {
                foreach ($matkuls as $mk) {
                    Matakuliah::create([
                        'nama_mk'  => $mk['nama'],
                        'kode_mk'  => $mk['kode'],
                        'id_prodi' => $prodi->id_prodi,
                    ]);
                }
            }
        }
    }
}
