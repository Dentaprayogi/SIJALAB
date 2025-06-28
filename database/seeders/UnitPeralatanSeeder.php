<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peralatan;
use App\Models\UnitPeralatan;

class UnitPeralatanSeeder extends Seeder
{
    /**
     * Daftar kode unit yang ingin dimasukkan.
     */
    private array $kodeUnitProyektor = [
        'PJ201',
        'PJ202',
        'PJ203',
        'PJ204',
        'PJ205',
    ];

    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Pastikan peralatan "Proyektor" tersedia
        $proyektor = Peralatan::firstOrCreate(
            ['nama_peralatan' => 'Proyektor']
        );

        // Tambahkan unit berdasarkan kode yang sudah ditentukan
        foreach ($this->kodeUnitProyektor as $kode) {
            UnitPeralatan::firstOrCreate(
                ['kode_unit' => $kode],
                [
                    'id_peralatan' => $proyektor->id_peralatan,
                    'status_unit' => 'tersedia',
                ]
            );
        }
    }
}
