<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\TahunAjaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'checkStatus',
])->group(function () {
    route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    //Route Tahun Ajaran
    Route::resource('tahunajaran', TahunAjaranController::class)->parameters([
        'tahunajaran' => 'tahunAjaran'
    ]);

    //Route Peralatan
    Route::resource('peralatan', PeralatanController::class);

    //Route Prodi
    Route::resource('prodi', ProdiController::class);

    //Route Kelas
    Route::resource('kelas', KelasController::class);

});
