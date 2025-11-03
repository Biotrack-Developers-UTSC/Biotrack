@extends('layouts.dashboard')
@section('title', 'Configuración del Sistema | BioTrack')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <h1 class="text-4xl font-extrabold text-red-700 mb-8">Configuración Avanzada del Sistema</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 shadow">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.config.save') }}" method="POST" id="configForm">
            @csrf

            {{-- General --}}
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-red-600 mb-4">🔧 Configuración General</h2>
                @foreach($configGeneral as $key => $value)
                    <div class="mb-4">
                        <label class="block font-medium text-gray-800 mb-1">{{ $key }}</label>
                        <input type="text" name="general[{{ $key }}]" value="{{ $value }}" class="w-full border p-2 rounded">
                    </div>
                @endforeach
            </div>

            {{-- Arduino --}}
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-red-600 mb-4">🤖 Alertas Arduino</h2>

                <div class="mb-4">
                    <label class="block font-medium text-gray-800 mb-1">Umbral de distancia (cm)</label>
                    <input type="number" name="arduino[distance_threshold]"
                        value="{{ $arduino['distance_threshold'] ?? 50 }}" class="w-full border p-2 rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-800 mb-1">Tiempo de enfriamiento entre alertas (ms)</label>
                    <input type="number" name="arduino[alert_cooldown_ms]"
                        value="{{ $arduino['alert_cooldown_ms'] ?? 30000 }}" class="w-full border p-2 rounded">
                </div>
            </div>

            {{-- SMTP --}}
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-red-600 mb-4">✉️ Configuración SMTP</h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-medium text-gray-800 mb-1">Servidor SMTP</label>
                        <input type="text" name="smtp[host]" value="{{ $smtp['host'] ?? '' }}"
                            class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block font-medium text-gray-800 mb-1">Puerto</label>
                        <input type="number" name="smtp[port]" value="{{ $smtp['port'] ?? 465 }}"
                            class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block font-medium text-gray-800 mb-1">Usuario (correo)</label>
                        <input type="email" name="smtp[user]" value="{{ $smtp['user'] ?? '' }}"
                            class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block font-medium text-gray-800 mb-1">Contraseña o clave de app</label>
                        <input type="password" name="smtp[pass]" value="{{ $smtp['pass'] ?? '' }}"
                            class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block font-medium text-gray-800 mb-1">Encriptación (ssl/tls)</label>
                        <input type="text" name="smtp[encryption]" value="{{ $smtp['encryption'] ?? 'ssl' }}"
                            class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block font-medium text-gray-800 mb-1">Correo destino de alertas</label>
                        <input type="email" name="smtp[test_email]" value="{{ $smtp['test_email'] ?? '' }}"
                            class="w-full border p-2 rounded">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Guardar
                    Configuración</button>
                <button type="button" id="testMailBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enviar correo de prueba</button>
            </div>
        </form>

        <div id="mailResult" class="mt-4 font-medium"></div>

    </div>

    {{-- Script AJAX --}}
    <script>
        document.getElementById('testMailBtn').addEventListener('click', function () {
            const email = document.querySelector('input[name="smtp[test_email]"]').value;
            if (!email) {
                alert('Por favor, escribe un correo de destino antes de probar.');
                return;
            }
            fetch('{{ route("admin.config.save") }}'.replace('/config/save', '/test-mail'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email })
            })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('mailResult').innerText = data.message;
                })
                .catch(() => {
                    document.getElementById('mailResult').innerText = '❌ Error de conexión.';
                });
        });
    </script>
@endsection