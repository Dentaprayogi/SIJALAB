<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    protected $table = 'peralatan';
    protected $primaryKey = 'id_peralatan';
    protected $fillable = [
        'nama_peralatan'
    ];
}
