<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (!$this->app->bound('files')) {
            $this->app->bind('files', \Illuminate\Filesystem\Filesystem::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS for URLs when behind proxy (ngrok) or in production
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' 
            || str_contains(config('app.url'), 'https://')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
