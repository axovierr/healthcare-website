<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan untuk mengimpor Auth jika diperlukan
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (Auth::check() && Auth::user()->role && Auth::user()->role->name === $role) {
            return $next($request);
        }

        // Fail Secure: Alihkan jika akses ditolak (sesuai prinsip keamanan)
        abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk peran ini.');
    }
}
