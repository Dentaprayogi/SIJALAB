<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PeminjamanFactory extends Factory
{
    protected $model = Peminjaman::class;

    public function definition(): array
    {
        return [
            'tgl_peminjaman' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'id' => User::factory(), // otomatis buat user baru jika belum disediakan
            'status_peminjaman' => $this->faker->randomElement(['pengajuan', 'ditolak', 'dipinjam', 'selesai', 'bermasalah']),
        ];
    }
}
