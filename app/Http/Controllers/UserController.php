<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return view('web.user.index', compact('users'));
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
