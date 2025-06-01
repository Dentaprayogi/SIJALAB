<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitPeralatan extends Model
{
    use HasFactory;

    protected $table = 'unit_peralatan';
    protected $primaryKey = 'id_unit';

    protected $fillable = [
        'id_peralatan',
        'kode_unit',
        'status_unit'
    ];

    // Relasi ke Peralatan (Many to One)
    public function peralatan()
    {
        return $this->belongsTo(Peralatan::class, 'id_peralatan');
    }

    // Relasi ke Peminjaman (Many to Many melalui tabel pivot peminjaman_unit)
    public function peminjaman()
    {
        return $this->belongsToMany(Peminjaman::class, 'peminjaman_unit', 'id_unit', 'id_peminjaman');
    }
}
