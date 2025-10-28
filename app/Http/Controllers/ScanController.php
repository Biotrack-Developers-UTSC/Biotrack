<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\User; // Asume que quieres escanear usuarios (empleados/guardaparques/users)
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class ScanController extends Controller
{
    /**
     * Maneja el escaneo de un código QR para múltiples tipos de entidades.
     * El contenido del QR debe seguir el formato: TIPO-ID (ej: ANIMAL-45, USER-10)
     *
     * @param string $qrCodeData El contenido completo del código QR.
     */
    public function scan(string $qrCodeData): RedirectResponse
    {
        try {
            // Dividir el string en TIPO y ID
            $parts = explode('-', $qrCodeData);

            if (count($parts) < 2) {
                return redirect()->route('home')->with('error', 'Código QR inválido. Formato esperado: TIPO-ID.');
            }

            $type = strtoupper($parts[0]);
            $id = $parts[1];

            switch ($type) {
                case 'ANIMAL':
                    // Redirige al método show del AnimalController para mostrar la ficha.
                    return redirect()->route('animales.scan', $id);

                case 'USER':
                    // Lógica para escaneo de Usuarios/Empleados (ej: para registro de asistencia o identificación rápida)
                    $user = User::find($id);
                    if ($user) {
                        // Podrías redirigir al perfil del usuario dentro de la administración
                        return redirect()->route('administracion.usuarios.show', $user->id);
                    }
                    break;

                // Puedes agregar más casos aquí:
                // case 'ALERT':
                //     // return redirect()->route('alertas.show', $id);
                //     break;
            }

            // Si el tipo es reconocido pero el ID no se encuentra
            return redirect()->route('home')->with('error', "{$type} con ID {$id} no encontrado.");

        } catch (\Exception $e) {
            Log::error('Error al procesar escaneo QR: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Error interno al procesar el escaneo.');
        }
    }
}
