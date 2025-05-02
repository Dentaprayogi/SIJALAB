<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDitolak extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_ditolak';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = [
        'alasan_ditolak'
    ];

    // Relasi ke Peminjaman (One to One)
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}
