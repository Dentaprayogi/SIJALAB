<?php

namespace App\Actions\Fortify;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

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
            'nim' => ['required', 'string', 'unique:mahasiswa'],
            'telepon' => ['required', 'string'],
            'id_prodi' => ['required', 'exists:prodi,id_prodi'],
            'id_kelas' => ['required', 'exists:kelas,id_kelas'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'role' => 'mahasiswa', // default role mahasiswa
                'status_user' => 'aktif', // default status user
            ]);
    
            Mahasiswa::create([
                'id' => $user->id,
                'nim' => $input['nim'],
                'telepon' => $input['telepon'],
                'id_prodi' => $input['id_prodi'],
                'id_kelas' => $input['id_kelas'],
                'foto_ktm' => null, // nanti bisa diupdate lewat form edit profil
            ]);
    
            return $user;
        });
    }
    
}
