<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeknisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Teknisi 1',
                'email' => 'teknisi1@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'teknisi',
            ],
            [
                'name' => 'Teknisi 2',
                'email' => 'teknisi2@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'teknisi',
            ],
            [
                'name' => 'Teknisi 3',
                'email' => 'teknisi3@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'teknisi',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
