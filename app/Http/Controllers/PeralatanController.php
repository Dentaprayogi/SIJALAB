<?php

namespace App\Http\Controllers;

use App\Models\Peralatan;
use Illuminate\Http\Request;

class PeralatanController extends Controller
{
    public function index()
    {
        $peralatan = Peralatan::orderBy('nama_peralatan', 'asc')->get();
        return view('web.peralatan.index', compact('peralatan'));
    }

    public function store(Request $request)
    {
        // Ubah terlebih dahulu sebelum validasi
        $request->merge([
            'nama_peralatan' => ucwords(strtolower($request->nama_peralatan))
        ]);

        $request->validate([
            'nama_peralatan' => 'required|string|max:255|unique:peralatan,nama_peralatan',
        ], [
            'nama_peralatan.unique' => 'Nama peralatan sudah ada, silakan gunakan nama lain.',
        ]);

        Peralatan::create([
            'nama_peralatan' => $request->nama_peralatan,
        ]);

        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // Ubah nama_peralatan ke Title Case lebih dulu
        $namaTitleCase = ucwords(strtolower($request->nama_peralatan));

        // Ganti nama_peralatan di request agar validasi pakai yang sudah dibersihkan
        $request->merge([
            'nama_peralatan' => $namaTitleCase,
        ]);

        // Validasi input
        $request->validate([
            'nama_peralatan' => 'required|string|max:255|unique:peralatan,nama_peralatan,' . $id . ',id_peralatan',
        ], [
            'nama_peralatan.unique' => 'Nama peralatan sudah ada, silakan gunakan nama lain.',
        ]);

        // Ambil data dan update
        $peralatan = Peralatan::findOrFail($id);
        $peralatan->update([
            'nama_peralatan' => $namaTitleCase,
        ]);

        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Menemukan peralatan berdasarkan ID
        $peralatan = Peralatan::findOrFail($id);

        // Mengecek apakah peralatan masih terhubung dengan peminjaman yang statusnya dipinjam, pengajuan, atau bermasalah
        $isUsedInPeminjaman = $peralatan->peminjaman()->whereIn('status_peminjaman', ['dipinjam', 'pengajuan', 'bermasalah'])->exists();

        if ($isUsedInPeminjaman) {
            // Jika peralatan masih terhubung dengan peminjaman yang statusnya dipinjam, pengajuan, atau bermasalah
            return redirect()->route('peralatan.index')->with('error', 'Peralatan tidak dapat dihapus karena masih terhubung dengan peminjaman yang aktif.');
        }

        // Jika peralatan tidak terhubung dengan peminjaman yang statusnya dipinjam, pengajuan, atau bermasalah, hapus peralatan
        $peralatan->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil dihapus.');
    }
}
