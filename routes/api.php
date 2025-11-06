<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArduinoAlertaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Estas rutas son accesibles desde dispositivos IoT (como el ESP32-CAM).
| Ejemplo de URL: https://tuservidor.com/api/arduino/alerta
| No requieren autenticación de usuario web.
*/

Route::post('/arduino/alerta', [ArduinoAlertaController::class, 'store'])->name('api.arduino.alerta');
