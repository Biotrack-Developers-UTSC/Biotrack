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
use App\Http\Controllers\ScanController; // Controlador de QR Router

/*
|--------------------------------------------------------------------------
| 1. Rutas PÚBLICAS y de Autenticación
|--------------------------------------------------------------------------
*/

// Página de Inicio PÚBLICA (Muestra el index.blade.php)
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

  // RUTA DE BIENVENIDA
  Route::get('/welcome', [HomeController::class, 'index'])->name('welcome');

  // 🌟 RUTA DEL JUEGO (Accesible por todos los autenticados)
  Route::get('/juegos/futbol', function () {
    return view('futbol_gamepage');
  })->name('juegos.futbol');


  // 🌟 RUTA DE ESCANEO DE CÓDIGO QR (Router de Entidades)
  Route::get('/scan/{qrCodeData}', [ScanController::class, 'scan'])->name('qr.scan');

  // **Ruta de Interfaz de la Cámara** (Destino del botón "Escanear QR")
  Route::get('/qr/scanner/ui', function () {
    return view('qr.scanner_ui');
  })->name('qr.scanner.ui');


  // Ruta de consulta de ficha de animal por ID (Destino del ScanController)
  Route::get('/animales/ficha/{animal}', [AnimalController::class, 'show'])->name('animales.ficha');

  // A. USUARIO REGULAR (user): Consultas de animales (Acceso general)
  Route::get('/consultas/animales', [ConsultaController::class, 'index'])
    ->middleware('role:user|guardaparque|admin')
    ->name('consultas.animales');

  // B. GUARDAPARQUES (guardaparque): Dashboard, CRUD de Animales y Alertas
  Route::middleware('role:guardaparque|admin')->group(function () {
    Route::get('/dashboard/gestion', [GuardaparquesController::class, 'dashboard'])->name('guardaparques.dashboard');

    Route::resource('animales', AnimalController::class)->except(['show']);
    Route::resource('alertas', AlertaController::class);
  });

  // C. ADMINISTRADOR (admin): Gestión de Usuarios y Configuración
  Route::middleware('role:admin')->group(function () {
    Route::get('/dashboard/administracion', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('administracion/usuarios', UserController::class)->names('administracion.usuarios');
    Route::get('/configuracion', [AdminController::class, 'config'])->name('admin.config');
  });

});