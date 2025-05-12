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
        $request->validate([
            'nama_peralatan' => 'required|string|max:255|unique:peralatan,nama_peralatan',
        ], [
            'nama_peralatan.unique' => 'Nama peralatan sudah ada, silakan gunakan nama lain.',
        ]);

        Peralatan::create($request->all());
        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_peralatan' => 'required|string|max:255|unique:peralatan,nama_peralatan,' . $id . ',id_peralatan',
        ], [
            'nama_peralatan.unique' => 'Nama peralatan sudah ada, silakan gunakan nama lain.',
        ]);

        $peralatan = Peralatan::findOrFail($id);
        $peralatan->update($request->all());
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
