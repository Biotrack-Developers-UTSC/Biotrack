<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Alerta;
use App\Models\Animal;
use Illuminate\Support\Facades\Auth;

class GuardaparquesController extends Controller
{
    /**
     * Muestra el dashboard principal para el Guardaparque.
     * Sirve la vista guardaparques.dashboard.blade.php
     */
    /** Dashboard principal de guardaparques */
    public function dashboard(): View
    {
        // Traer alertas más recientes
        $alertas = Alerta::orderBy('created_at', 'desc')->paginate(15);

        // Traer contadores o estadísticas para el dashboard
        $totalAnimales = Animal::count();
        $alertasActivas = Alerta::where('estado', 'Nueva')->count();
        $totalSensores = 5; // O calcular según tu sistema

        return view('guardaparques.dashboard', compact(
            'alertas',
            'totalAnimales',
            'alertasActivas',
            'totalSensores'
        ));
    }
}