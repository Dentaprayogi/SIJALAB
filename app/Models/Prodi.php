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
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_prodi');
    }

    public function matakuliah()
    {
        return $this->hasMany(Matakuliah::class, 'id_prodi');
    }
}
