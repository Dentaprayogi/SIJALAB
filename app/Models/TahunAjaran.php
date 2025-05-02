<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran'; // Nama tabel di database
    protected $primaryKey = 'id_tahunAjaran'; // Primary key
    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'status_tahunAjaran'
    ];

    // Relasi ke Tahun Ajaran (One to Many)
    public function jadwalLab()
    {
        return $this->hashMany(JadwalLab::class, 'id_tahunAjaran');
    }

}
