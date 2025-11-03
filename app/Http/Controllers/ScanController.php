<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use Illuminate\Http\RedirectResponse;

class ScanController extends Controller
{
    /**
     * Procesa el escaneo de un código QR o ingresado manualmente.
     * Solo se esperan códigos de animales: ANIMAL-ID (ej: ANIMAL-5)
     */
    public function scan(string $qrCodeData): RedirectResponse
    {
        $homeRoute = route('welcome');

        $qrCodeData = strtoupper(trim($qrCodeData));
        $parts = explode('-', $qrCodeData);

        if (count($parts) !== 2 || $parts[0] !== 'ANIMAL' || !is_numeric($parts[1])) {
            return redirect($homeRoute)
                ->with('error', '⚠️ Código QR inválido. Formato esperado: ANIMAL-ID (ej: ANIMAL-1).');
        }

        $id = intval($parts[1]);
        $animal = Animal::find($id);

        if ($animal) {
            return redirect()->route('animales.ficha_publica', $animal->id)
                ->with('success', "Ficha del animal encontrada (ID: {$id}).");
        }

        return redirect($homeRoute)
            ->with('error', "❌ No se encontró el animal con ID {$id}.");
    }
}
