<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Support\Str;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil satu prodi dan satu kelas pertama yang ditemukan
        $prodi = Prodi::first();
        $kelas = Kelas::where('id_prodi', $prodi->id_prodi)->first();

        // Cek jika data tersedia
        if (!$prodi || !$kelas) {
            $this->command->error('Prodi atau Kelas tidak ditemukan. Seeder Mahasiswa dibatalkan.');
            return;
        }

        // Generate NIM (harus dilakukan sebelum create user karena dipakai di username)
        $nim = '36' . str_pad(rand(1, 9999999999), 10, '0', STR_PAD_LEFT); // 12 digit

        // Buat user baru
        $user = User::create([
            'name'     => 'MahasiswaTesting ' . $prodi->nama_prodi . ' ' . $kelas->nama_kelas,
            'username' => $nim, // username diisi dengan nim
            'email'    => 'mhs_' . strtolower(Str::slug($prodi->singkatan_prodi . '_' . $kelas->nama_kelas)) . '_' . Str::random(5) . '@example.com',
            'password' => bcrypt('password'),
            'role'     => 'mahasiswa',
        ]);

        // Buat data mahasiswa
        Mahasiswa::create([
            'id'        => $user->id,
            'id_prodi'  => $prodi->id_prodi,
            'id_kelas'  => $kelas->id_kelas,
            'nim'       => $nim,
            'telepon'   => '0812' . rand(10000000, 99999999),
            'foto_ktm'  => null,
        ]);
    }
}
