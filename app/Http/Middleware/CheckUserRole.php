<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->status_user !== 'aktif') {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Akun Anda dinonaktifkan. Hubungi Teknisi.']);
        }

        if (Auth::check() && Auth::user()->role !== $role) {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
