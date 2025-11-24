<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alerta;
use Illuminate\Support\Str;

class AlertaController extends Controller
{
    /**
     * 🚨 Recibe datos JSON desde ESP32-CAM o FastAPI
     * y guarda las alertas con imagen en public/images/alerts
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // 🧩 Validación mínima
        if (empty($data['titulo']) && empty($data['foto'])) {
            return response()->json(['error' => 'JSON inválido o incompleto'], 400);
        }

        // 🖼️ Guardar imagen en public/images/alerts
        $pathImagen = null;
        if (!empty($data['foto'])) {
            try {
                // Quitar encabezado "data:image/jpeg;base64," si existe
                $imgBase64 = $data['foto'];
                if (str_starts_with($imgBase64, 'data:image')) {
                    $imgBase64 = explode(',', $imgBase64)[1];
                }

                $bytes = base64_decode($imgBase64);
                $nombre = 'IMG_' . time() . '_' . Str::random(6) . '.jpg';

                // Crear carpeta si no existe
                $carpeta = public_path('images/alerts');
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0775, true);
                }

                // Guardar el archivo directamente en public/images/alerts
                $rutaCompleta = $carpeta . '/' . $nombre;
                file_put_contents($rutaCompleta, $bytes);

                // Ruta pública que se mostrará en la tabla
                $pathImagen = 'images/alerts/' . $nombre;
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al guardar imagen: ' . $e->getMessage()], 500);
            }
        }

        // 🆕 Crear alerta
        $alerta = Alerta::create([
            'id_alerta' => 'ALR-' . strtoupper(Str::random(6)),
            'titulo' => $data['titulo'] ?? 'Alerta IoT',
            'mensaje' => $data['mensaje'] ?? 'Movimiento detectado por sensor IoT.',
            'severidad' => ucfirst($data['severidad'] ?? 'Media'),
            'tipo' => $data['tipo'] ?? 'hostil',
            'sensor_id' => $data['sensor_id'] ?? 'ESP32-CAM',
            'ubicacion' => $data['ubicacion'] ?? 'Zona desconocida',
            'estado' => 'Nueva',
            'imagen' => $pathImagen,
            'enviado' => false,
        ]);

        // 📤 Responder al dispositivo o FastAPI
        return response()->json([
            'status' => 'ok',
            'id_alerta' => $alerta->id_alerta,
            'mensaje' => 'Alerta IoT guardada correctamente.',
            'imagen_guardada' => $pathImagen,
        ], 201);
    }
}
