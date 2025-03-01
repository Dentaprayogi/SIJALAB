<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user(); // Ambil user yang sedang login
        if ($user && $user->status_user !== 'aktif') {
            // Proses logout untuk user dengan status tidak aktif
            if (Auth::guard('web')->check()) {
                Auth::guard('web')->logout(); // Gunakan guard `web` untuk logout
            }
    
            // Redirect kembali ke halaman login dengan pesan error
            return redirect('/login')->withErrors([
                'email' => 'Akun Anda tidak aktif. Hubungi Teknisi untuk informasi lebih lanjut.',
            ]);
        }
    
        return $next($request);
    }
    
}
