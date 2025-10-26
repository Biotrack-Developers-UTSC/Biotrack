<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest; // Usa este objeto para autenticar
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Este método autentica, valida y maneja errores.

        $request->session()->regenerate();

        // 2. RECUPERAMOS el usuario autenticado para la lógica de roles.
        $user = Auth::user();

        // 3. Lógica de Redirección Inteligente BASADA EN EL ROL
        if ($user) {
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            if ($user->role === 'guardaparque') {
                return redirect()->intended(route('guardaparque.dashboard'));
            }
        }

        // Redirección por defecto para usuarios sin rol específico (e.g., 'user')
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}