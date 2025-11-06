<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alerta;
use Illuminate\Support\Str;

class ArduinoAlertaController extends Controller
{
    /**
     * 📡 Recibe alertas enviadas desde ESP32-CAM o Arduino
     * Admite imagen base64 o archivo JPG/PNG.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'nullable|string|max:255',
            'mensaje' => 'nullable|string',
            'severidad' => 'nullable|string|in:Baja,Media,Alta',
            'tipo' => 'nullable|string|in:hostil,no hostil',
            'sensor_id' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'imagen_base64' => 'nullable|string',
        ]);

        $imagePath = null;

        // 📸 Imagen como archivo
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = 'IMG_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/alerts'), $filename);
            $imagePath = 'images/alerts/' . $filename;
        }

        // 🧠 Imagen como base64
        elseif ($request->filled('imagen_base64')) {
            $data = $request->imagen_base64;
            if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                $data = substr($data, strpos($data, ',') + 1);
                $ext = $type[1];
            } else {
                $ext = 'jpg';
            }

            $data = base64_decode($data);
            $filename = 'IMG_' . time() . '_' . Str::random(6) . '.' . $ext;
            $filePath = public_path('images/alerts/' . $filename);
            file_put_contents($filePath, $data);
            $imagePath = 'images/alerts/' . $filename;
        }

        // ⚙️ Clasificar severidad automática si no se envía
        $tipo = $request->input('tipo', 'no hostil');
        $severidad = $request->input('severidad') ?? match ($tipo) {
            'hostil' => 'Alta',
            'no hostil' => 'Media',
            default => 'Baja',
        };

        // 🚨 Crear alerta
        $alerta = Alerta::create([
            'id_alerta' => 'ALR-' . strtoupper(Str::random(6)),
            'titulo' => $request->input('titulo', 'Movimiento detectado'),
            'mensaje' => $request->input('mensaje', 'El sensor detectó movimiento.'),
            'severidad' => $severidad,
            'tipo' => $tipo,
            'sensor_id' => $request->input('sensor_id', 'ESP32-CAM'),
            'ubicacion' => $request->input('ubicacion', 'Zona 1'),
            'estado' => 'Nueva',
            'enviado' => false,
            'imagen' => $imagePath,
        ]);

        return response()->json([
            'status' => 'ok',
            'alerta_id' => $alerta->id_alerta,
            'imagen_guardada' => $imagePath,
        ], 201);
    }
}
