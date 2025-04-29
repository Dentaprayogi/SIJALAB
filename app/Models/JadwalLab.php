<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalLab extends Model
{
    use HasFactory;

    protected $table = 'jadwal_lab';
    protected $primaryKey = 'id_jadwalLab';

    protected $fillable = [
        'id_hari',
        'id_lab',
        'jam_mulai',
        'jam_selesai',
        'id_mk',
        'id_dosen',
        'id_prodi',
        'id_kelas',
        'id_tahunAjaran',
        'status_jadwalLab',
    ];

    // format jam mulai dan jam berakhir H:i
    public function getRentangJamAttribute()
    {
        return \Carbon\Carbon::parse($this->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($this->jam_selesai)->format('H:i');
    }    

    // Relasi ke Hari
    public function hari()
    {
        return $this->belongsTo(Hari::class, 'id_hari');
    }

    // Relasi ke Lab
    public function lab()
    {
        return $this->belongsTo(Lab::class, 'id_lab');
    }

    // Relasi ke Mata Kuliah
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'id_mk');
    }

    // Relasi ke Dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen');
    }

    // Relasi ke Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    // Relasi ke Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    // Relasi ke Tahun Ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahunAjaran');
    }
}
