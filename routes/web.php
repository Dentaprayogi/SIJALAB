<?php

use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use App\Models\Kelas;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/get-kelas/{id_prodi}', function ($id_prodi) {
    return response()->json(
        Kelas::where('id_prodi', $id_prodi)->get()
    );
});

Route::get('/register', [CustomRegisterController::class, 'create'])->name('register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'checkStatus',
])->group(function () {
    route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', function () {
        return view('web.profile.show');
    })->name('user.profile'); 

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

    //Route Matakuliah
    Route::resource('matakuliah', MatakuliahController::class);

    //Route Dosen
    Route::resource('dosen', DosenController::class);

    //Route Manajemen Users
    Route::resource('users', UserController::class);
    Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');


});
