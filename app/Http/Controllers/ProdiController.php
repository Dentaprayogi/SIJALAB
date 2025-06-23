<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodi = Prodi::orderBy('nama_prodi', 'asc')->get();
        return view('web.prodi.index', compact('prodi'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_prodi'      => 'required|string|max:255|unique:prodi,nama_prodi',
            'kode_prodi'      => 'required|string|max:255|unique:prodi,kode_prodi',
            'singkatan_prodi' => 'required|string|max:10|unique:prodi,singkatan_prodi',
        ], [
            'nama_prodi.unique'      => 'Nama prodi sudah ada, silakan gunakan nama lain.',
            'kode_prodi.unique'      => 'Kode prodi sudah ada, silakan gunakan kode lain.',
            'singkatan_prodi.unique' => 'Singkatan prodi sudah ada, silakan gunakan singkatan lain.',
        ]);

        // Format input sesuai kebutuhan
        $validated['nama_prodi']      = ucwords(strtolower($validated['nama_prodi']));
        $validated['kode_prodi']      = strtoupper($validated['kode_prodi']);
        $validated['singkatan_prodi'] = strtoupper($validated['singkatan_prodi']);

        // Simpan ke database
        Prodi::create($validated);

        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $prodi = Prodi::findOrFail($id);

        // Validasi data
        $validated = $request->validate([
            'nama_prodi'      => 'required|string|max:255|unique:prodi,nama_prodi,' . $id . ',id_prodi',
            'kode_prodi'      => 'required|string|max:255|unique:prodi,kode_prodi,' . $id . ',id_prodi',
            'singkatan_prodi' => 'required|string|max:10|unique:prodi,singkatan_prodi,' . $id . ',id_prodi',
        ], [
            'nama_prodi.unique'      => 'Nama prodi sudah ada, silakan gunakan nama lain.',
            'kode_prodi.unique'      => 'Kode prodi sudah ada, silakan gunakan kode lain.',
            'singkatan_prodi.unique' => 'Singkatan prodi sudah ada, silakan gunakan singkatan lain.',
        ]);

        // Format input
        $validated['nama_prodi']      = ucwords(strtolower($validated['nama_prodi']));
        $validated['kode_prodi']      = strtoupper($validated['kode_prodi']);
        $validated['singkatan_prodi'] = strtoupper($validated['singkatan_prodi']);

        // Update data
        $prodi->update($validated);

        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);

        $hasKelas = $prodi->kelas()->exists();
        $hasMahasiswa = $prodi->mahasiswa()->exists();
        $hasDosen = $prodi->dosen()->exists();
        $hasJadwalLab = $prodi->jadwalLab()->exists();

        if ($hasKelas || $hasMahasiswa || $hasDosen || $hasJadwalLab) {
            return redirect()->route('prodi.index')->with('error', 'Prodi tidak dapat dihapus karena masih terhubung dengan data lain.');
        }

        $prodi->delete();

        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil dihapus.');
    }
}
