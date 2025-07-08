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
                ['kode' => 'TRPL101', 'nama' => 'Praktikum Pemrograman Web Dasar'],
                ['kode' => 'TRPL102', 'nama' => 'Praktikum Desain Pengalaman Pengguna'],
                ['kode' => 'TRPL103', 'nama' => 'Praktikum Basis Data'],
                ['kode' => 'TRPL104', 'nama' => 'Praktikum Algoritma & Struktur Data'],
                ['kode' => 'TRPL105', 'nama' => 'Proyek Aplikasi Dasar'],
                ['kode' => 'TRPL106', 'nama' => 'Praktikum Sistem Terdistribusi'],
                ['kode' => 'TRPL107', 'nama' => 'Praktikum Machine Learning'],
                ['kode' => 'TRPL108', 'nama' => 'Praktikum Struktur Data'],
                ['kode' => 'TRPL109', 'nama' => 'Aljabar Vektor dan Matrik'],
                ['kode' => 'TRPL110', 'nama' => 'Manajemen Proyek'],
                ['kode' => 'TRPL111', 'nama' => 'Praktikum Pemrograman Berorientasi Objek'],
                ['kode' => 'TRPL112', 'nama' => 'Analisis & desain Perangkat Lunak'],
            ],
            'Teknologi Rekayasa Komputer dan jaringan' => [
                ['kode' => 'TRK201', 'nama' => 'Praktikum Mikro Komputer'],
                ['kode' => 'TRK202', 'nama' => 'Praktikum Jaringan Komputer Dasar'],
                ['kode' => 'TRK203', 'nama' => 'Praktikum Pengelolahan Sinyal & Citra Digital'],
                ['kode' => 'TRK204', 'nama' => 'Teknologi Nirkabel'],
                ['kode' => 'TRK205', 'nama' => 'Praktikum Rangkaian Elektronikal Digital'],
                ['kode' => 'TRK206', 'nama' => 'Praktikum Pemrograman Perangkat Bergerak'],
                ['kode' => 'TRK207', 'nama' => 'Praktikum Basis Data'],
                ['kode' => 'TRK208', 'nama' => 'Keamanan, Kesehatan, dan Keselamatan Kerja'],
            ],
            'Bisnis Digital' => [
                ['kode' => 'BD301', 'nama' => 'Praktikum Basis Data'],
                ['kode' => 'BD302', 'nama' => 'Studi Kelayakan'],
                ['kode' => 'BD303', 'nama' => 'Praktikum Desain & Analisis Sistem Informasi'],
                ['kode' => 'BD304', 'nama' => 'Praktikum Pemrograman Web Dasar'],
                ['kode' => 'BD305', 'nama' => 'Analisis Data Bisnis'],
                ['kode' => 'BD306', 'nama' => 'Praktikum Pemrograman Web Dasar'],
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
