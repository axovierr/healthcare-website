<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPatientProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isPatient()) {
            $patient = auth()->user()->patient;
            
            // Cek apakah profil sudah lengkap
            if (!$patient || !$patient->gender || !$patient->birth_date || !$patient->golongan_darah || !$patient->address) {
                // Jika sedang mengakses halaman complete profile, izinkan
                if ($request->routeIs('patient.profile.complete') || $request->routeIs('patient.profile.store')) {
                    return $next($request);
                }
                
                // Redirect ke halaman lengkapi profil dengan pesan
                return redirect()->route('patient.profile.complete')
                    ->with('warning', 'Mohon lengkapi profil Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}