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
        // 1. Validasi input
        $request->validate([
            'id_prodi'    => 'required|exists:prodi,id_prodi',
            'angka_kelas' => 'required|in:1,2,3,4',
            'huruf_kelas' => 'required|alpha|size:1',
        ]);

        // 2. Bangun nama_kelas (mis. 1A, 3C) dan pastikan huruf kapital
        $namaKelas = $request->angka_kelas . strtoupper($request->huruf_kelas);

        // 3. Cek duplikat kelas pada prodi yang sama
        $duplikat = Kelas::where('id_prodi', $request->id_prodi)
            ->where('nama_kelas', $namaKelas)
            ->exists();

        if ($duplikat) {
            // Ambil singkatan prodi dari database
            $prodi = \App\Models\Prodi::find($request->id_prodi);

            return back()
                ->withInput()
                ->with('error', "Kelas $namaKelas sudah ada pada prodi $prodi->singkatan_prodi!");
        }

        // 4. Simpan data
        Kelas::create([
            'id_prodi'   => $request->id_prodi,
            'nama_kelas' => $namaKelas,
        ]);

        // 5. Beri notifikasi sukses
        return redirect()
            ->route('kelas.index')
            ->with('success', "Kelas $namaKelas berhasil ditambahkan!");
    }

    public function update(Request $request, $id_kelas)
    {
        /* 1. Validasi */
        $request->validate([
            'id_prodi'    => 'required|exists:prodi,id_prodi',
            'angka_kelas' => 'required|in:1,2,3,4',
            'huruf_kelas' => 'required|alpha|size:1',
        ]);

        /* 2. Bangun nama_kelas (mis. 2B) */
        $namaKelas = $request->angka_kelas . strtoupper($request->huruf_kelas);

        /* 3. Ambil data kelas yang akan di‑update */
        $kelas = Kelas::findOrFail($id_kelas);

        /* 4. Cek duplikat di prodi yang sama (kecuali dirinya sendiri) */
        $duplikat = Kelas::where('id_prodi', $request->id_prodi)
            ->where('nama_kelas', $namaKelas)
            ->where('id_kelas', '!=', $kelas->id_kelas)
            ->exists();

        if ($duplikat) {
            $prodi = Prodi::find($request->id_prodi);   // ambil singkatan prodi

            return back()
                ->withInput()
                ->with('error', "Kelas $namaKelas sudah ada pada prodi $prodi->singkatan_prodi!");
        }

        /* 5. Update data */
        $kelas->update([
            'id_prodi'   => $request->id_prodi,
            'nama_kelas' => $namaKelas,
        ]);

        /* 6. Notifikasi sukses */
        return redirect()
            ->route('kelas.index')
            ->with('success', "Kelas $namaKelas berhasil diperbarui!");
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
