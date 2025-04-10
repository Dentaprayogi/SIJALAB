<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Kelas;

class CustomRegisterController extends Controller
{
    public function create()
    {
        $prodiList = Prodi::all();
        $kelasList = Kelas::all();

        return view('auth.register', compact('prodiList', 'kelasList'));
    }
}
