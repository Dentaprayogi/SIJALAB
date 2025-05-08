<?php

namespace App\Http\Controllers;

use App\Models\JadwalLab;
use App\Models\Lab;
use App\Models\Peminjaman;
use App\Models\PeminjamanDitolak;
use App\Models\PeminjamanJadwal;
use App\Models\PeminjamanManual;
use App\Models\PeminjamanSelesai;
use App\Models\Peralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with([
            'user', 
            'peralatan',
            'peminjamanManual.lab',
            'peminjamanJadwal.jadwalLab.lab'
        ])->latest()->get();
        return view('web.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $labs = Lab::all();
        $jadwals = JadwalLab::all();
        $peralatans = Peralatan::all();
        return view('web.peminjaman.create', compact('labs','jadwals', 'peralatans'));
    }

    public function storeJadwal(Request $request)
    {
        $request->validate([
            'id_jadwalLab' => 'required|exists:jadwal_lab,id_jadwalLab',
            'peralatan' => 'array',
        ]);

        DB::transaction(function () use ($request) {
            $peminjaman = Peminjaman::create([
                'tgl_peminjaman' => now()->format('Y-m-d'),
                'status_peminjaman' => 'pengajuan',
                'id' => Auth::id(),
            ]);

            PeminjamanJadwal::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_jadwalLab' => $request->id_jadwalLab,
            ]);

            $peminjaman->peralatan()->sync($request->peralatan);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman sesuai jadwal berhasil diajukan.');
    }

    public function storeManual(Request $request)
    {
        $request->validate([
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'id_lab' => 'required|exists:lab,id_lab',
            'peralatan' => 'array',
        ]);

        DB::transaction(function () use ($request) {
            $peminjaman = Peminjaman::create([
                'tgl_peminjaman' => now()->format('Y-m-d'),
                'status_peminjaman' => 'pengajuan',
                'id' => Auth::id(),
            ]);

            PeminjamanManual::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'id_lab' => $request->id_lab,
                'keterangan' => $request->keterangan,
            ]);

            $peminjaman->peralatan()->sync($request->peralatan);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman manual berhasil diajukan.');
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with([
            'user',
            'peralatan',
            'jadwalLab.hari',
            'jadwalLab.lab',
            'jadwalLab.mataKuliah',
            'jadwalLab.kelas',
        ])->findOrFail($id);
    
        return view('web.peminjaman.show', compact('peminjaman'));
    }

    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_peminjaman = 'dipinjam';
        $peminjaman->save();

        return redirect()->route('peminjaman.show', $id)->with('success', 'Peminjaman disetujui.');
    }

    public function selesai($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_peminjaman = 'selesai';
        $peminjaman->save();

        // Simpan ke tabel peminjaman_selesai
        PeminjamanSelesai::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'tgl_pengembalian' => now()->format('Y-m-d'),
            'jam_dikembalikan' => now()->format('H:i:s'),
        ]);

        return redirect()->route('peminjaman.show', $id)->with('success', 'Peminjaman diselesaikan.');
    }


    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string|max:255'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_peminjaman = 'ditolak';
        $peminjaman->save();

        // Simpan alasan penolakan ke tabel peminjaman_ditolak
        PeminjamanDitolak::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'alasan_ditolak' => $request->alasan_ditolak,
        ]);

        return redirect()->route('peminjaman.show', $id)->with('success', 'Peminjaman ditolak.');
    }


    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return back()->with('success', 'Peminjaman berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->selected_ids);
    
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
        }
    
        Peminjaman::whereIn('id_peminjaman', $ids)->delete();
    
        return redirect()->route('peminjaman.index')->with('success', 'Beberapa riwayat peminjaman berhasil dihapus.');
    }
}

