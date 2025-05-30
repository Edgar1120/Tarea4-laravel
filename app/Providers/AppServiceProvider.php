<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        //
    }
 
   
    public function boot(): void
    {
        // Fuerza siempre HTTPS en producción
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Vite::prefetch(concurrency: 3);
    }
}
