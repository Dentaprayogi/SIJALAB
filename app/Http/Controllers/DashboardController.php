<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hari;
use App\Models\Lab;
use App\Models\JadwalLab;
use App\Models\Peminjaman;
use App\Models\PeminjamanJadwal;
use App\Models\PeminjamanManual;
use App\Models\SesiJam;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        //Auto‑aktifkan kembali jadwal yang habis masa nonaktif
        JadwalLab::where('status_jadwalLab', 'nonaktif')
            ->whereNotNull('waktu_akhir_nonaktif')
            ->where('waktu_akhir_nonaktif', '<=', now())
            ->update([
                'status_jadwalLab'       => 'aktif',
                'waktu_mulai_nonaktif'   => null,
                'waktu_akhir_nonaktif'   => null,
            ]);

        // Bersihkan pengajuan kadaluarsa
        Peminjaman::where('status_peminjaman', 'pengajuan')
            ->whereDate('tgl_peminjaman', '<', Carbon::today())
            ->delete();

        $labs = Lab::orderBy('nama_lab', 'asc')->get();
        $namaHariSekarang = now()->locale('id')->isoFormat('dddd');

        $hari = Hari::where('nama_hari', ucfirst($namaHariSekarang))->first()
            ?? abort(404, 'Hari tidak ditemukan');

        $currentTime = now()->format('H:i:s');

        // Sesi saat ini
        $currentSesi = SesiJam::where('jam_mulai', '<=', $currentTime)
            ->where('jam_selesai', '>=', $currentTime)
            ->first();

        foreach ($labs as $lab) {

            //STATUS DEFAULT
            $lab->status = $lab->status_lab === 'nonaktif' ? 'Nonaktif' : 'Kosong';
            if ($lab->status === 'Nonaktif' || !$currentSesi) {
                continue;
            }

            //DIPINJAM
            $isDipinjam =
                PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari) {
                    $q->where('id_lab',  $lab->id_lab)
                        ->where('id_hari', $hari->id_hari);
                })->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'dipinjam')
                        ->whereDate('tgl_peminjaman', today());
                })->exists()

                ||

                PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'dipinjam')
                        ->whereDate('tgl_peminjaman', today());
                })->exists();

            //PENGAJUAN
            $isDiajukan =
                PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari, $currentSesi) {
                    $q->where('id_lab',  $lab->id_lab)
                        ->where('id_hari', $hari->id_hari)
                        ->whereHas('sesiJam', function ($q2) use ($currentSesi) {
                            $q2->where('sesi_jam.id_sesi_jam', $currentSesi->id_sesi_jam);
                        });
                })->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'pengajuan')
                        ->whereDate('tgl_peminjaman', today());
                })->exists()

                ||

                PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'pengajuan')
                        ->whereDate('tgl_peminjaman', today());
                })->where('id_sesi_mulai', '<=', $currentSesi->id_sesi_jam)
                ->where('id_sesi_selesai', '>=', $currentSesi->id_sesi_jam)
                ->exists();

            //ADA JADWAL AKTIF TANPA PEMINJAMAN (TERSEDIA)
            $hasJadwal = JadwalLab::where('id_lab', $lab->id_lab)
                ->where('id_hari', $hari->id_hari)
                ->where('status_jadwalLab', 'aktif')
                ->whereHas('sesiJam', function ($q) use ($currentSesi) {
                    if ($currentSesi) {
                        $q->where('sesi_jam.id_sesi_jam', $currentSesi->id_sesi_jam);
                    }
                })->exists();

            //TENTUKAN STATUS
            if ($isDipinjam) {
                $lab->status = 'Dipinjam';
            } elseif ($isDiajukan) {
                $lab->status = 'Pengajuan';
            } elseif ($hasJadwal) {
                $lab->status = 'Tersedia';
            }

            // DATA PEMINJAMAN AKTIF (modal) 
            $lab->peminjamanAktif = PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari, $currentSesi) {
                $q->where('id_lab',  $lab->id_lab)
                    ->where('id_hari', $hari->id_hari)
                    ->whereHas('sesiJam', function ($q2) use ($currentSesi) {
                        $q2->where('sesi_jam.id_sesi_jam', $currentSesi->id_sesi_jam);
                    });
            })->whereHas('peminjaman', function ($q) {
                $q->whereIn('status_peminjaman', ['pengajuan', 'dipinjam'])
                    ->whereDate('tgl_peminjaman', today());
            })->with([
                'peminjaman.user.mahasiswa.prodi',
                'peminjaman.user.mahasiswa.kelas',
            ])->get();

            $lab->peminjamanManualAktif = PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereHas('peminjaman', function ($q) {
                    $q->whereIn('status_peminjaman', ['pengajuan', 'dipinjam'])
                        ->whereDate('tgl_peminjaman', today());
                })->where('id_sesi_mulai', '<=', $currentSesi->id_sesi_jam)
                ->where('id_sesi_selesai', '>=', $currentSesi->id_sesi_jam)
                ->with([
                    'peminjaman.user.mahasiswa.prodi',
                    'peminjaman.user.mahasiswa.kelas',
                ])->get();
        }

        return view('web.dashboard.index', compact('labs'));
    }
}
