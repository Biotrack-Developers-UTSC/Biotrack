<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuardaparquesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ScanController;

/*
|--------------------------------------------------------------------------
| 1. Rutas PÚBLICAS y de Autenticación
|--------------------------------------------------------------------------
*/

// Página de Inicio PÚBLICA
Route::get('/', function () {
  if (Auth::check()) {
    return redirect()->route('welcome');
  }
  return view('index');
})->name('index');

// Rutas de Login y Registro 
Route::middleware('guest')->group(function () {
  Route::get('register', fn() => view('auth.register'))->name('register');
  Route::post('register', [RegisteredUserController::class, 'store'])->name('register.post');

  Route::get('login', fn() => view('auth.login'))->name('login');
  Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
});

// Cerrar Sesión
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
  ->middleware('auth')
  ->name('logout');

/*
|--------------------------------------------------------------------------
| 2. RUTA CENTRAL DE BIENVENIDA POST-LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

  // Bienvenida
  Route::get('/welcome', [HomeController::class, 'index'])->name('welcome');

  // Juego
  Route::get('/juegos/futbol', fn() => view('futbol_gamepage'))->name('juegos.futbol');

  // Escaneo de QR (disponible para cualquier usuario logueado)
  Route::get('/qr/scanner/ui', fn() => view('qr.scanner_ui'))
    ->name('qr.scanner.ui'); // Vista del escáner (cámara o lector USB)

  Route::get('/scan/{qrCodeData}', [ScanController::class, 'scan'])
    ->name('qr.scan'); // Procesa el código leído

  // Ficha pública de animales
  Route::get('/animales/ficha/{animal}', [AnimalController::class, 'ficha_publica'])->name('animales.ficha_publica');

  // Consultas de animales (acceso general)
  Route::get('/consultas/animales', [ConsultaController::class, 'index'])
    ->middleware('auth') // cualquier usuario autenticado
    ->name('consultas.index');

  // Guardaparques y Admin
  Route::middleware('role:guardaparque|admin')->group(function () {
    Route::get('/dashboard/gestion', [GuardaparquesController::class, 'dashboard'])->name('guardaparques.dashboard');

    // ✅ Ajuste clave aquí:
    Route::resource('animales', AnimalController::class)->parameters([
      'animales' => 'animal'
    ]);

    // ✅ Ajuste clave aquí:
    Route::resource('alertas', AlertaController::class)->parameters([
      'alertas' => 'alerta'
    ]);
  });

  // Admin
  Route::middleware('role:admin')->group(function () {
    Route::get('/dashboard/administracion', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('administracion/usuarios', UserController::class)->names('administracion.usuarios');
    Route::get('/configuracion', [AdminController::class, 'config'])->name('admin.config');
  });
});
