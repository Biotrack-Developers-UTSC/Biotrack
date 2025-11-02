@extends('layouts.app')
@section('title', 'Configuración del Sistema | BioTrack')
@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <h1 class="text-4xl font-extrabold text-red-700 mb-8">Configuración Avanzada del Sistema</h1>

    {{-- Mensajes flash --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6 shadow">
            {{ session('error') }}
        </div>
    @endif

    {{-- SECCIÓN 1: Configuración General --}}
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-red-600 mb-4">🔧 Configuración General</h2>
        <form action="{{ route('admin.config.save') }}" method="POST">
            @csrf
            @foreach($configGeneral as $key => $value)
                <div class="mb-4">
                    <label class="block font-medium text-gray-800 mb-1">{{ $key }}</label>
                    <input type="text" name="general[{{ $key }}]" value="{{ $value ?? '' }}"
                           class="w-full border p-2 rounded" required>
                </div>
            @endforeach
            <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors shadow">
                Guardar Cambios
            </button>
        </form>
    </div>

    {{-- SECCIÓN 2: Alertas Arduino --}}
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-red-600 mb-4">🤖 Alertas Arduino</h2>
        <form action="{{ route('admin.config.save') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-medium text-gray-800 mb-1">Activar alertas Arduino</label>
                <select name="arduino[active]" class="w-full border p-2 rounded">
                    <option value="1" {{ ($arduino['active'] ?? 1) == 1 ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ ($arduino['active'] ?? 1) == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-medium text-gray-800 mb-1">Umbral distancia (cm)</label>
                <input type="number" name="arduino[distance_threshold]" value="{{ $arduino['distance_threshold'] ?? 50 }}"
                       class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium text-gray-800 mb-1">Correo de prueba</label>
                <input type="email" name="arduino[test_email]" value="{{ $arduino['test_email'] ?? '' }}"
                       class="w-full border p-2 rounded" placeholder="correo@ejemplo.com">
            </div>
            <div class="flex space-x-2">
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors shadow">
                    Guardar Configuración Arduino
                </button>
                <button type="button" onclick="sendTestArduinoEmail()"
                        class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow">
                    Enviar alerta de prueba
                </button>
            </div>
        </form>
    </div>

    {{-- SECCIÓN 3: Correo SMTP --}}
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-red-600 mb-4">✉️ Configuración de Correo SMTP</h2>
        <form action="{{ route('admin.config.save') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-medium text-gray-800 mb-1">Servidor SMTP</label>
                <input type="text" name="smtp[host]" value="{{ $smtp['host'] ?? '' }}"
                       class="w-full border p-2 rounded" placeholder="smtp.ejemplo.com" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium text-gray-800 mb-1">Puerto</label>
                <input type="number" name="smtp[port]" value="{{ $smtp['port'] ?? 587 }}"
                       class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium text-gray-800 mb-1">Usuario</label>
                <input type="email" name="smtp[user]" value="{{ $smtp['user'] ?? '' }}"
                       class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium text-gray-800 mb-1">Contraseña</label>
                <input type="password" name="smtp[pass]" value="{{ $smtp['pass'] ?? '' }}"
                       class="w-full border p-2 rounded" required>
            </div>
            <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors shadow">
                Guardar Configuración SMTP
            </button>
        </form>
    </div>

</div>

<script>
    function sendTestArduinoEmail() {
        const email = document.querySelector('input[name="arduino[test_email]"]').value;
        if (!email) {
            alert('Ingresa un correo de prueba.');
            return;
        }

        fetch("{{ route('admin.arduino.testmail') }}", {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
            body: JSON.stringify({email: email})
        })
        .then(res => res.json())
        .then(data => alert(data.message))
        .catch(err => alert('Error enviando alerta de prueba'));
    }
</script>

@endsection
