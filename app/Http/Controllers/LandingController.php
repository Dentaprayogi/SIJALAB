<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hari;
use App\Models\Lab;
use App\Models\JadwalLab;
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
            $lab->status = 'Kosong';

            if ($lab->status_lab === 'nonaktif') {
                $lab->status = 'Nonaktif';
                continue;
            }

            // Cek status DIPINJAM
            $isDipinjam =
                PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari, $currentSesi) {
                    $q->where('id_lab', $lab->id_lab)
                        ->where('id_hari', $hari->id_hari);

                    if ($currentSesi) {
                        $q->whereHas('sesiJam', function ($q2) use ($currentSesi) {
                            $q2->where('sesi_jam.id_sesi_jam', $currentSesi->id_sesi_jam);
                        });
                    }
                })->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'dipinjam')
                        ->whereDate('tgl_peminjaman', today());
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

            // Cek status PENGAJUAN
            $isDiajukan =
                PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari, $currentSesi) {
                    $q->where('id_lab', $lab->id_lab)
                        ->where('id_hari', $hari->id_hari);

                    if ($currentSesi) {
                        $q->whereHas('sesiJam', function ($q2) use ($currentSesi) {
                            $q2->where('sesi_jam.id_sesi_jam', $currentSesi->id_sesi_jam);
                        });
                    }
                })->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'pengajuan')
                        ->whereDate('tgl_peminjaman', today());
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

            // Cek apakah ada jadwal aktif saat ini
            $hasJadwal = JadwalLab::where('id_lab', $lab->id_lab)
                ->where('id_hari', $hari->id_hari)
                ->where('status_jadwalLab', 'aktif')
                ->whereHas('sesiJam', function ($q) use ($currentSesi) {
                    if ($currentSesi) {
                        $q->where('sesi_jam.id_sesi_jam', $currentSesi->id_sesi_jam);
                    }
                })->exists();

            // Tentukan status akhir lab
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

        $jadwal = JadwalLab::with(['mataKuliah', 'kelas.prodi', 'sesiJam'])
            ->where('id_lab', $id_lab)
            ->where('id_hari', $hari->id_hari)
            ->where('status_jadwalLab', 'aktif')
            ->get();

        $data = [];

        foreach ($jadwal as $item) {
            if ($item->sesiJam->isNotEmpty()) {
                $jamMulai = $item->sesiJam->sortBy('jam_mulai')->first()->jam_mulai;
                $jamSelesai = $item->sesiJam->sortByDesc('jam_selesai')->first()->jam_selesai;

                $data[] = [
                    'jam_mulai' => \Carbon\Carbon::parse($jamMulai)->format('H:i'),
                    'jam_selesai' => \Carbon\Carbon::parse($jamSelesai)->format('H:i'),
                    'nama_mk' => $item->mataKuliah->nama_mk ?? '-',
                    'nama_kelas' => $item->kelas->nama_kelas ?? '-',
                    'singkatan_prodi' => $item->kelas->prodi->singkatan_prodi ?? '-',
                ];
            }
        }

        // Urutkan berdasarkan jam_mulai
        $sorted = collect($data)->sortBy('jam_mulai')->values();

        return response()->json($sorted);
    }
}
