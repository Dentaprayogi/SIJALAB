<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;

class TahunAjaranController extends Controller
{
    public function index() {
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        return view('web.tahunajaran.index', compact('tahunAjaran'));
    }

    public function store(Request $request) {
        $request->validate([
            'tahun_ajaran' => 'required',
            'semester' => 'required|in:ganjil,genap',
            'status_tahunAjaran' => 'aktif'
        ]);
    
        // Cek apakah kombinasi tahun ajaran dan semester sudah ada
        $exists = TahunAjaran::where('tahun_ajaran', $request->tahun_ajaran)
                    ->where('semester', $request->semester)
                    ->exists();
    
        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Tahun ajaran dan semester ini sudah ada.');
        }
    
        TahunAjaran::create($request->all());
    
        return redirect()->route('tahunajaran.index')->with('success', 'Tahun Ajaran berhasil ditambahkan');
    }
    
    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
            'semester' => 'required|in:ganjil,genap',
            'status_tahunAjaran' => 'required|in:aktif,nonaktif'
        ]);

        // Cek apakah kombinasi tahun ajaran dan semester sudah ada, kecuali untuk data yang sedang diupdate
        $exists = TahunAjaran::where('tahun_ajaran', $request->tahun_ajaran)
                    ->where('semester', $request->semester)
                    ->where('id_tahunAjaran', '!=', $tahunAjaran->id_tahunAjaran)
                    ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Tahun ajaran dan semester ini sudah ada.');
        }

        // Perbarui data dengan memastikan semua kolom dikirimkan
        $tahunAjaran->update([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'status_tahunAjaran' => $request->status_tahunAjaran
        ]);

        return redirect()->route('tahunajaran.index')->with('success', 'Tahun Ajaran berhasil diperbarui');
    }


    public function destroy(TahunAjaran $tahunAjaran) {
        $tahunAjaran->delete();
        return redirect()->route('tahunajaran.index')->with('success', 'Tahun Ajaran berhasil dihapus');
    }
}
