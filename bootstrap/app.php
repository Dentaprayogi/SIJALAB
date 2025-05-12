<?php

use App\Livewire\Profile\UpdateMahasiswaForm;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Livewire\Livewire;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'checkStatus' => \App\Http\Middleware\CheckUserStatus::class,
            'checkRole' => \App\Http\Middleware\CheckRoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

Livewire::component('profile.update-mahasiswa-form', UpdateMahasiswaForm::class);

return $app;
