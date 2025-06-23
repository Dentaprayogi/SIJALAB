<?php

namespace App\Http\Controllers;

use App\Models\UnitPeralatan;
use App\Models\Peralatan;
use Illuminate\Http\Request;

class UnitPeralatanController extends Controller
{
    public function index()
    {
        $units = UnitPeralatan::select('unit_peralatan.*')
            ->join('peralatan', 'unit_peralatan.id_peralatan', '=', 'peralatan.id_peralatan')
            ->orderBy('peralatan.nama_peralatan', 'asc')
            ->orderBy('unit_peralatan.kode_unit', 'asc')
            ->with('peralatan') // agar relasi tetap tersedia di view
            ->get();

        $peralatans = Peralatan::orderBy('nama_peralatan', 'asc')->get();

        return view('web.unit_peralatan.index', compact('units', 'peralatans'));
    }

    public function create()
    {
        $peralatans = Peralatan::all();
        return view('web.unit_peralatan.create', compact('peralatans'));
    }

    public function store(Request $request)
    {
        // Ubah ke uppercase dulu
        $request->merge([
            'kode_unit' => strtoupper($request->kode_unit),
        ]);

        // Validasi input setelah diubah
        $request->validate([
            'id_peralatan' => 'required|exists:peralatan,id_peralatan',
            'kode_unit' => 'required|unique:unit_peralatan,kode_unit',
        ]);

        // Simpan ke database
        UnitPeralatan::create($request->all());

        return redirect()->route('unit-peralatan.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $unit = UnitPeralatan::findOrFail($id);

        // Ubah kode_unit menjadi huruf besar
        $request->merge([
            'kode_unit' => strtoupper($request->kode_unit),
        ]);

        $request->validate([
            'id_peralatan' => 'required|exists:peralatan,id_peralatan',
            'kode_unit' => 'required|string|max:255|unique:unit_peralatan,kode_unit,' . $id . ',id_unit',
            'status_unit' => 'required|in:tersedia,dipinjam,rusak',
        ], [
            'kode_unit.unique' => 'Kode unit sudah ada, silakan gunakan kode lain.',
        ]);

        // Update data unit
        $unit->update([
            'id_peralatan' => $request->id_peralatan,
            'kode_unit' => $request->kode_unit,
            'status_unit' => $request->status_unit,
        ]);

        return redirect()->route('unit-peralatan.index')->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $unit = UnitPeralatan::findOrFail($id);

        // Cek apakah unit terhubung dengan peminjaman aktif
        $isUsedInPeminjaman = $unit->peminjaman()
            ->whereIn('status_peminjaman', ['dipinjam', 'pengajuan', 'bermasalah'])
            ->exists();

        if ($isUsedInPeminjaman) {
            return redirect()->route('unit-peralatan.index')
                ->with('error', 'Unit tidak dapat dihapus karena masih terhubung dengan peminjaman yang aktif.');
        }

        $unit->delete();

        return redirect()->route('unit-peralatan.index')
            ->with('success', 'Unit berhasil dihapus.');
    }
}
