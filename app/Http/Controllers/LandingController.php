<?php

namespace App\Http\Controllers;

use App\Models\Hari;
use App\Models\JadwalLab;
use Illuminate\Http\Request;
use App\Models\Lab;
use App\Models\PeminjamanJadwal;
use App\Models\PeminjamanManual;
use App\Models\SesiJam;
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

        // Ambil sesi jam saat ini
        $currentSesi = SesiJam::where('jam_mulai', '<=', $currentTime)
            ->where('jam_selesai', '>=', $currentTime)
            ->first();

        foreach ($labs as $lab) {
            if ($lab->status_lab === 'nonaktif') {
                $lab->status = 'Nonaktif';
                continue;
            }

            // Status default
            $lab->status = 'Kosong';

            // Cek peminjaman dengan status 'dipinjam'
            $isDipinjam =
                PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari) {
                    $q->where('id_lab', $lab->id_lab)
                        ->where('id_hari', $hari->id_hari);
                })->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'dipinjam')
                        ->whereDate('tgl_peminjaman', today());
                })->where(function ($q) use ($currentSesi) {
                    if ($currentSesi) {
                        $q->where('id_sesi_mulai', '<=', $currentSesi->id_sesi_jam)
                            ->where('id_sesi_selesai', '>=', $currentSesi->id_sesi_jam);
                    }
                })->exists()

                ||

                PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'dipinjam')
                        ->whereDate('tgl_peminjaman', today());
                })->where(function ($q) use ($currentSesi) {
                    if ($currentSesi) {
                        $q->where('id_sesi_mulai', '<=', $currentSesi->id_sesi_jam)
                            ->where('id_sesi_selesai', '>=', $currentSesi->id_sesi_jam);
                    }
                })->exists();

            // Cek peminjaman dengan status 'pengajuan'
            $isDiajukan =
                PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari) {
                    $q->where('id_lab', $lab->id_lab)
                        ->where('id_hari', $hari->id_hari);
                })->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'pengajuan')
                        ->whereDate('tgl_peminjaman', today());
                })->where(function ($q) use ($currentSesi) {
                    if ($currentSesi) {
                        $q->where('id_sesi_mulai', '<=', $currentSesi->id_sesi_jam)
                            ->where('id_sesi_selesai', '>=', $currentSesi->id_sesi_jam);
                    }
                })->exists()

                ||

                PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'pengajuan')
                        ->whereDate('tgl_peminjaman', today());
                })->where(function ($q) use ($currentSesi) {
                    if ($currentSesi) {
                        $q->where('id_sesi_mulai', '<=', $currentSesi->id_sesi_jam)
                            ->where('id_sesi_selesai', '>=', $currentSesi->id_sesi_jam);
                    }
                })->exists();

            // Cek apakah ada jadwal aktif (tanpa peminjaman)
            $hasJadwal = JadwalLab::where('id_lab', $lab->id_lab)
                ->where('id_hari', $hari->id_hari)
                ->where('status_jadwalLab', 'aktif')
                ->whereHas('sesiJam', function ($q) use ($currentSesi) {
                    if ($currentSesi) {
                        $q->where('sesi_jam.id_sesi_jam', $currentSesi->id_sesi_jam);
                    }
                })->exists();

            // Tentukan status akhir
            if ($isDipinjam) {
                $lab->status = 'Dipinjam';
            } elseif ($isDiajukan) {
                $lab->status = 'Pengajuan';
            } elseif ($hasJadwal) {
                $lab->status = 'Tersedia';
            }
        }

        return view('web.landing.index', compact('labs'));
    }

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
