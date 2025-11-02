<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AlertasSeeder extends Seeder
{
    public function run(): void
    {
        // Valores válidos para los enums
        $severidades = ['Baja', 'Media', 'Alta'];
        $estados = ['Nueva', 'En Proceso', 'Resuelta'];

        // Crear 5 alertas de prueba
        for ($i = 1; $i <= 5; $i++) {
            $alertaId = 'ALR-' . Str::upper(Str::random(6));
            $titulo = "Alerta de prueba #{$i}";
            $mensaje = "Se ha detectado un evento de prueba en el sensor {$i}.";

            // Selección aleatoria de severidad y estado
            $severidad = $severidades[array_rand($severidades)];
            $estado = $estados[array_rand($estados)];

            $sensor_id = "SENSOR-{$i}";
            $ubicacion = "Zona {$i}";

            // Insertar en la tabla
            DB::table('alertas')->insert([
                'id_alerta' => $alertaId,
                'titulo' => $titulo,
                'mensaje' => $mensaje,
                'severidad' => $severidad,
                'sensor_id' => $sensor_id,
                'ubicacion' => $ubicacion,
                'estado' => $estado,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Simular envío de correo si la severidad es alta
            if ($severidad === 'Alta') {
                Mail::raw(
                    "ALERTA CRÍTICA: {$titulo}\nDetalle: {$mensaje}\nUbicación: {$ubicacion}\nEstado: {$estado}",
                    function ($message) use ($alertaId) {
                        $message->to('admin@biotrack.test')
                            ->subject("Nueva Alerta Crítica: {$alertaId}");
                    }
                );
            }
        }

        $this->command->info('Seeder de alertas ejecutado correctamente.');
    }
}
