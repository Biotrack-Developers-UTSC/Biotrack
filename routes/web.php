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

  // Dashboard principal
  Route::get('/welcome', [HomeController::class, 'index'])->name('welcome');

  // Juegos
  Route::get('/juegos/futbol', fn() => view('futbol_gamepage'))->name('juegos.futbol');

  // Escaneo QR
  Route::get('/qr/scanner/ui', fn() => view('qr.scanner_ui'))->name('qr.scanner.ui');
  Route::get('/scan/{qrCodeData}', [ScanController::class, 'scan'])
    ->where('qrCodeData', '.*')
    ->name('qr.scan');

  // Ficha pública de animales
  Route::get('/animales/ficha/{animal}', [AnimalController::class, 'ficha_publica'])->name('animales.ficha_publica');

  // CRUD de animales
  Route::resource('animales', AnimalController::class)->parameters(['animales' => 'animal']);
  Route::get('/animales/{id}/regenerar-qr', [AnimalController::class, 'regenerarQR'])->name('animales.regenerarQR');

  // 📡 CRUD de alertas (manuales o desde IoT)
  Route::resource('alertas', AlertaController::class)->parameters(['alertas' => 'alerta']);
  Route::post('/alertas/{alerta}/enviar', [AlertaController::class, 'send'])->name('alertas.send');

  // Consultas
  Route::get('/consultas/animales', [ConsultaController::class, 'index'])->name('consultas.index');

  /*
  |--------------------------------------------------------------------------
  | GUARDAPARQUES y ADMIN
  |--------------------------------------------------------------------------
  */
  Route::middleware(['auth', 'role:guardaparque|admin'])->group(function () {
    Route::get('/dashboard/gestion', [GuardaparquesController::class, 'dashboard'])->name('guardaparques.dashboard');
    Route::get('/guardaparques/alertas', [GuardaparquesController::class, 'alertas'])->name('guardaparques.alertas.index');
    Route::get('/consultas/usuarios', [UserController::class, 'consultaUsuarios'])->name('consultas.usuarios');
  });

  /*
  |--------------------------------------------------------------------------
  | ADMIN
  |--------------------------------------------------------------------------
  */
  Route::middleware(['auth', 'role:admin'])->group(function () {
    // IoT
    Route::get('/admin/iot', [AdminController::class, 'iotDashboard'])->name('admin.iot');
    Route::post('/admin/iot/save', [AdminController::class, 'save'])->name('admin.config.save');
    Route::post('/admin/iot/test-mail', [AdminController::class, 'testArduinoMail'])->name('admin.testMail');
    Route::post('/admin/iot/toggle-mail', [AdminController::class, 'toggleMailMethod'])->name('admin.toggleMailMethod');

    // Usuarios
    Route::resource('usuarios', UserController::class)->names('administracion.usuarios');

    // Flujo de correo y mantenimiento
    Route::get('/admin/flujocorreo', [AdminController::class, 'flujoCorreo'])->name('admin.flujocorreo');
    Route::get('/admin/config', [AdminController::class, 'config'])->name('admin.config');
    Route::post('/admin/system/clear-cache', [AdminController::class, 'clearCache'])->name('admin.system.clearCache');
    Route::post('/admin/system/regenerate-key', [AdminController::class, 'regenerateKey'])->name('admin.system.regenerateKey');
    Route::post('/admin/system/update-sw', [AdminController::class, 'updateServiceWorker'])->name('admin.system.updateSW');
    Route::post('/admin/system/check-status', [AdminController::class, 'checkStatus'])->name('admin.system.checkStatus');
  });
});
