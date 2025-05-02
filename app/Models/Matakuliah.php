<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah';
    protected $primaryKey = 'id_mk';

    protected $fillable = [
        'nama_mk',
        'id_prodi',
    ];

    //Relasi ke Prodi (One to Many)
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }
}

