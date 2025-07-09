<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TeknisiSeeder::class,
            TahunAjaranSeeder::class,
            PeralatanSeeder::class,
            UnitPeralatanSeeder::class,
            ProdiSeeder::class,
            KelasSeeder::class,
            MatakuliahSeeder::class,
            DosenSeeder::class,
            LabSeeder::class,
            HariSeeder::class,
            SesiJamSeeder::class,
            MahasiswaSeeder::class,
        ]);
    }
}
