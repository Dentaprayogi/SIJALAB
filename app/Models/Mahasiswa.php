<?php

// app/Models/Mahasiswa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'id',
        'id_prodi',
        'id_kelas',
        'nim',
        'telepon',
        'foto_ktm',
    ];

    // Relasi ke User (One to One)
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    // Relasi ke Prodi (One to One)
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    // Relasi ke Kelas (One to One)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
