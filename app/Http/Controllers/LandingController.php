<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Hari;
use App\Models\JadwalLab;
use Illuminate\Http\Request;
use App\Models\Lab;
use App\Models\PeminjamanJadwal;
use App\Models\PeminjamanManual;
use Carbon\Carbon;

class LandingController extends Controller
{
    public function index()
    {
        $labs = Lab::orderBy('nama_lab', 'asc')->get();
        $namaHariSekarang = now()->locale('id')->isoFormat('dddd');

        $hari = Hari::where('nama_hari', ucfirst($namaHariSekarang))->first()
            ?? abort(404, 'Hari tidak ditemukan');

        $currentTime = now()->format('H:i:s');

        foreach ($labs as $lab) {
            if ($lab->status_lab === 'nonaktif') {
                $lab->status = 'Nonaktif';
                continue;
            }

            $isDipinjam =
                PeminjamanJadwal::whereHas(
                    'jadwalLab',
                    fn($q) =>
                    $q->where('id_lab', $lab->id_lab)
                        ->where('id_hari', $hari->id_hari)
                        ->where('jam_mulai', '<=', $currentTime)
                        ->where('jam_selesai', '>=', $currentTime)
                )->whereHas(
                    'peminjaman',
                    fn($q) =>
                    $q->where('status_peminjaman', 'dipinjam')
                        ->whereDate('tgl_peminjaman', today())
                )->exists()

                ||

                PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereTime('jam_mulai', '<=', $currentTime)
                ->whereTime('jam_selesai', '>=', $currentTime)
                ->whereHas(
                    'peminjaman',
                    fn($q) =>
                    $q->where('status_peminjaman', 'dipinjam')
                        ->whereDate('tgl_peminjaman', today())
                )->exists();

            $isDiajukan =
                PeminjamanJadwal::whereHas(
                    'jadwalLab',
                    fn($q) =>
                    $q->where('id_lab', $lab->id_lab)
                        ->where('id_hari', $hari->id_hari)
                        ->where('jam_mulai', '<=', $currentTime)
                        ->where('jam_selesai', '>=', $currentTime)
                )->whereHas(
                    'peminjaman',
                    fn($q) =>
                    $q->where('status_peminjaman', 'pengajuan')
                        ->whereDate('tgl_peminjaman', today())
                )->exists()

                ||

                PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereTime('jam_mulai', '<=', $currentTime)
                ->whereTime('jam_selesai', '>=', $currentTime)
                ->whereHas(
                    'peminjaman',
                    fn($q) =>
                    $q->where('status_peminjaman', 'pengajuan')
                        ->whereDate('tgl_peminjaman', today())
                )->exists();

            $hasJadwal = JadwalLab::where('id_lab', $lab->id_lab)
                ->where('id_hari', $hari->id_hari)
                ->where('status_jadwalLab', 'aktif')
                ->where('jam_mulai', '<=', $currentTime)
                ->where('jam_selesai', '>=', $currentTime)
                ->exists();

            if ($isDipinjam) {
                $lab->status = 'Dipinjam';
            } elseif ($isDiajukan) {
                $lab->status = 'Pengajuan';
            } elseif ($hasJadwal) {
                $lab->status = 'Tersedia';
            } else {
                $lab->status = 'Kosong';
            }
        }

        return view('web.landing.index', compact('labs'));
    }

    // public function getJadwalLabHariIni(Request $request, $id_lab)
    // {
    //     $namaHariSekarang = Carbon::now()->locale('id')->isoFormat('dddd');
    //     $hari = Hari::where('nama_hari', ucfirst($namaHariSekarang))->first();

    //     if (!$hari) {
    //         return response()->json(['message' => 'Hari tidak ditemukan'], 404);
    //     }

    //     $jadwal = JadwalLab::with(['mataKuliah', 'dosen', 'lab']) // jika ada relasi
    //         ->where('id_lab', $id_lab)
    //         ->where('id_hari', $hari->id_hari)
    //         ->where('status_jadwalLab', 'aktif')
    //         ->orderBy('jam_mulai')
    //         ->get();

    //     return response()->json($jadwal);
    // }

    public function getJadwalLabHariIni(Request $request, $id_lab)
    {
        $namaHariSekarang = now()->locale('id')->isoFormat('dddd');
        $hari = Hari::where('nama_hari', ucfirst($namaHariSekarang))->first();

        if (!$hari) {
            return response()->json(['message' => 'Hari tidak ditemukan'], 404);
        }

        $jadwal = JadwalLab::with('matakuliah', 'kelas.prodi', 'lab')
            ->where('id_lab', $id_lab)
            ->where('id_hari', $hari->id_hari)
            ->where('status_jadwalLab', 'aktif')
            ->orderBy('jam_mulai')
            ->get()
            ->map(function ($item) {
                return [
                    'jam_mulai' => \Carbon\Carbon::parse($item->jam_mulai)->format('H:i'),
                    'jam_selesai' => \Carbon\Carbon::parse($item->jam_selesai)->format('H:i'),
                    'nama_mk' => $item->matakuliah->nama_mk ?? '-',
                    'nama_kelas' => $item->kelas->nama_kelas ?? '-',
                    'singkatan_prodi' => $item->kelas->prodi->singkatan_prodi ?? '-',
                ];
            });

        return response()->json($jadwal);
    }
}
