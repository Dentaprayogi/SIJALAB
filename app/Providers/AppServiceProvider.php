<?php

namespace App\Providers;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (env('TELESCOPE_ENABLED', false)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa root URL sesuai APP_URL agar asset (Livewire, dll) bekerja di subfolder
        if (config('app.url')) {
            URL::forceRootUrl(config('app.url'));
        }

        // Set locale Carbon agar nama hari/bulan dalam Bahasa Indonesia
        Carbon::setLocale('id');

        // Notifikasi
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $notifikasi = Peminjaman::with('user')
                    ->where('status_peminjaman', 'pengajuan')
                    ->latest()
                    ->get();
                $view->with('notifikasi', $notifikasi);
            }
        });
    }
}
