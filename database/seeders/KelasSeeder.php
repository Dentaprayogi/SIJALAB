<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Prodi;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $huruf = ['A', 'B', 'C', 'D', 'E'];

        $prodis = Prodi::all();

        foreach ($prodis as $prodi) {
            // Angkatan 1 sampai 4
            for ($tingkat = 1; $tingkat <= 4; $tingkat++) {
                foreach ($huruf as $hurufKelas) {
                    Kelas::create([
                        'id_prodi' => $prodi->id_prodi,
                        'nama_kelas' => "{$tingkat}{$hurufKelas}",
                    ]);
                }
            }
        }
    }
}
