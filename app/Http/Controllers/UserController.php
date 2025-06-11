<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        $prodiList = Prodi::all();
        $kelasList = Kelas::all();
        return view('web.user.index', compact('users', 'prodiList', 'kelasList'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('web.user.show', compact('user'));
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Cegah user dengan role teknisi diubah statusnya
        if ($user->role === 'teknisi') {
            return response()->json(['message' => 'User teknisi tidak boleh diubah statusnya.'], 403);
        }

        $status = $request->status_user;
        if (!in_array($status, ['aktif', 'nonaktif'])) {
            return response()->json(['message' => 'Status tidak valid.'], 422);
        }

        // Cek apakah user masih memiliki peminjaman aktif saat ingin dinonaktifkan
        if ($status === 'nonaktif') {
            $peminjamanAktif = $user->peminjaman()
                ->whereIn('status_peminjaman', ['pengajuan', 'dipinjam'])
                ->exists();

            if ($peminjamanAktif) {
                return response()->json(['message' => 'User tidak dapat dinonaktifkan karena masih memiliki peminjaman yang aktif.'], 403);
            }
        }

        $user->status_user = $status;
        $user->save();

        return response()->json(['message' => 'Status user berhasil diubah']);
    }

    public function toggleAksesUbahKelas(Request $request)
    {
        $aksi = $request->input('aksi');

        if ($aksi === 'beri') {
            // Berikan akses ubah kelas
            User::where('role', 'mahasiswa')->update(['akses_ubah_kelas' => true]);
            return back()->with('success', 'Akses ubah kelas diberikan ke semua mahasiswa.');
        } elseif ($aksi === 'cabut') {
            // Cabut akses ubah kelas
            User::where('role', 'mahasiswa')->update(['akses_ubah_kelas' => false]);
            return back()->with('success', 'Akses ubah kelas dicabut dari semua mahasiswa.');
        }

        return back()->with('error', 'Aksi tidak valid.');
    }

    public function updateFromAdmin(Request $request)
    {
        // Validasi standar
        $request->validate([
            'id' => 'required|exists:users,id',
            'nim' => 'required|string|max:20|unique:mahasiswa,nim,' . $request->id . ',id',
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'id_kelas' => 'required|exists:kelas,id_kelas',
        ], [
            'nim.unique' => 'NIM sudah digunakan oleh mahasiswa lain.',
            'nim.required' => 'NIM wajib diisi.',
            'id_prodi.required' => 'Prodi wajib dipilih.',
            'id_kelas.required' => 'Kelas wajib dipilih.',
        ]);

        // Ambil kelas berdasarkan ID
        $kelas = \App\Models\Kelas::find($request->id_kelas);

        // Cek apakah id_prodi pada kelas sesuai dengan yang dipilih
        if ($kelas->id_prodi != $request->id_prodi) {
            return redirect()->back()->withErrors(['id_kelas' => 'Kelas tidak sesuai dengan prodi yang dipilih.'])->withInput();
        }

        // Update data mahasiswa
        $mahasiswa = Mahasiswa::where('id', $request->id)->firstOrFail();

        $mahasiswa->update([
            'nim' => $request->nim,
            'id_prodi' => $request->id_prodi,
            'id_kelas' => $request->id_kelas,
        ]);

        return redirect()->back()->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'teknisi') {
            return redirect()->back()->with('error', 'User dengan role teknisi tidak boleh dihapus.');
        }

        // Cek apakah user masih memiliki peminjaman aktif atau bermasalah
        $peminjamanAktif = $user->peminjaman()
            ->whereIn('status_peminjaman', ['pengajuan', 'dipinjam'])
            ->exists();

        if ($peminjamanAktif) {
            return redirect()->back()->with('error', 'User tidak dapat dihapus karena masih memiliki peminjaman yang aktif.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        // Pastikan request mengandung array selected_ids
        $ids = $request->input('selected_ids');

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada user yang dipilih untuk dihapus.');
        }

        // Status peminjaman yang dianggap aktif
        $statusAktif = ['pengajuan', 'dipinjam'];

        // Ambil ID user yang memiliki peminjaman aktif
        $userDenganPeminjamanAktif = User::whereIn('id', $ids)
            ->whereHas('peminjaman', function ($query) use ($statusAktif) {
                $query->whereIn('status_peminjaman', $statusAktif);
            })
            ->pluck('id')
            ->toArray();

        // Filter user yang boleh dihapus:
        // - role == mahasiswa
        // - tidak punya peminjaman aktif
        $userYangBolehDihapus = User::whereIn('id', $ids)
            ->whereNotIn('id', $userDenganPeminjamanAktif)
            ->where('role', 'mahasiswa')
            ->pluck('id')
            ->toArray();

        if (empty($userYangBolehDihapus)) {
            return redirect()->back()->with('error', 'Semua user memiliki peminjaman aktif atau bukan berperan sebagai mahasiswa.');
        }

        // Hapus user yang valid
        User::whereIn('id', $userYangBolehDihapus)->delete();

        $jumlahGagal = count($ids) - count($userYangBolehDihapus);

        $pesan = 'Beberapa user berhasil dihapus.';
        if ($jumlahGagal > 0) {
            $pesan .= " $jumlahGagal user tidak bisa dihapus karena bukan mahasiswa atau masih memiliki peminjaman aktif.";
        }

        return redirect()->route('users.index')->with('success', $pesan);
    }
}
