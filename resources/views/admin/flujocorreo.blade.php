@extends('layouts.dashboard')
@section('title', 'Flujo de Alertas - BioTrack')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-red-600 mb-6">📧 Flujo de Alertas de Arduino</h1>

        <p class="mb-4 text-gray-700">Diagrama de flujo simplificado mostrando cómo las alertas de Arduino se procesan y
            envían vía correo SMTP.</p>

        <div class="bg-white p-6 rounded-xl shadow mb-6">
            <pre class="mermaid">
                            graph TD
                                A[Arduino Detecta Movimiento/Distancia] --> B{Umbral Superado?}
                                B -- Sí --> C[Python procesa alerta]
                                C --> D[Notificación de Escritorio]
                                C --> E[TTS: Reproduce mensaje]
                                C --> F[Envía correo SMTP]
                                F --> G[Correo llega al destinatario]
                                B -- No --> H[No se realiza acción]
                        </pre>

            <div class="bg-white p-6 rounded-xl shadow mt-8">
                <h2 class="text-2xl font-bold text-red-600 mb-4">🧾 Documentación del Panel de Administración</h2>

                <p class="text-gray-700 mb-4">
                    En el panel de administración de <strong>BioTrack</strong> se integran tres vistas clave que permiten al
                    administrador mantener y controlar tanto el sistema web como las alertas provenientes de dispositivos
                    IoT.
                </p>

                <h3 class="text-xl font-semibold text-red-600 mb-2">1️⃣ Mantenimiento del Sistema
                    (<code>admin/config</code>)</h3>
                <p class="text-gray-700 mb-3">
                    Esta vista centraliza las herramientas técnicas necesarias para el correcto funcionamiento de la
                    plataforma.
                    Permite limpiar cachés, regenerar la <code>APP_KEY</code>, actualizar el <strong>Service Worker</strong>
                    y
                    comprobar el estado del sistema y la base de datos.
                    De esta forma, el administrador puede resolver problemas comunes sin depender de comandos en consola o
                    soporte técnico.
                </p>

                <h3 class="text-xl font-semibold text-red-600 mb-2">2️⃣ Configuración IoT (<code>admin/iot_dashboard</code>)
                </h3>
                <p class="text-gray-700 mb-3">
                    En esta sección se configuran los parámetros relacionados con Arduino y la comunicación de alertas
                    automáticas.
                    El administrador puede ajustar el umbral de detección, el tiempo de enfriamiento entre alertas y definir
                    el
                    método de envío de correos SMTP (ya sea desde el servidor o una cuenta configurada manualmente).
                    También incluye un botón para realizar pruebas de envío en tiempo real, garantizando que las
                    notificaciones
                    funcionen correctamente.
                </p>

                <h3 class="text-xl font-semibold text-red-600 mb-2">3️⃣ Flujo de Alertas (<code>admin/flujocorreo</code>)
                </h3>
                <p class="text-gray-700 mb-3">
                    Esta vista muestra un diagrama visual del flujo de alertas desde que el dispositivo Arduino detecta un
                    movimiento
                    o distancia anómala hasta que el usuario recibe un correo de notificación.
                    El proceso combina <strong>Arduino + Python + Laravel</strong>, representando cómo los datos físicos del
                    sensor
                    son transformados en acciones digitales (alertas, mensajes TTS o correos).
                </p>

                <h3 class="text-xl font-semibold text-red-600 mb-2">🧠 Justificación</h3>
                <p class="text-gray-700">
                    Estas vistas fueron desarrolladas para otorgar al administrador un control completo sobre el sistema sin
                    necesidad de conocimientos técnicos avanzados.
                    <strong>BioTrack</strong> combina un entorno web robusto con la administración de dispositivos IoT, por
                    lo que
                    resulta esencial contar con módulos que faciliten la configuración, mantenimiento y comprensión del
                    flujo de
                    alertas.
                    Gracias a estas herramientas, el sistema se vuelve más estable, seguro y autónomo.
                </p>
            </div>
        </div>

        <p class="text-gray-500 text-sm">Este diagrama se puede usar para explicar el flujo a tus maestros o equipo.</p>
    </div>

    <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
        mermaid.initialize({ startOnLoad: true });
    </script>
@endsection