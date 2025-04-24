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
        'fasilitas_lab',
        'kapasitas_lab',
        'status_lab',
    ];  
}
