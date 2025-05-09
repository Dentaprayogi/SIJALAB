<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PeminjamanExport implements FromView
{
    public function view(): View
    {
        $query = Peminjaman::with([
            'user',
            'peralatan',
            'peminjamanManual.lab',
            'peminjamanJadwal.jadwalLab.lab'
        ]);

        // Tambahkan filter jika perlu
        if (request()->has('bulan') && request('bulan')) {
            $query->whereMonth('tgl_peminjaman', request('bulan'));
        }

        if (request()->has('tahun') && request('tahun')) {
            $query->whereYear('tgl_peminjaman', request('tahun'));
        }

        return view('web.peminjaman.exports.peminjaman', [
            'peminjamans' => $query->latest()->get()
        ]);
    }
}

