<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi'; // Nama tabel di database
    protected $primaryKey = 'id_prodi'; // Primary key
    protected $fillable = [
        'nama_prodi',
        'kode_prodi',
        'singkatan_prodi',
    ];

    //Relasi ke Kelas (Many to One)
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_prodi');
    }

    //Relasi ke Mata Kuliah (Many to One)
    public function matakuliah()
    {
        return $this->hasMany(Matakuliah::class, 'id_prodi');
    }

    //Relasi ke Dosen (Many to One)
    public function dosen()
    {
        return $this->hasMany(Matakuliah::class, 'id_prodi');
    }

    // Relasi ke Mahasiswa (Many to One)
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'id_prodi');
    }

    // Relasi ke Jadwal Lab (Many to One)
    public function jadwalLab()
    {
        return $this->hasMany(JadwalLab::class, 'id_prodi');
    }
}
