<?php

namespace App\Services;

use App\Models\Peminjaman;
use App\Models\PeminjamanDitolak;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PeminjamanService
{
    public static function tolakPeminjamanExpired(): int
    {
        $now = Carbon::now();
        $alasan = 'Pengajuan ditolak karena peminjam tidak hadir di ruang teknis hingga sesi berakhir untuk proses verifikasi';
        $jumlahDitolak = 0;

        $peminjamans = Peminjaman::with(['peminjamanJadwal.jadwalLab.sesiJam', 'peminjamanManual.sesiSelesai'])
            ->where('status_peminjaman', 'pengajuan')
            ->get();

        foreach ($peminjamans as $peminjaman) {
            $harusDitolak = false;

            if ($pj = $peminjaman->peminjamanJadwal?->jadwalLab) {
                $lastSesi = $pj->sesiJam->sortByDesc('jam_selesai')->first();
                if ($lastSesi && Carbon::parse($peminjaman->tgl_peminjaman . ' ' . $lastSesi->jam_selesai)->lt($now)) {
                    $harusDitolak = true;
                }
            }

            if ($pm = $peminjaman->peminjamanManual) {
                if ($pm->sesiSelesai && Carbon::parse($peminjaman->tgl_peminjaman . ' ' . $pm->sesiSelesai->jam_selesai)->lt($now)) {
                    $harusDitolak = true;
                }
            }

            if ($harusDitolak) {
                DB::transaction(function () use ($peminjaman, $alasan, &$jumlahDitolak) {
                    $peminjaman->update(['status_peminjaman' => 'ditolak']);
                    PeminjamanDitolak::create([
                        'id_peminjaman'   => $peminjaman->id_peminjaman,
                        'alasan_ditolak'  => $alasan,
                    ]);
                    $jumlahDitolak++;
                });
            }
        }

        return $jumlahDitolak;
    }
}
