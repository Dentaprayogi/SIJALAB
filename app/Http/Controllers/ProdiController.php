<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodi = Prodi::orderBy('nama_prodi', 'asc')->get();
        return view('web.prodi.index', compact('prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodi,nama_prodi',
            'kode_prodi' => 'required|string|max:10|unique:prodi,kode_prodi',
        ], [
            'nama_prodi.unique' => 'Nama prodi sudah ada, silakan gunakan nama lain.',
            'kode_prodi.unique' => 'Kode prodi sudah ada, silakan gunakan kode lain.',
        ]);

        Prodi::create($request->all());
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $prodi = Prodi::findOrFail($id);
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodi,nama_prodi,' . $id . ',id_prodi',
            'kode_prodi' => 'required|string|max:10|unique:prodi,kode_prodi,' . $id . ',id_prodi',
        ], [
            'nama_prodi.unique' => 'Nama prodi sudah ada, silakan gunakan nama lain.',
            'kode_prodi.unique' => 'Kode prodi sudah ada, silakan gunakan kode lain.',
        ]);

        $prodi = Prodi::findOrFail($id);
        $prodi->update($request->all());
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Prodi::destroy($id);
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil dihapus.');
    }
}

