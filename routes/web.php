<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Rutas para el Frontend (PWA - Vistas Públicas)
|--------------------------------------------------------------------------
*/

// Ruta de la Página de Inicio (Home Page/AppShell)
// Muestra: resources/views/index.blade.php
Route::get('/', function () {
  return view('index');
})->name('home');


/*
|--------------------------------------------------------------------------
| Rutas de Autenticación (Login & Registro)
|--------------------------------------------------------------------------
*/

// 1. Mostrar Formulario de Registro (GET /register)
// Muestra: resources/views/auth/register.blade.php
Route::get('/register', function () {
  return view('auth.register');
})->middleware('guest')->name('register');

// 2. Procesar Registro (POST /register)
// NOTA: Debes crear la lógica en el controlador para manejar el POST
Route::post('/register', [RegisteredUserController::class, 'store'])
  ->middleware('guest')
  ->name('register.post');


// 3. Mostrar Formulario de Login (GET /login)
// Muestra: resources/views/auth/login.blade.php
Route::get('/login', function () {
  return view('auth.login');
})->middleware('guest')->name('login');

// 4. Procesar Login (POST /login)
// NOTA: Debes crear la lógica en el controlador para manejar el POST
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
  ->middleware('guest')
  ->name('login.post');


// 5. Cerrar Sesión (POST /logout)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
  ->middleware('auth')
  ->name('logout');


/*
|--------------------------------------------------------------------------
| Rutas del Dashboard (AppShell - Protegidas)
|--------------------------------------------------------------------------
*/

// Dashboard General (Muestra si el usuario está autenticado y verificado)
Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); // <-- Todos van aquí por defecto

// Rutas de Verificación de Email (Estándar de Laravel)
Route::get('/email/verify', fn() => view('auth.verify-email'))
  ->middleware('auth')->name('verification.notice');

// 🌟 Rutas del Dashboard: Protegidas por autenticación Y email verificado.
Route::middleware(['auth', 'verified'])->group(function () {

  // Dashboard General (Accesible a todos los autenticados y verificados)
  Route::get('/dashboard', function () {
    return view('dashboard');
  })->name('dashboard');

  // Dashboard de Administrador (Solo acceso si role es 'admin')
  Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
  })->middleware('role:admin')->name('admin.dashboard');

  // Dashboard de Guardaparque (Solo acceso si role es 'guardaparque')
  Route::get('/guardaparque/dashboard', function () {
    return view('guardaparque.dashboard');
  })->middleware('role:guardaparque')->name('guardaparque.dashboard');
});

require __DIR__ . '/auth.php';
