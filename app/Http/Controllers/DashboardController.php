<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hari;
use App\Models\Lab;
use App\Models\JadwalLab;
use App\Models\PeminjamanJadwal;
use App\Models\PeminjamanManual;
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

        foreach ($labs as $lab) {
            // Default status
            $lab->status = 'Kosong';

            // Cek jika lab dinonaktifkan
            if ($lab->status_lab === 'nonaktif') {
                $lab->status = 'Nonaktif';
                continue;
            }

            // Cek peminjaman dengan status "dipinjam"
            $isDipinjam =
                PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari, $currentTime) {
                    $q->where('id_lab', $lab->id_lab)
                        ->where('id_hari', $hari->id_hari)
                        ->where('jam_mulai', '<=', $currentTime)
                        ->where('jam_selesai', '>=', $currentTime);
                })->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'dipinjam')
                        ->whereDate('tgl_peminjaman', today());
                })->exists()
                ||
                PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereTime('jam_mulai', '<=', $currentTime)
                ->whereTime('jam_selesai', '>=', $currentTime)
                ->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'dipinjam')
                        ->whereDate('tgl_peminjaman', today());
                })->exists();

            // Cek peminjaman dengan status "pengajuan"
            $isDiajukan =
                PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari, $currentTime) {
                    $q->where('id_lab', $lab->id_lab)
                        ->where('id_hari', $hari->id_hari)
                        ->where('jam_mulai', '<=', $currentTime)
                        ->where('jam_selesai', '>=', $currentTime);
                })->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'pengajuan')
                        ->whereDate('tgl_peminjaman', today());
                })->exists()
                ||
                PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereTime('jam_mulai', '<=', $currentTime)
                ->whereTime('jam_selesai', '>=', $currentTime)
                ->whereHas('peminjaman', function ($q) {
                    $q->where('status_peminjaman', 'pengajuan')
                        ->whereDate('tgl_peminjaman', today());
                })->exists();

            // Cek apakah ada jadwal aktif (tanpa peminjaman)
            $hasJadwal = JadwalLab::where('id_lab', $lab->id_lab)
                ->where('id_hari', $hari->id_hari)
                ->where('status_jadwalLab', 'aktif')
                ->where('jam_mulai', '<=', $currentTime)
                ->where('jam_selesai', '>=', $currentTime)
                ->exists();

            // Set status lab
            if ($isDipinjam) {
                $lab->status = 'Dipinjam';
            } elseif ($isDiajukan) {
                $lab->status = 'Pengajuan';
            } elseif ($hasJadwal) {
                $lab->status = 'Tersedia';
            }

            // Ambil data peminjaman aktif (pengajuan/dipinjam) untuk ditampilkan di modal
            $lab->peminjamanAktif = PeminjamanJadwal::whereHas('jadwalLab', function ($q) use ($lab, $hari, $currentTime) {
                $q->where('id_lab', $lab->id_lab)
                    ->where('id_hari', $hari->id_hari)
                    ->where('jam_mulai', '<=', $currentTime)
                    ->where('jam_selesai', '>=', $currentTime);
            })->whereHas('peminjaman', function ($q) {
                $q->whereIn('status_peminjaman', ['pengajuan', 'dipinjam'])
                    ->whereDate('tgl_peminjaman', today());
            })->with([
                'peminjaman.user.mahasiswa.prodi',
                'peminjaman.user.mahasiswa.kelas',
            ])->get();

            $lab->peminjamanManualAktif = PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereTime('jam_mulai', '<=', $currentTime)
                ->whereTime('jam_selesai', '>=', $currentTime)
                ->whereHas('peminjaman', function ($q) {
                    $q->whereIn('status_peminjaman', ['pengajuan', 'dipinjam'])
                        ->whereDate('tgl_peminjaman', today());
                })->with([
                    'peminjaman.user.mahasiswa.prodi',
                    'peminjaman.user.mahasiswa.kelas',
                ])->get();
        }

        return view('web.dashboard.index', compact('labs'));
    }
}
