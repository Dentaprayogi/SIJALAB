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
}
