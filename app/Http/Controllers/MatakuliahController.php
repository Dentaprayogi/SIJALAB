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
            'nama_mk'  => 'required|string|max:255',
            'kode_mk'  => 'required|string|max:50',
        ]);

        // Ubah nama matakuliah menjadi Title Case
        $nama_mk = ucwords(strtolower($request->nama_mk));
        $kode_mk = strtoupper($request->kode_mk);

        // Cek duplikat nama dalam prodi yang sama
        $cekNama = Matakuliah::where('id_prodi', $request->id_prodi)
            ->where('nama_mk', $nama_mk)
            ->exists();

        if ($cekNama) {
            return redirect()->route('matakuliah.index')
                ->withInput()
                ->with('error', 'Mata kuliah dengan nama tersebut sudah ada dalam prodi ini!');
        }

        // Cek duplikat kode MK
        $cekKode = Matakuliah::where('kode_mk', $kode_mk)->exists();

        if ($cekKode) {
            return redirect()->route('matakuliah.index')
                ->withInput()
                ->with('error', 'Kode mata kuliah sudah digunakan!');
        }

        // Simpan data
        Matakuliah::create([
            'id_prodi' => $request->id_prodi,
            'nama_mk'  => $nama_mk,
            'kode_mk'  => $kode_mk,
        ]);

        return redirect()->route('matakuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    public function update(Request $request, $id_mk)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'nama_mk'  => 'required|string|max:255',
            'kode_mk'  => 'required|string|max:50',
        ]);

        $mk = Matakuliah::findOrFail($id_mk);

        // Format nilai input
        $nama_mk = ucwords(strtolower($request->nama_mk)); // Title Case
        $kode_mk = strtoupper($request->kode_mk);          // UPPERCASE

        // Cek apakah ada matkul dengan nama sama di prodi yg sama, kecuali dirinya sendiri
        $cekNama = Matakuliah::where('id_prodi', $request->id_prodi)
            ->where('nama_mk', $nama_mk)
            ->where('id_mk', '!=', $mk->id_mk)
            ->exists();

        if ($cekNama) {
            return redirect()->route('matakuliah.index')
                ->withInput()
                ->with('error', 'Mata kuliah dengan nama tersebut sudah ada dalam prodi ini!');
        }

        // Cek apakah kode mk sudah digunakan oleh matkul lain
        $cekKode = Matakuliah::where('kode_mk', $kode_mk)
            ->where('id_mk', '!=', $mk->id_mk)
            ->exists();

        if ($cekKode) {
            return redirect()->route('matakuliah.index')
                ->withInput()
                ->with('error', 'Kode mata kuliah sudah digunakan!');
        }

        // Update data
        $mk->update([
            'id_prodi' => $request->id_prodi,
            'nama_mk'  => $nama_mk,
            'kode_mk'  => $kode_mk,
        ]);

        return redirect()->route('matakuliah.index')
            ->with('success', 'Mata kuliah berhasil diperbarui!');
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
