<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosen';
    protected $primaryKey = 'id_dosen';
    protected $fillable = [
        'nama_dosen',
        'telepon',
        'id_prodi',
    ];

    //Relasi ke Prodi (One to Many)
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    //Relasi ke Jadwal Lab (Many to One)
    public function jadwalLab()
    {
        return $this->hasMany(JadwalLab::class, 'id_dosen');
    }
}
