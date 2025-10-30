<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class GuardaparquesController extends Controller
{
    /**
     * Muestra el dashboard principal para el Guardaparque.
     * Sirve la vista guardaparques.dashboard.blade.php
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        // Nota: Si necesitas datos para las pestañas de @include, los pasarías aquí.

        return view('guardaparques.dashboard', compact('user'));
    }
}