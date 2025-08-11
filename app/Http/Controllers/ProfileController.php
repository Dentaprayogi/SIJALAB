<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil.
     */
    public function index()
    {
        $user = Auth::user();

        $mahasiswa = null;
        $prodiList = [];
        $kelasList = [];
        $canEditKelas = false;

        if ($user->role === 'mahasiswa') {
            $mahasiswa = Mahasiswa::where('id', $user->id)->first();

            $prodiList = \App\Models\Prodi::all();

            // Ambil hanya kelas yang sesuai dengan id_prodi mahasiswa
            if ($mahasiswa) {
                $kelasList = \App\Models\Kelas::where('id_prodi', $mahasiswa->id_prodi)->get();
            }

            $canEditKelas = $user->akses_ubah_kelas;
        }

        return view('web.profile.index', compact('mahasiswa', 'prodiList', 'kelasList', 'canEditKelas'));
    }

    public function update(Request $request)
    {
        $user = \App\Models\User::findOrFail(Auth::id());

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($user->role !== 'mahasiswa') {
            $user->username = $validated['username'];
        }

        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                Storage::delete($user->profile_photo_path);
            }

            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // Method untuk cpanel
    // public function updateMahasiswa(Request $request)
    // {
    //     $user = Auth::user();

    //     $mahasiswa = Mahasiswa::where('id', $user->id)->firstOrFail();

    //     $validated = $request->validate([
    //         'telepon' => ['nullable', 'string', 'max:15'],
    //         'id_kelas' => ['nullable', 'exists:kelas,id_kelas'],
    //         'foto_ktm' => ['nullable', 'image', 'max:2048'],
    //     ]);

    //     $mahasiswa->telepon = $validated['telepon'] ?? $mahasiswa->telepon;
    //     $mahasiswa->id_kelas = $validated['id_kelas'] ?? $mahasiswa->id_kelas;

    //     if ($request->hasFile('foto_ktm')) {
    //         // Hapus foto lama jika ada
    //         if (
    //             $mahasiswa->foto_ktm &&
    //             File::exists(base_path('../public_html/' . $mahasiswa->foto_ktm))
    //         ) {
    //             File::delete(base_path('../public_html/' . $mahasiswa->foto_ktm));
    //         }

    //         $image = $request->file('foto_ktm');
    //         $imageName = 'ktm_' . $user->username . '_' . time() . '.' . $image->getClientOriginalExtension();
    //         $destinationPath = base_path('../public_html/uploads/ktm'); // langsung ke public_html/uploads/ktm

    //         // Pastikan folder tujuan ada
    //         if (!File::exists($destinationPath)) {
    //             File::makeDirectory($destinationPath, 0755, true);
    //         }

    //         // Simpan file ke direktori public_html/uploads/ktm
    //         $image->move($destinationPath, $imageName);

    //         // Simpan path relatif ke database
    //         $mahasiswa->foto_ktm = 'uploads/ktm/' . $imageName;
    //     }

    //     $mahasiswa->save();

    //     return redirect()->back()->with('success', 'Data mahasiswa berhasil diperbarui.');
    // }

    public function updateMahasiswa(Request $request)
    {
        $user = Auth::user();

        $mahasiswa = Mahasiswa::where('id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'telepon' => ['nullable', 'string', 'max:15'],
            'id_kelas' => ['nullable', 'exists:kelas,id_kelas'],
            'foto_ktm' => ['nullable', 'image', 'max:2048'],
        ]);

        $mahasiswa->telepon = $validated['telepon'] ?? $mahasiswa->telepon;
        $mahasiswa->id_kelas = $validated['id_kelas'] ?? $mahasiswa->id_kelas;

        if ($request->hasFile('foto_ktm')) {
            // Hapus foto lama jika ada
            if ($mahasiswa->foto_ktm && File::exists(public_path($mahasiswa->foto_ktm))) {
                File::delete(public_path($mahasiswa->foto_ktm));
            }

            $image = $request->file('foto_ktm');
            $imageName = 'ktm_' . $user->username . '_' . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/ktm');

            // Pastikan folder tujuan ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Simpan file ke direktori public/uploads/ktm
            $image->move($destinationPath, $imageName);

            // Simpan path relatif ke database
            $mahasiswa->foto_ktm = 'uploads/ktm/' . $imageName;
        }

        $mahasiswa->save();

        return redirect()->back()->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = \App\Models\User::findOrFail(Auth::id());

        // Periksa apakah password lama valid
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required'],
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
        ]);

        // Jika gagal validasi
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Terjadi kesalahan saat mengubah password.');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
