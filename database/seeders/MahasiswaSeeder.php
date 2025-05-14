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
        $allProdi = Prodi::all();
        $counter = 1; // Untuk membuat NIM unik

        foreach ($allProdi as $prodi) {
            // Ambil kelas-kelas milik prodi ini saja
            $kelasProdi = Kelas::where('id_prodi', $prodi->id_prodi)->get();

            foreach ($kelasProdi as $kelas) {
                for ($i = 1; $i <= 3; $i++) {
                    // Buat user baru
                    $user = User::create([
                        'name' => 'Mahasiswa ' . $prodi->nama_prodi . ' ' . $kelas->nama_kelas . ' - ' . $i,
                        'email' => 'mhs_' . strtolower(Str::slug($prodi->kode_prodi . $kelas->nama_kelas . $i)) . '@example.com',
                        'password' => bcrypt('password'),
                        'role' => 'mahasiswa',
                    ]);

                    // Buat data mahasiswa
                    Mahasiswa::create([
                        'id' => $user->id,
                        'id_prodi' => $prodi->id_prodi,
                        'id_kelas' => $kelas->id_kelas,
                        'nim' => '36' . str_pad($counter++, 10, '0', STR_PAD_LEFT), // total 12 digit, diawali 36
                        'telepon' => '0812' . rand(10000000, 99999999),
                        'foto_ktm' => null,
                    ]);
                }
            }
        }
    }
}
