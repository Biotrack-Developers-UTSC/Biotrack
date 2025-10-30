<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BioTrack') - Seguimiento de Especies</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('styles/dashboard.css') }}">
    @yield('styles') {{-- Soporte para estilos adicionales --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Registro del Service Worker --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('{{ asset('ServiceWorker.js') }}')
                    .then(reg => console.log('Service Worker registrado:', reg.scope));
            });
        }
    </script>
</head>

<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen">

    {{-- 🌟 HEADER UNIFICADO Y DINÁMICO 🌟 --}}
    <header class="bg-white shadow-lg border-b-4 border-green-500 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-bold text-gray-800">BioTrack</h1>
                </div>

                {{-- NAVEGACIÓN DINÁMICA POR ROL (Utiliza la lógica JS showSection) --}}
                <nav class="nav-links hidden md:flex space-x-6">
                    {{-- Usaremos el enlace 'welcome' para la navegación principal --}}
                    <a href="{{ route('welcome') }}" class="nav-btn text-gray-600 hover:text-green-600">Volver a
                        Roles</a>

                    @auth
                        {{-- Botones de Pestaña del Dashboard (Guardaparque/Admin) --}}
                        <button onclick="showSection('dashboard-general', this)"
                            class="nav-btn text-green-600 font-semibold border-b-2 border-green-600">Dashboard</button>

                        @if (Auth::user()->role === 'guardaparque' || Auth::user()->role === 'admin')
                            <button onclick="showSection('gestion-animales', this)"
                                class="nav-btn text-gray-600 hover:text-green-600">Gestión Animales</button>
                            <button onclick="showSection('sensores', this)"
                                class="nav-btn text-gray-600 hover:text-green-600">Sensores IoT</button>
                        @endif

                        @if (Auth::user()->role === 'admin')
                            <button onclick="showSection('gestion-usuarios', this)"
                                class="nav-btn text-gray-600 hover:text-green-600">Admin Usuarios</button>
                        @endif

                        <button onclick="showSection('reportes', this)"
                            class="nav-btn text-gray-600 hover:text-green-600">Reportes</button>
                    @endauth
                </nav>

                {{-- INFO DE USUARIO Y LOGOUT --}}
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-gray-800 font-medium" id="usuario">
                            Hola, {{ Auth::user()->name ?? 'Guardaparque' }} 👋
                        </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-white text-gray-800 rounded-lg hover:bg-gray-100 transition-colors border border-gray-300">
                                Cerrar Sesión
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="py-6">
        @yield('content')
    </main>

    {{-- LÓGICA JAVASCRIPT DE PESTAÑAS (Debe estar aquí) --}}
    <script>
        // Debes pegar la implementación completa de showSection aquí si la estás usando
        function showSection(sectionName, clickedButton) {
            // Ejemplo de implementación de showSection para evitar errores de referencia si esta página se usa
            console.log(`Cambiando a la sección: ${sectionName}`);
            // Lógica completa de visibilidad de pestañas
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Lógica de inicialización del dashboard
        });
    </script>
</body>

</html>