<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanSelesai extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_selesai';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'id_peminjaman',
        'tgl_pengembalian', 
        'jam_dikembalikan'
    ];

    // Relasi ke Peminjaman (One to One)
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}
