<?php

// app/Http/Controllers/SesiJamController.php
namespace App\Http\Controllers;

use App\Models\SesiJam;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SesiJamController extends Controller
{
    public function index()
    {
        $sesiJam = SesiJam::orderBy('id_sesi_jam')->get();
        return view('web.sesi_jam.index', compact('sesiJam'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sesi' => 'required|max:20|unique:sesi_jam,nama_sesi',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ], [
            'nama_sesi.required' => 'Nama sesi wajib diisi.',
            'nama_sesi.max' => 'Nama sesi maksimal 20 karakter.',
            'nama_sesi.unique' => 'Nama sesi sudah digunakan, silakan gunakan nama lain.',

            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid (hh:mm).',

            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid (hh:mm).',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        $namaSesi = ucwords(strtolower($request->nama_sesi));
        $jamMulai = $request->jam_mulai;
        $jamSelesai = $request->jam_selesai;

        // Cek bentrok waktu
        $overlap = SesiJam::where(function ($query) use ($jamMulai, $jamSelesai) {
            $query->where('jam_mulai', '<', $jamSelesai)
                ->where('jam_selesai', '>', $jamMulai);
        })->exists();

        if ($overlap) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Rentang waktu yang dipilih bentrok dengan sesi yang sudah ada.');
        }

        SesiJam::create([
            'nama_sesi' => $namaSesi,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
        ]);

        return redirect()->route('sesi-jam.index')->with('success', 'Sesi jam berhasil ditambahkan.');
    }


    public function update(Request $request, SesiJam $sesi_jam)
    {
        // 1) Validasi dasar + unik (abaikan baris ini sendiri)
        $request->validate([
            'nama_sesi'  => [
                'required',
                'max:20',
                Rule::unique('sesi_jam', 'nama_sesi')
                    ->ignore($sesi_jam->id_sesi_jam, 'id_sesi_jam'),
            ],
            'jam_mulai' => 'required|before:jam_selesai',
            'jam_selesai' => 'required|after:jam_mulai',
        ], [
            'nama_sesi.required' => 'Nama sesi wajib diisi.',
            'nama_sesi.max' => 'Nama sesi maksimal 20 karakter.',
            'nama_sesi.unique' => 'Nama sesi sudah digunakan, silakan gunakan nama lain.',

            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid (hh:mm).',

            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid (hh:mm).',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        // 2) Ubah Title Case manual
        $namaSesi   = ucwords(strtolower($request->nama_sesi));
        $jamMulai   = $request->jam_mulai;
        $jamSelesai = $request->jam_selesai;

        // 3) Cek overlap dengan sesi lain (kecuali dirinya sendiri)
        $overlap = SesiJam::where('id_sesi_jam', '!=', $sesi_jam->id_sesi_jam)
            ->where('jam_mulai', '<', $jamSelesai)   // mulai sebelum jam_selesai baru
            ->where('jam_selesai', '>', $jamMulai)   // selesai sesudah jam_mulai baru
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->with('error', 'Rentang waktu bentrok dengan sesi lain.');
        }

        // 4) Simpan perubahan
        $sesi_jam->update([
            'nama_sesi'  => $namaSesi,
            'jam_mulai'  => $jamMulai,
            'jam_selesai' => $jamSelesai,
        ]);

        return redirect()
            ->route('sesi-jam.index')
            ->with('success', 'Sesi jam berhasil diperbarui.');
    }

    public function destroy(SesiJam $sesi_jam)
    {
        $sesi_jam->delete();
        return redirect()->route('sesi-jam.index')->with('success', 'Sesi jam berhasil dihapus.');
    }
}
