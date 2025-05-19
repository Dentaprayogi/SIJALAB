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
        $request->validate([
            'id_peralatan' => 'required|exists:peralatan,id_peralatan',
            'kode_unit' => 'required|unique:unit_peralatan,kode_unit',
        ]);

        UnitPeralatan::create($request->all());

        return redirect()->route('unit-peralatan.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $unit = UnitPeralatan::findOrFail($id);
        $peralatans = Peralatan::all();
        return view('web.unit_peralatan.edit', compact('unit', 'peralatans'));
    }

    public function update(Request $request, $id)
    {
        $unit = UnitPeralatan::findOrFail($id);

        $request->validate([
            'id_peralatan' => 'required|exists:peralatan,id_peralatan',
            'kode_unit' => 'required|unique:unit_peralatan,kode_unit,' . $id . ',id_unit',
            'status_unit' => 'required|in:tersedia,dipinjam,rusak',
        ]);

        $unit->update($request->all());

        return redirect()->route('unit-peralatan.index')->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $unit = UnitPeralatan::findOrFail($id);
        $unit->delete();

        return redirect()->route('unit-peralatan.index')->with('success', 'Unit berhasil dihapus.');
    }
}
