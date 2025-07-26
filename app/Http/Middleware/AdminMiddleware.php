<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login dan email adalah admin@email.com
        if (Auth::check() && Auth::user()->email === 'admin@email.com') {
            return $next($request);
        }

        // Jika bukan admin, redirect ke home dengan pesan error
        return redirect()->route('home')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
    }
}