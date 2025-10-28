<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Verifica que el usuario autenticado tenga al menos uno de los roles requeridos.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = $request->user();
        $roles = explode('|', $role);

        // Si el rol del usuario NO está en la lista de roles permitidos
        if (!in_array($user->role, $roles)) {
            // Redirigir a la página de bienvenida segura
            return redirect('/welcome')->with('error', 'Acceso no autorizado a esta sección.');
        }

        return $next($request);
    }
}