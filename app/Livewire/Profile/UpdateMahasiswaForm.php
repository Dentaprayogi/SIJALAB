<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Kelas;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class UpdateMahasiswaForm extends Component
{
    use WithFileUploads;

    public $nim;
    public $telepon;
    public $id_prodi;
    public $id_kelas;
    public $foto_ktm;
    public $foto_ktm_preview;

    public $prodiList = [];
    public $kelasList = [];

    public $disableNim = false;
    public $disableProdi = false;
    public $canEditKelas = false;

    public function updatedIdProdi($value)
    {
        $this->kelasList = Kelas::where('id_prodi', $value)->get();
        $this->id_kelas = null; // reset pilihan kelas agar user disuruh pilih lagi
    }

    public function resetKelas()
    {
        $this->id_kelas = null;
    }


    public function mount()
    {
        $user = Auth::user();

        // Set default: mahasiswa tidak bisa edit NIM & Prodi
        if ($user->role === 'mahasiswa') {
            $this->disableNim = true;
            $this->disableProdi = true;

            // Cek apakah mahasiswa punya hak akses ubah kelas
            $this->canEditKelas = $user->akses_ubah_kelas;
        }

        $mahasiswa = Mahasiswa::where('id', $user->id)->first();
        $this->prodiList = Prodi::all();

        if ($mahasiswa) {
            $this->nim = $mahasiswa->nim;
            $this->telepon = $mahasiswa->telepon;
            $this->id_prodi = $mahasiswa->id_prodi;
            $this->id_kelas = $mahasiswa->id_kelas;
            $this->foto_ktm_preview = $mahasiswa->foto_ktm;

            $this->kelasList = Kelas::where('id_prodi', $mahasiswa->id_prodi)->get();
        } else {
            $this->kelasList = collect();
        }
    }

    public function updateMahasiswa()
    {
        $user = Auth::user();

        // Ambil mahasiswa yang sedang login
        $mahasiswa = Mahasiswa::where('id', $user->id)->first();

        $rules = [
            'telepon' => 'required|string|max:20',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'foto_ktm' => 'nullable|image|max:5120',
        ];

        // Tetapkan NIM dan Prodi dari data lama jika mahasiswa
        if ($user->role === 'mahasiswa') {
            $this->nim = $mahasiswa->nim;
            $this->id_prodi = $mahasiswa->id_prodi;

            // Jika tidak punya akses ubah kelas, pakai data lama
            if (!$user->akses_ubah_kelas) {
                $this->id_kelas = $mahasiswa->id_kelas;
            }
        }

        $this->validate($rules);

        // Tetapkan NIM dan Prodi dari data lama jika mahasiswa
        if ($user->role === 'mahasiswa') {
            $this->nim = $mahasiswa->nim;
            $this->id_prodi = $mahasiswa->id_prodi;
        }

        if ($this->foto_ktm) {
            if ($mahasiswa && $mahasiswa->foto_ktm) {
                Storage::disk('public')->delete($mahasiswa->foto_ktm);
            }
            $path = $this->foto_ktm->store('uploads/ktm', 'public');
        } else {
            $path = $mahasiswa->foto_ktm ?? null;
        }

        $mahasiswa->update([
            'nim' => $this->nim,
            'telepon' => $this->telepon,
            'id_prodi' => $this->id_prodi,
            'id_kelas' => $this->id_kelas,
            'foto_ktm' => $path,
        ]);

        $mahasiswa->save();

        $this->dispatch('saved');
        session()->flash('message', 'Data mahasiswa berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.profile.update-mahasiswa-form');
    }
}
