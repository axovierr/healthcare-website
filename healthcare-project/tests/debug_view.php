<?php
try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $app->boot();
    
    echo view('auth.login')->render();
} catch (\Throwable $e) {
    file_put_contents('debug_error.log', "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString());
}
