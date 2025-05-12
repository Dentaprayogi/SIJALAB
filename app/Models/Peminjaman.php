<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = [
        'tgl_peminjaman',
        'id',
        'status_peminjaman',
    ];

    // Relasi ke User (One to Many)
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    // Relasi ke Peralatan (Many to Many)
    public function peralatan()
    {
        return $this->belongsToMany(Peralatan::class, 'peminjaman_peralatan', 'id_peminjaman', 'id_peralatan');
    }

    // Relasi ke Peminjaman Selesai (One to One)
    public function peminjamanSelesai()
    {
        return $this->hasOne(PeminjamanSelesai::class, 'id_peminjaman');
    }

    // Relasi ke Peminjaman Bermasalah (One to One)
    public function peminjamanBermasalah()
    {
        return $this->hasOne(PeminjamanBermasalah::class, 'id_peminjaman');
    }

    // Relasi ke Peminjaman Jadwal (One to One)
    public function peminjamanJadwal()
    {
        return $this->hasOne(PeminjamanJadwal::class, 'id_peminjaman');
    }

    // Relasi ke Peminjaman Manual (One to One)
    public function peminjamanManual()
    {
        return $this->hasOne(PeminjamanManual::class, 'id_peminjaman');
    }

    // Relasi ke Peminjaman Ditolak (One to One)
    public function peminjamanDitolak()
    {
        return $this->hasOne(PeminjamanDitolak::class, 'id_peminjaman');
    }

    public function jadwalLab()
    {
        return $this->hasOneThrough(
            JadwalLab::class,
            PeminjamanJadwal::class,
            'id_peminjaman', // Foreign key on PeminjamanJadwal
            'id_jadwalLab',  // Foreign key on JadwalLab
            'id_peminjaman', // Local key on Peminjaman
            'id_jadwalLab'   // Local key on PeminjamanJadwal
        );
    }
}
