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

        // Format NIP menjadi UPPERCASE (jika diperlukan, biasanya angka saja, tapi antisipasi jika alfanumerik)
        $nip = strtoupper($request->nip);

        // Masukkan nama_dosen & nip yang sudah diformat ke dalam request
        $request->merge([
            'nama_dosen' => $namaDosen,
            'nip' => $nip,
        ]);

        // Validasi
        $request->validate([
            'nama_dosen' => 'required|unique:dosen,nama_dosen',
            'nip'        => 'required|unique:dosen,nip',
            'telepon'    => 'nullable|string|max:20',
            'id_prodi'   => 'required|exists:prodi,id_prodi',
        ], [
            'nama_dosen.unique' => 'Nama dosen sudah terdaftar.',
            'nip.unique'        => 'NIP sudah digunakan.',
        ]);

        // Simpan data
        Dosen::create($request->only(['nama_dosen', 'nip', 'telepon', 'id_prodi']));

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        // Format nama_dosen menjadi Title Case termasuk setelah titik
        $namaDosen = preg_replace_callback('/(^|\s|\.)\w/u', function ($match) {
            return mb_strtoupper($match[0]);
        }, mb_strtolower($request->nama_dosen));

        // Format NIP menjadi uppercase (jika alfanumerik)
        $nip = strtoupper($request->nip);

        // Masukkan ke dalam request agar ikut divalidasi dan diupdate
        $request->merge([
            'nama_dosen' => $namaDosen,
            'nip' => $nip,
        ]);

        // Validasi input
        $request->validate([
            'nama_dosen' => 'required|unique:dosen,nama_dosen,' . $id . ',id_dosen',
            'nip'        => 'required|unique:dosen,nip,' . $id . ',id_dosen',
            'telepon'    => 'nullable|string|max:20',
            'id_prodi'   => 'required|exists:prodi,id_prodi',
        ], [
            'nama_dosen.unique' => 'Nama dosen sudah terdaftar.',
            'nip.unique'        => 'NIP sudah digunakan.',
        ]);

        // Update data dosen
        $dosen->update($request->only(['nama_dosen', 'nip', 'telepon', 'id_prodi']));

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
