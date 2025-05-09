<?php

use App\Exports\PeminjamanExport;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalLabController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use App\Models\Kelas;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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
    Route::patch('/tahun-ajaran/{id_tahunAjaran}/toggle-status', [TahunAjaranController::class, 'toggleStatus']);


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

    //Route Manajemen Lab
    Route::resource('lab', LabController::class);
    Route::patch('/lab/{id_lab}/toggle-status', [LabController::class, 'toggleStatus']);


    //Route Jadwal Lab
    Route::resource('jadwal_lab', JadwalLabController::class);
    Route::patch('/jadwal-lab/{id_jadwalLab}/toggle-status', [JadwalLabController::class, 'toggleStatus'])->name('jadwal-lab.toggle-status');
    Route::get('/get-dependent-data/{id}', [JadwalLabController::class, 'getData']);
    Route::delete('/jadwal-lab/bulk-delete', [JadwalLabController::class, 'bulkDelete'])->name('jadwal_lab.bulkDelete');

    //Route Peminjaman
    Route::prefix('peminjaman')->middleware('auth')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/jadwal/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/jadwal/store', [PeminjamanController::class, 'storeJadwal'])->name('peminjaman.storeJadwal');
        Route::post('/manual/store', [PeminjamanController::class, 'storeManual'])->name('peminjaman.storeManual');
        Route::get('/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::delete('/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
        Route::put('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
        Route::put('/peminjaman/{id}/selesai', [PeminjamanController::class, 'selesai'])->name('peminjaman.selesai');
        Route::put('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        Route::delete('/peminjaman/bulk-delete', [PeminjamanController::class, 'bulkDelete'])->name('peminjaman.bulkDelete');

        Route::get('/peminjaman/export', function () {
            return Excel::download(new PeminjamanExport, 'peminjaman.xlsx');
        })->name('peminjaman.export');

    });
    

});
