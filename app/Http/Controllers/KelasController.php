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
            ->orderBy('prodi.singkatan_prodi', 'asc') // Urut berdasarkan singkatan_prodi
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

    public function update(Request $request, $id_kelas)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'nama_kelas' => 'required|string|max:255',
        ]);

        // Ambil data kelas berdasarkan ID
        $kelas = Kelas::findOrFail($id_kelas);

        // Cek apakah sudah ada kelas dengan nama dan prodi yang sama, tapi bukan dirinya sendiri
        $cekKelas = Kelas::where('id_prodi', $request->id_prodi)
            ->where('nama_kelas', $request->nama_kelas)
            ->where('id_kelas', '!=', $kelas->id_kelas)
            ->exists();

        if ($cekKelas) {
            return redirect()->route('kelas.index')->withInput()->with('error', 'Kelas dengan nama yang sama sudah ada dalam prodi ini!');
        }

        // Update data kelas
        $kelas->update([
            'id_prodi' => $request->id_prodi,
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy($id_kelas)
    {
        $kelas = Kelas::findOrFail($id_kelas);

        $hasMahasiswa = $kelas->mahasiswa()->exists();
        $hasJadwalLab = $kelas->jadwalLab()->exists();

        if ($hasMahasiswa || $hasJadwalLab) {
            return redirect()->route('kelas.index')->with('error', 'Kelas tidak dapat dihapus karena masih memiliki mahasiswa atau jadwal lab.');
        }

        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }

    public function getByProdi($id_prodi)
    {
        $kelasList = Kelas::where('id_prodi', $id_prodi)->get(['id_kelas', 'nama_kelas']);
        return response()->json($kelasList);
    }
}
