<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidatePurchaseAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah request berasal dari tombol "Buy Now"
        if ($request->method() === 'GET') {
            // Untuk GET request, cek apakah ada parameter 'judul' dan 'from_button'
            if (!$request->has('judul') || !$request->has('from_button')) {
                return redirect()->route('movie')->with('error', 'Akses tidak sah. Silakan beli tiket melalui halaman film.');
            }
        }
        
        // Untuk POST request, cek apakah session memiliki flag valid
        if ($request->method() === 'POST') {
            if (!session('purchase_access_granted')) {
                return redirect()->route('movie')->with('error', 'Akses tidak sah. Silakan mulai dari halaman film.');
            }
        }

        return $next($request);
    }
}