<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Animal;
use App\Models\Alerta;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Datos dinámicos para las tarjetas de estadísticas
        $stats = [
            'usuarios' => User::count(),
            'especies' => Animal::count(),
            'alertas' => Alerta::where('estado', 'Nueva')->count(),
        ];

        return view('welcome', compact('user', 'stats'));
    }
}
