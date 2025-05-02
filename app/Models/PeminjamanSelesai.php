<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanSelesai extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_selesai';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = [
        'tgl_pengembalian', 
        'jam_dikembaliakn'
    ];

    // Relasi ke Peminjaman (One to One)
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}
