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
    route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', function () {
        return view('web.profile.show');
    })->name('user.profile');

    // Route khusus untuk teknisi
    Route::group(['middleware' => 'checkRole:teknisi'], function () {
        //Route Manajemen Users
        Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::delete('/users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulkDelete');
        Route::resource('users', UserController::class);

        //Route Tahun Ajaran
        Route::patch('/tahun-ajaran/{id_tahunAjaran}/toggle-status', [TahunAjaranController::class, 'toggleStatus']);
        Route::resource('tahunajaran', TahunAjaranController::class)->parameters([
            'tahunajaran' => 'tahunAjaran'
        ]);;

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

        //Route Manajemen Lab
        Route::patch('/lab/{id_lab}/toggle-status', [LabController::class, 'toggleStatus']);
        Route::resource('lab', LabController::class);

        // Route Jadwal Lab
        Route::patch('/jadwal_lab/{id_jadwalLab}/toggle-status', [JadwalLabController::class, 'toggleStatus'])->name('jadwal_lab.toggle-status');
        Route::get('/jadwal_lab/create', [JadwalLabController::class, 'create'])->name('jadwal_lab.create');
        Route::post('/jadwal_lab', [JadwalLabController::class, 'store'])->name('jadwal_lab.store');
        Route::get('/jadwal_lab/{id_jadwalLab}/edit', [JadwalLabController::class, 'edit'])->name('jadwal_lab.edit');
        Route::put('/jadwal_lab/{id_jadwalLab}', [JadwalLabController::class, 'update'])->name('jadwal_lab.update');
        Route::get('/get-dependent-data/{id}', [JadwalLabController::class, 'getData']);
        Route::delete('/jadwal_lab/bulk-delete', [JadwalLabController::class, 'bulkDelete'])->name('jadwal_lab.bulkDelete');
        Route::delete('/jadwal_lab/{id_jadwalLab}', [JadwalLabController::class, 'destroy'])->name('jadwal_lab.destroy');

        // Route Peminjaman
        Route::prefix('peminjaman')->middleware('auth')->group(function () {
            Route::delete('/peminjaman/bulk-delete', [PeminjamanController::class, 'bulkDelete'])->name('peminjaman.bulkDelete');
            Route::put('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
            Route::put('/peminjaman/{id}/selesai', [PeminjamanController::class, 'selesai'])->name('peminjaman.selesai');
            Route::put('/peminjaman/{id}/bermasalah', [PeminjamanController::class, 'bermasalah'])->name('peminjaman.bermasalah');
            Route::put('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        });
    });


    // Route Umum
    // Route Jadwal Lab
    Route::get('/jadwal_lab', [JadwalLabController::class, 'index'])->name('jadwal_lab.index');

    //Route Peminjaman
    Route::prefix('peminjaman')->middleware('auth')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/jadwal/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/labs/available', [PeminjamanController::class, 'getAvailableLabs'])->name('labs.available');
        Route::post('/jadwal/store', [PeminjamanController::class, 'storeJadwal'])->name('peminjaman.storeJadwal');
        Route::post('/manual/store', [PeminjamanController::class, 'storeManual'])->name('peminjaman.storeManual');
        Route::get('/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::get('/peminjaman/export', function () {
            return Excel::download(new PeminjamanExport, 'peminjaman.xlsx');
        })->name('peminjaman.export');
        Route::delete('/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    });
});
