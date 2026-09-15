<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS di production
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // Aturan kekuatan password default untuk SELURUH aplikasi (dipakai lewat Password::defaults()).
        // Minimal 8 karakter, wajib ada huruf besar+kecil, angka, dan simbol.
        Password::defaults(function () {
            return Password::min(8)->mixedCase()->numbers()->symbols();
        });
    }
}
