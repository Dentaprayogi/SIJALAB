<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiJam extends Model
{
    use HasFactory;

    protected $table = 'sesi_jam';
    protected $primaryKey = 'id_sesi_jam';

    protected $fillable = [
        'nama_sesi',
        'jam_mulai',
        'jam_selesai',
    ];

    /**
     * Relasi many-to-many ke jadwal_lab.
     */
    public function jadwalLab()
    {
        return $this->belongsToMany(JadwalLab::class, 'jadwal_lab_sesi_jam', 'id_sesi_jam', 'id_jadwalLab');
    }
}
