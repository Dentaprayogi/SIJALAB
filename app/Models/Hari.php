<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    use HasFactory;

    protected $table = 'hari';
    protected $primaryKey = 'id_hari';
    protected $fillable = ['nama_hari'];

    //Relasi ke Jadwal Lab (Many to One)
    public function jadwalLab()
    {
        return $this->hasMany(JadwalLab::class, 'id_hari');
    }
}
