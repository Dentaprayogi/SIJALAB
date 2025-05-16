<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $table = 'lab';  // Menentukan nama tabel
    protected $primaryKey = 'id_lab';  // Menentukan primary key
    protected $fillable = [
        'nama_lab',
        'status_lab',
    ];

    // Relasi ke Jadwal Lab (Many to One)
    public function jadwalLab()
    {
        return $this->hasMany(JadwalLab::class, 'id_lab');
    }

    // Relasi ke Peminjaman Manual (Many to One)
    public function peminjamanManual()
    {
        return $this->hasMany(PeminjamanManual::class, 'id_lab');
    }

    // Relasi ke Peminjaman Jadwal (Many to One)
    public function peminjamanJadwal()
    {
        return $this->hasMany(PeminjamanJadwal::class, 'id_lab');
    }
}
