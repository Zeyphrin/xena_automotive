<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN role-nya adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Jika ya, persilakan masuk ke rute yang dituju
            return $next($request);
        }

        // Jika bukan admin (atau belum login), tendang ke halaman utama dengan pesan error
        return redirect('/')->with('error', 'Akses ditolak. Halaman ini khusus untuk Administrator.');
    }
}