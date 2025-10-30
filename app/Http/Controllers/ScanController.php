<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\User;
use App\Models\Alerta; // Añadido para escaneo de Alertas
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Providers\AppServiceProvider;

class ScanController extends Controller
{
    /**
     * Maneja el escaneo de un código QR para múltiples tipos de entidades.
     * El contenido del QR debe seguir el formato: TIPO-ID (ej: ANIMAL-45, USER-10, ALERT-7)
     *
     * @param string $qrCodeData El contenido completo del código QR.
     */
    public function scan(string $qrCodeData): RedirectResponse
    {
        // La ruta de error base es 'welcome' (AppServiceProvider::HOME)
        $homeRoute = route('welcome');

        try {
            // Dividir el string en TIPO y ID
            $parts = explode('-', $qrCodeData);

            if (count($parts) < 2) {
                return redirect($homeRoute)->with('error', 'Código QR inválido. Formato esperado: TIPO-ID.');
            }

            $type = strtoupper($parts[0]);
            $id = $parts[1];

            switch ($type) {
                case 'ANIMAL':
                    $animal = Animal::find($id);
                    if ($animal) {
                        // Redirige a la ficha pública del animal (vista con mapa)
                        return redirect()->route('animales.ficha', $animal->id);
                    }
                    break;

                case 'USER':
                    $user = User::find($id);
                    if ($user) {
                        // Redirige a la vista de detalle del usuario (CRUD de Admin)
                        return redirect()->route('administracion.usuarios.show', $user->id);
                    }
                    break;

                case 'ALERT':
                    $alerta = Alerta::find($id);
                    if ($alerta) {
                        // Redirige a la vista de detalle de la alerta
                        return redirect()->route('alertas.show', $alerta->id);
                    }
                    break;

                default:
                    return redirect($homeRoute)->with('error', "Tipo de entidad ({$type}) no reconocido.");
            }

            // Si el ID no se encuentra para el TIPO especificado
            return redirect($homeRoute)->with('error', "Registro {$type} con ID {$id} no encontrado.");

        } catch (\Exception $e) {
            Log::error('Error al procesar escaneo QR: ' . $e->getMessage());
            return redirect($homeRoute)->with('error', 'Error interno al procesar el escaneo.');
        }
    }
}
