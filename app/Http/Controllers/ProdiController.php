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
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodi,nama_prodi',
            'singkatan_prodi' => 'required|string|max:10|unique:prodi,singkatan_prodi',
        ], [
            'nama_prodi.unique' => 'Nama prodi sudah ada, silakan gunakan nama lain.',
            'singkatan_prodi.unique' => 'singkatan prodi sudah ada, silakan gunakan singkatan lain.',
        ]);

        Prodi::create($request->all());
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $prodi = Prodi::findOrFail($id);
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodi,nama_prodi,' . $id . ',id_prodi',
            'singkatan_prodi' => 'required|string|max:10|unique:prodi,singkatan_prodi,' . $id . ',id_prodi',
        ], [
            'nama_prodi.unique' => 'Nama prodi sudah ada, silakan gunakan nama lain.',
            'singkatan_prodi.unique' => 'singkatan prodi sudah ada, silakan gunakan singkatan lain.',
        ]);

        $prodi = Prodi::findOrFail($id);
        $prodi->update($request->all());
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
