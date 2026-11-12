<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AdminMiddleware
 * Membatasi hak akses rute tertentu agar hanya dapat dijalankan oleh user dengan role 'admin'.
 */
class AdminMiddleware
{
    /**
     * Memeriksa status login dan role pengguna sebelum memproses request ke rute admin.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('barang.index')
                ->with('error', 'Akses ditolak! Fitur ini hanya dapat diakses oleh Administrator.');
        }

        return $next($request);
    }
}
