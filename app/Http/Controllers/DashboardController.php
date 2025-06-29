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

class DashboardController extends Controller
{

    public function index()
    {
        $labs = Lab::orderBy('nama_lab', 'asc')->get();
        $namaHariSekarang = now()->locale('id')->isoFormat('dddd');

        $hari = Hari::where('nama_hari', ucfirst($namaHariSekarang))->first()
            ?? abort(404, 'Hari tidak ditemukan');

        $currentTime = now()->format('H:i:s');

        // Ambil sesi jam saat ini berdasarkan waktu sekarang
        $currentSesi = SesiJam::where('jam_mulai', '<=', $currentTime)
            ->where('jam_selesai', '>=', $currentTime)
            ->first();

        foreach ($labs as $lab) {
            $lab->status = 'Kosong';

            if ($lab->status_lab === 'nonaktif') {
                $lab->status = 'Nonaktif';
                continue;
            }

            // Cek peminjaman status dipinjam
            $isDipinjam =
                PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari) {
                    $q->where('id_lab', $lab->id_lab)
                        ->where('id_hari', $hari->id_hari);
                })->whereHas('peminjaman', function ($q) use ($currentSesi) {
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

            // Cek peminjaman status pengajuan
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

            // Cek apakah ada jadwal aktif
            $hasJadwal = JadwalLab::where('id_lab', $lab->id_lab)
                ->where('id_hari', $hari->id_hari)
                ->where('status_jadwalLab', 'aktif')
                ->whereHas('sesiJam', function ($q) use ($currentSesi) {
                    if ($currentSesi) {
                        $q->where('sesi_jam.id_sesi_jam', $currentSesi->id_sesi_jam);
                    }
                })
                ->exists();

            // Tentukan status
            if ($isDipinjam) {
                $lab->status = 'Dipinjam';
            } elseif ($isDiajukan) {
                $lab->status = 'Pengajuan';
            } elseif ($hasJadwal) {
                $lab->status = 'Tersedia';
            }

            // Ambil data peminjaman aktif untuk modal
            $lab->peminjamanAktif = PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari) {
                $q->where('id_lab', $lab->id_lab)
                    ->where('id_hari', $hari->id_hari);
            })->whereHas('peminjaman', function ($q) {
                $q->whereIn('status_peminjaman', ['pengajuan', 'dipinjam'])
                    ->whereDate('tgl_peminjaman', today());
            })->where(function ($q) use ($currentSesi) {
                if ($currentSesi) {
                    $q->where('id_sesi_mulai', '<=', $currentSesi->id_sesi_jam)
                        ->where('id_sesi_selesai', '>=', $currentSesi->id_sesi_jam);
                }
            })->with([
                'peminjaman.user.mahasiswa.prodi',
                'peminjaman.user.mahasiswa.kelas',
            ])->get();

            $lab->peminjamanManualAktif = PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereHas('peminjaman', function ($q) {
                    $q->whereIn('status_peminjaman', ['pengajuan', 'dipinjam'])
                        ->whereDate('tgl_peminjaman', today());
                })->where(function ($q) use ($currentSesi) {
                    if ($currentSesi) {
                        $q->where('id_sesi_mulai', '<=', $currentSesi->id_sesi_jam)
                            ->where('id_sesi_selesai', '>=', $currentSesi->id_sesi_jam);
                    }
                })->with([
                    'peminjaman.user.mahasiswa.prodi',
                    'peminjaman.user.mahasiswa.kelas',
                ])->get();
        }

        return view('web.dashboard.index', compact('labs'));
    }
}
