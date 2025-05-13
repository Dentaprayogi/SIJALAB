<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hari;
use App\Models\Lab;
use App\Models\JadwalLab;           // <<< tambahkan ini
use App\Models\PeminjamanJadwal;
use App\Models\PeminjamanManual;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $labs = Lab::orderBy('nama_lab', 'asc')->get();
        $namaHariSekarang = now()->locale('id')->isoFormat('dddd'); // Senin, Selasa, dst

        $hari = Hari::where('nama_hari', ucfirst($namaHariSekarang))->first()
            ?? abort(404, 'Hari tidak ditemukan');

        $currentTime = now()->format('H:i:s');

        foreach ($labs as $lab) {
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

        return view('web.dashboard.dashboard', compact('labs'));
    }
}
