<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\User;
use App\Models\Alerta;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class ScanController extends Controller
{
    /**
     * Procesa el escaneo de un código QR o ingresado manualmente.
     * Espera un formato: TIPO-ID (ejemplo: ANIMAL-5, USER-3, ALERTA-10)
     */
    public function scan(string $qrCodeData): RedirectResponse
    {
        $homeRoute = route('welcome');

        try {
            // 🧹 Limpieza de entrada (quita espacios o caracteres extra)
            $qrCodeData = strtoupper(trim($qrCodeData));
            $parts = explode('-', $qrCodeData);

            // 🔍 Validar formato
            if (count($parts) < 2 || !is_numeric($parts[1])) {
                return redirect($homeRoute)
                    ->with('error', '⚠️ Código QR inválido. Formato esperado: TIPO-ID (ej: ANIMAL-1).');
            }

            $type = $parts[0];
            $id = intval($parts[1]);

            switch ($type) {
                case 'ANIMAL':
                    $animal = Animal::find($id);
                    if ($animal) {
                        Log::info("🐾 Escaneo exitoso: ANIMAL-{$id}");
                        return redirect()->route('animales.ficha_publica', $animal->id)
                            ->with('success', "Ficha del animal encontrada (ID: {$id}).");
                    }
                    break;

                case 'USER':
                case 'USUARIO':
                    $user = User::find($id);
                    if ($user) {
                        Log::info("👤 Escaneo exitoso: USER-{$id}");
                        // Ruta para ver perfil de usuario si existe (admin)
                        return redirect()->route('administracion.usuarios.show', $user->id)
                            ->with('success', "Perfil del usuario encontrado (ID: {$id}).");
                    }
                    break;

                case 'ALERT':
                case 'ALERTA':
                    $alerta = Alerta::find($id);
                    if ($alerta) {
                        Log::info("🚨 Escaneo exitoso: ALERTA-{$id}");
                        return redirect()->route('alertas.show', $alerta->id)
                            ->with('success', "Alerta encontrada (ID: {$id}).");
                    }
                    break;

                default:
                    return redirect($homeRoute)
                        ->with('error', "❌ Tipo de entidad '{$type}' no reconocido. Usa ANIMAL-, USER- o ALERTA-.");
            }

            // Si el registro no existe
            return redirect($homeRoute)
                ->with('error', "❌ No se encontró el registro {$type} con ID {$id}.");

        } catch (\Exception $e) {
            Log::error('❗ Error al procesar escaneo QR: ' . $e->getMessage());
            return redirect($homeRoute)
                ->with('error', '⚠️ Error interno al procesar el escaneo.');
        }
    }
}
