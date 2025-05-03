<?php

namespace App\Http\Controllers;

use App\Models\Lab;
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
            'nama_lab' => 'required|string|max:255',
            'fasilitas_lab' => 'required|string',
            'kapasitas_lab' => 'required|integer',
        ]);

        Lab::create([
            'nama_lab' => $request->nama_lab,
            'fasilitas_lab' => $request->fasilitas_lab,
            'kapasitas_lab' => $request->kapasitas_lab,
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
            'nama_lab' => 'required|string|max:255',
            'fasilitas_lab' => 'required|string',
            'kapasitas_lab' => 'required|integer',
            'status_lab' => 'required|in:aktif,nonaktif',
        ]);

        $lab = Lab::findOrFail($id_lab);
        $lab->update($request->all());

        return redirect()->route('lab.index')->with('success', 'Data lab berhasil diperbarui.');
    }

    public function destroy($id_lab)
    {
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
