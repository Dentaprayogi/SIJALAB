<?php

namespace App\Http\Controllers;

use App\Models\Peralatan;
use Illuminate\Http\Request;

class PeralatanController extends Controller
{
    public function index()
    {
        $peralatan = Peralatan::all();
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
        Peralatan::destroy($id);
        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil dihapus.');
    }
}
