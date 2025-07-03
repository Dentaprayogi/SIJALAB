<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;     // ganti sesuai model
use Carbon\Carbon;

class HapusPeminjamanKedaluwarsa extends Command
{
    protected $signature   = 'peminjaman:hapus-expired';
    protected $description = 'Hapus pengajuan peminjaman yang lewat tanggal.';

    public function handle(): int
    {
        $today   = Carbon::today();
        $deleted = Peminjaman::where('status_peminjaman', 'pengajuan')
            ->whereDate('tgl_peminjaman', '<', $today)
            ->delete();

        $this->info("{$deleted} pengajuan kedaluwarsa dihapus.");
        return Command::SUCCESS;
    }
}
