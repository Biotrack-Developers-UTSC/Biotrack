<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class GuardaparquesController extends Controller
{
    /**
     * Muestra el dashboard principal para el Guardaparque.
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        // Aquí se pueden cargar datos como conteo de alertas activas o registros de la semana.

        return view('guardaparques.dashboard', compact('user'));
    }
}
