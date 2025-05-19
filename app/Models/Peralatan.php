<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    use HasFactory;

    protected $table = 'peralatan';
    protected $primaryKey = 'id_peralatan';
    protected $fillable = [
        'nama_peralatan'
    ];

    //Relasi ke Peminjaman (Many to Many)
    public function peminjaman()
    {
        return $this->belongsToMany(Peminjaman::class, 'peminjaman_peralatan', 'id_peralatan', 'id_peminjaman');
    }

    //Relasi ke Unit Peralatan (Many to one)
    public function unitPeralatan()
    {
        return $this->hasMany(UnitPeralatan::class, 'id_peralatan');
    }
}
