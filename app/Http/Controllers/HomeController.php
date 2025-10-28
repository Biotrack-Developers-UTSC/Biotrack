<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Muestra la página de bienvenida única (/welcome) y adapta la vista.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Renombramos la vista a 'welcome'
        return view('welcome', compact('user'));
    }
}