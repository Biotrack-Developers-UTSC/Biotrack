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
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
  return Auth::check() ? redirect()->route('welcome') : view('index');
})->name('index');

// Login y Registro
Route::middleware('guest')->group(function () {
  Route::get('register', fn() => view('auth.register'))->name('register');
  Route::post('register', [RegisteredUserController::class, 'store'])->name('register.post');

  Route::get('login', fn() => view('auth.login'))->name('login');
  Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
});

// Logout
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
  ->middleware('auth')
  ->name('logout');

/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (Usuarios autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

  Route::get('/welcome', [HomeController::class, 'index'])->name('welcome');
  Route::get('/juegos/futbol', fn() => view('futbol_gamepage'))->name('juegos.futbol');

  // Escaneo QR
  Route::get('/qr/scanner/ui', fn() => view('qr.scanner_ui'))->name('qr.scanner.ui');
  Route::get('/scan/{qrCodeData}', [ScanController::class, 'scan'])->name('qr.scan');

  // Ficha pública de animales
  Route::get('/animales/ficha/{animal}', [AnimalController::class, 'ficha_publica'])->name('animales.ficha_publica');

  // CRUD de animales
  Route::resource('animales', AnimalController::class)->parameters(['animales' => 'animal']);
  Route::get('/animales/{id}/regenerar-qr', [AnimalController::class, 'regenerarQR'])->name('animales.regenerarQR');

  // Consultas
  Route::get('/consultas/animales', [ConsultaController::class, 'index'])->name('consultas.index');

  /*
  |--------------------------------------------------------------------------
  | Guardaparques y Admin
  |--------------------------------------------------------------------------
  */
  Route::middleware(['auth', 'role:guardaparque|admin'])->group(function () {
    // Dashboard guardaparques
    Route::get('/dashboard/gestion', [GuardaparquesController::class, 'dashboard'])->name('guardaparques.dashboard');

    // CRUD de alertas
    Route::resource('alertas', AlertaController::class)->parameters(['alertas' => 'alerta']);
  });


  /*
  |--------------------------------------------------------------------------
  | RUTAS ADMIN
  |--------------------------------------------------------------------------
  */
  Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/config', [AdminController::class, 'index'])->name('admin.config');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/config/save', [AdminController::class, 'save'])->name('admin.config.save');
    Route::get('/config/testdb', [AdminController::class, 'testDB'])->name('admin.config.testdb');
    Route::post('/config/testmail', [AdminController::class, 'testArduinoMail'])->name('admin.arduino.testmail');
    Route::get('/admin/iot', [AdminController::class, 'iotDashboard'])->name('admin.iot');

    // Usuarios
    Route::resource('usuarios', UserController::class)->names('administracion.usuarios');
  });

});
