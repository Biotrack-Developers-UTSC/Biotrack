<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider; // 🌟 USAMOS RouteServiceProvider
use Illuminate\Support\Facades\Route; // Necesario para la Facade Route

class AppServiceProvider extends ServiceProvider
{
    /**
     * La ruta a la ruta "home" de tu aplicación.
     * Utilizada por el framework para redirigir después de la autenticación.
     */
    public const HOME = '/dashboard'; // Mantenemos la constante HOME aquí

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Se deja vacío por defecto si no hay servicios que registrar.
    }

    /**
     * Define tus enlaces de modelo de ruta, filtros de patrones y otras configuraciones de ruta.
     */
    public function boot(): void
    {
        // 🌟 PASO 1: REGISTRO DEL MIDDLEWARE DE ROL AQUÍ
        Route::aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);

        // El Middleware 'verified' de Laravel también requiere estar registrado si no hay Kernel.php
        Route::aliasMiddleware('verified', \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class);

        // 🌟 PASO 2: Definición de rutas (Cambiado de $this->routes() a la función anónima)
        $this->routes(function () {
            // Rutas API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Rutas Web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}