<?php

namespace App\Http\Controllers;

use App\Models\JadwalLab;
use App\Models\Lab;
use App\Models\PeminjamanJadwal;
use App\Models\PeminjamanManual;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index()
    {
        $lab = Lab::orderBy('nama_lab', 'asc')->get();
        return view('web.lab.index', compact('lab'));
    }

    public function create()
    {
        return view('web.lab.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lab' => 'required|string|max:255|unique:lab,nama_lab',
        ], [
            'nama_lab.unique' => 'Nama lab sudah terdaftar.',
        ]);

        Lab::create([
            'nama_lab' => $request->nama_lab,
            'status_lab' => 'aktif', // default value
        ]);

        return redirect()->route('lab.index')->with('success', 'Data lab berhasil ditambahkan.');
    }

    public function edit($id_lab)
    {
        $lab = Lab::findOrFail($id_lab);
        return view('web.lab.edit', compact('lab'));
    }

    public function update(Request $request, $id_lab)
    {
        $request->validate([
            'nama_lab' => 'required|string|max:255|unique:lab,nama_lab,' . $id_lab . ',id_lab',
            'status_lab' => 'required|in:aktif,nonaktif',
        ], [
            'nama_lab.unique' => 'Nama lab sudah terdaftar.',
        ]);

        $lab = Lab::findOrFail($id_lab);

        // Cek jika ingin nonaktif, pastikan tidak terhubung dengan jadwal atau peminjaman_manual aktif
        if ($request->status_lab === 'nonaktif') {
            $isInJadwal = JadwalLab::where('id_lab', $lab->id_lab)->exists();

            $isInPeminjamanManual = PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereHas('peminjaman', function ($query) {
                    $query->whereIn('status_peminjaman', ['pengajuan', 'dipinjam']);
                })
                ->exists();

            if ($isInJadwal || $isInPeminjamanManual) {
                return redirect()->back()->with('error', 'Tidak bisa menonaktifkan lab karena masih terhubung dengan jadwal atau peminjaman yang belum selesai (Pengajuan atau Dipinjam).');
            }
        }

        $lab->update($request->all());

        return redirect()->route('lab.index')->with('success', 'Data lab berhasil diperbarui.');
    }

    public function destroy($id_lab)
    {
        // Cek apakah lab masih terhubung dengan jadwal lab, peminjaman jadwal, atau peminjaman manual
        $hasJadwalLab = JadwalLab::where('id_lab', $id_lab)->exists();
        $hasPeminjamanManual = PeminjamanManual::where('id_lab', $id_lab)->exists();

        if ($hasJadwalLab || $hasPeminjamanManual) {
            return redirect()->route('lab.index')
                ->with('error', 'Lab tidak dapat dihapus karena masih terhubung dengan jadwal lab atau peminjaman manual (Pengajuan atau Dipinjam).');
        }

        // Hapus data lab jika tidak terhubung
        Lab::destroy($id_lab);

        return redirect()->route('lab.index')->with('success', 'Data lab berhasil dihapus.');
    }

    public function toggleStatus(Request $request, $id_lab)
    {
        $lab = Lab::where('id_lab', $id_lab)->firstOrFail();

        $status = $request->status_lab;
        if (!in_array($status, ['aktif', 'nonaktif'])) {
            return response()->json(['message' => 'Status tidak valid.'], 422);
        }

        $lab->status_lab = $status;
        $lab->save();

        return response()->json(['message' => 'Status lab berhasil diubah.']);
    }
}
