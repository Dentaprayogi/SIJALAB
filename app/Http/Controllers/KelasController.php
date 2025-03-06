<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Prodi;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::join('prodi', 'kelas.id_prodi', '=', 'prodi.id_prodi')
            ->orderBy('prodi.kode_prodi', 'asc') // Urut berdasarkan kode_prodi
            ->orderBy('kelas.nama_kelas', 'asc') // Urut berdasarkan nama_kelas
            ->select('kelas.*') // Pastikan hanya mengambil kolom dari kelas
            ->with('prodi') // Pastikan relasi tetap dipanggil
            ->get();
    
        $prodi = Prodi::all();
        return view('web.kelas.index', compact('kelas', 'prodi'));
    }    

    public function store(Request $request)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'nama_kelas' => 'required|string|max:255',
        ]);

        // Cek apakah kelas dengan nama yang sama sudah ada dalam prodi yang dipilih
        $cekKelas = Kelas::where('id_prodi', $request->id_prodi)
                        ->where('nama_kelas', $request->nama_kelas)
                        ->exists();

        if ($cekKelas) {
            return redirect()->route('kelas.index')->with('error', 'Kelas dengan nama yang sama sudah ada dalam prodi ini!');
        }

        Kelas::create($request->all());
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'nama_kelas' => 'required|string|max:255',
        ]);

        // Cek apakah ada kelas lain dengan nama yang sama dalam prodi yang sama
        $cekKelas = Kelas::where('id_prodi', $request->id_prodi)
                        ->where('nama_kelas', $request->nama_kelas)
                        ->where('id_kelas', '!=', $kela->id_kelas) // Pastikan bukan kelas yang sedang diedit
                        ->exists();

        if ($cekKelas) {
            return redirect()->route('kelas.index')->withInput()->with('error', 'Kelas dengan nama yang sama sudah ada dalam prodi ini!');
        }

        $kela->update($request->all());
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }
}

