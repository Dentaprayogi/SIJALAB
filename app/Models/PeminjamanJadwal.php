<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanJadwal extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_jadwal';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'id_peminjaman',
        'id_jadwalLab'
    ];

    // Relasi ke Peminjaman Peminjaman (One to One)
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    // Relasi ke Jadwal Lab (One to Many)
    public function jadwalLab()
    {
        return $this->belongsTo(JadwalLab::class, 'id_jadwalLab');
    }
}
