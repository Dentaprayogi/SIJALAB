<?php

namespace App\Actions\Fortify;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'nim' => ['required', 'string', 'regex:/^36[0-9]{10}$/', 'unique:mahasiswa'],
            'telepon' => ['required', 'string'],
            'id_prodi' => ['required', 'exists:prodi,id_prodi'],
            'id_kelas' => ['required', 'exists:kelas,id_kelas'],
            // 'foto_ktm' => ['required', 'image', 'max:5120'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], [
            'nim.regex' => 'NIM tidak valid.',
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'username' => $input['nim'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'role' => 'mahasiswa',
                'status_user' => 'aktif',
            ]);

            $foto = request()->file('foto_ktm');
            $namaFile = 'ktm_' . Str::slug($input['nim']) . '_' . time() . '.' . $foto->getClientOriginalExtension();
            $tujuanPath = public_path('uploads/ktm');

            //$tujuanPath = base_path('../public_html/uploads/ktm'); // langsung ke public_html/uploads/ktm

            // Buat folder jika belum ada
            if (!file_exists($tujuanPath)) {
                mkdir($tujuanPath, 0755, true);
            }

            $foto->move($tujuanPath, $namaFile);

            Mahasiswa::create([
                'id' => $user->id,
                'nim' => $input['nim'],
                'telepon' => $input['telepon'],
                'id_prodi' => $input['id_prodi'],
                'id_kelas' => $input['id_kelas'],
                'foto_ktm' => 'uploads/ktm/' . $namaFile, // Simpan path relatif
            ]);

            return $user;
        });
    }
}
