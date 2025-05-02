<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $fillable = [
        'id_prodi', 
        'nama_kelas'
    ];

    //Relasi ke Prodi (One to Many)
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    //Relasi ke Mahasiswa (Many to One)
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'id_kelas');
    }
}
