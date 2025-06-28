<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanManual extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_manual';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'id_peminjaman',
        'id_sesi_mulai',
        'id_sesi_selesai',
        'jam_mulai',
        'jam_selesai',
        'id_lab',
        'kegiatan'
    ];

    // Relasi ke Peminjaman (One to One)
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    // Relasi ke Lab (One to Many)
    public function lab()
    {
        return $this->belongsTo(Lab::class, 'id_lab');
    }

    public function sesiMulai()
    {
        return $this->belongsTo(SesiJam::class, 'id_sesi_mulai');
    }
    public function sesiSelesai()
    {
        return $this->belongsTo(SesiJam::class, 'id_sesi_selesai');
    }

    /* accessor rentang jam (H:i–H:i) */
    public function getRentangJamAttribute()
    {
        return $this->sesiMulai->jam_mulai . ' - ' . $this->sesiSelesai->jam_selesai;
    }
}
