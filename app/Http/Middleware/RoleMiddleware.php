<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. SI EL USUARIO NO ESTÁ LOGUEADO, redirigir al login (Middleware 'auth' ya hace esto, pero lo mantenemos por seguridad)
        if (!Auth::check()) {
            // Redirige al login para que se autentique
            return redirect('/login');
        }

        // 2. SI EL USUARIO ESTÁ LOGUEADO PERO NO TIENE EL ROL CORRECTO
        $roles = explode('|', $role);

        if (!in_array($request->user()->role, $roles)) {
            // Redirige al dashboard general (página segura para ese usuario)
            return redirect('/dashboard')->with('error', 'Acceso no autorizado a esta sección.');
        }

        return $next($request);
    }
}