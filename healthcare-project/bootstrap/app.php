<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // // PENTING: Tambahkan ini untuk mengubah redirect default
    // ->withRedirects([
    //     'home' => '/', // Mengarahkan user yang login ke halaman utama ('/') atau ubah ke /patient/dashboard
    // ])
    ->withMiddleware(function (Middleware $middleware): void {
            $middleware->alias([
            // Tambahkan alias ini:
            'role' => CheckRole::class, 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
