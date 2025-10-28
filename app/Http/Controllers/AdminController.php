<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Muestra el dashboard principal para el Administrador.
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        // Cargar estadísticas generales de la aplicación y el sistema.

        return view('admin.dashboard', compact('user'));
    }

    /**
     * Muestra la vista de configuración avanzada del sistema (ej. logs, ajustes de mail).
     */
    public function config(): View
    {
        return view('admin.config');
    }
}
