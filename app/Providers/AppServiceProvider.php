<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Define la ruta a la que redirigir después de la autenticación.
     */
    public const HOME = '/welcome';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Se deja vacío por defecto si no hay servicios que registrar.
    }

    /**
     * Define tus enlaces de modelo de ruta y configuraciones de ruta.
     */
    public function boot(): void
    {
        if (str_contains(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        // Registro del Middleware de Rol y Verified (Necesario para el web.php)
        Route::aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
        Route::aliasMiddleware('verified', \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class);

        // Rutas
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}