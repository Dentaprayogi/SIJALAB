<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        $dosens = Dosen::with('prodi')->orderBy('nama_dosen', 'asc')->get();
        $prodi = Prodi::all();
        return view('web.dosen.index', compact('dosens', 'prodi'));
    }

    public function store(Request $request)
    {
        // Format nama_dosen menjadi Title Case termasuk setelah titik
        $namaDosen = preg_replace_callback('/(^|\s|\.)\w/u', function ($match) {
            return mb_strtoupper($match[0]);
        }, mb_strtolower($request->nama_dosen));

        // Masukkan ke dalam request agar ikut divalidasi
        $request->merge([
            'nama_dosen' => $namaDosen,
        ]);

        // Validasi setelah nama_dosen diformat
        $request->validate([
            'nama_dosen' => 'required|unique:dosen,nama_dosen',
            'telepon'    => 'nullable|string|max:20',
            'id_prodi'   => 'required|exists:prodi,id_prodi',
        ], [
            'nama_dosen.unique' => 'Nama dosen sudah terdaftar.',
        ]);

        Dosen::create($request->only(['nama_dosen', 'telepon', 'id_prodi']));

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        // Format nama_dosen jadi Title Case termasuk setelah titik
        $namaDosen = preg_replace_callback('/(^|\s|\.)\w/u', function ($match) {
            return mb_strtoupper($match[0]);
        }, mb_strtolower($request->nama_dosen));

        // Gabungkan hasil ke dalam request agar divalidasi dan disimpan
        $request->merge([
            'nama_dosen' => $namaDosen,
        ]);

        // Validasi setelah merge
        $request->validate([
            'nama_dosen' => 'required|unique:dosen,nama_dosen,' . $id . ',id_dosen',
            'telepon'    => 'nullable|string|max:20',
            'id_prodi'   => 'required|exists:prodi,id_prodi',
        ], [
            'nama_dosen.unique' => 'Nama dosen sudah terdaftar.',
        ]);

        // Update data dosen
        $dosen->update($request->only(['nama_dosen', 'telepon', 'id_prodi']));

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);

        $hasJadwalLab = $dosen->jadwalLab()->exists();

        if ($hasJadwalLab) {
            return redirect()->route('dosen.index')
                ->with('error', 'Dosen tidak dapat dihapus karena masih memiliki jadwal lab yang terkait.');
        }

        $dosen->delete();

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil dihapus.');
    }
}
