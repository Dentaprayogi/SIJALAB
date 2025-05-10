<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliah = Matakuliah::with('prodi')
            ->orderBy('nama_mk', 'asc') // urutkan berdasarkan nama_mk A-Z
            ->get();

        $prodi = Prodi::all(); // ambil semua prodi untuk form

        return view('web.matakuliah.index', compact('matakuliah', 'prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'nama_mk' => 'required|string|max:255',
        ]);

        // Cek apakah matakuliah dengan nama yang sama sudah ada dalam prodi yang dipilih
        $cekMatakuliah = Matakuliah::where('id_prodi', $request->id_prodi)
            ->where('nama_mk', $request->nama_mk)
            ->exists();

        if ($cekMatakuliah) {
            return redirect()->route('matakuliah.index')->with('error', 'Matakuliah dengan nama yang sama sudah ada dalam prodi ini!');
        }

        Matakuliah::create([
            'id_prodi' => $request->id_prodi,
            'nama_mk' => $request->nama_mk,
        ]);

        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil ditambahkan!');
    }

    public function update(Request $request, $id_mk)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'nama_mk' => 'required|string|max:255',
        ]);

        // Ambil data matakuliah berdasarkan ID
        $mk = Matakuliah::findOrFail($id_mk);

        // Cek apakah sudah ada matkul dengan nama dan prodi yang sama, tapi bukan diri sendiri
        $cekMatakuliah = Matakuliah::where('id_prodi', $request->id_prodi)
            ->where('nama_mk', $request->nama_mk)
            ->where('id_mk', '!=', $mk->id_mk)
            ->exists();

        if ($cekMatakuliah) {
            return redirect()->route('matakuliah.index')->withInput()->with('error', 'Mata Kuliah yang sama sudah ada dalam prodi ini!');
        }

        // Update data
        $mk->update([
            'id_prodi' => $request->id_prodi,
            'nama_mk' => $request->nama_mk,
        ]);

        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah berhasil diperbarui!');
    }


    public function destroy($id_mk)
    {
        $matakuliah = Matakuliah::findOrFail($id_mk);

        $hasJadwalLab = $matakuliah->jadwalLab()->exists();

        if ($hasJadwalLab) {
            return redirect()->route('matakuliah.index')
                ->with('error', 'Mata Kuliah tidak dapat dihapus karena masih memiliki jadwal lab yang terkait.');
        }

        $matakuliah->delete();

        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah berhasil dihapus!');
    }
}
