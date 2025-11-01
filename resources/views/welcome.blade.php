<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenida - BioTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #A8D8B9 0%, #7CB9E8 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 4rem;
        }

        .welcome-card {
            background-color: white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            border-radius: 1rem;
            width: 100%;
            max-width: 900px;
            transition: all 0.3s ease;
            padding-bottom: 2rem;
        }

        /* Colores */
        .bg-admin {
            background-color: #FEE2E2;
            border: 1px solid #FCA5A5;
        }

        .bg-guardaparque {
            background-color: #D1FAE5;
            border: 1px solid #6EE7B7;
        }

        .bg-user {
            background-color: #E0F2F1;
            border: 1px solid #4DD0E1;
        }

        /* Tarjetas base */
        .action-card {
            padding: 1.75rem;
            border-radius: 0.75rem;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .action-card:hover {
            transform: translateY(-3px);
        }

        /* Tamaños por rol */
        .user-card {
            max-width: 650px;
            margin: 0 auto;
        }

        .guardaparque-card {
            max-width: 420px;
            margin: 0 auto;
        }

        /* Botones */
        .btn-big {
            font-size: 1rem;
            padding: 0.9rem 1.25rem;
        }

        /* Contenedor de tarjetas */
        .card-container {
            display: grid;
            gap: 1.5rem;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .card-container.triple {
                grid-template-columns: repeat(3, 1fr);
            }

            .card-container.double {
                grid-template-columns: repeat(2, 1fr);
            }

            .card-container.single {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="welcome-card p-6 md:p-10">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2 text-center">
            ¡Bienvenido, {{ $user->name }}!
        </h1>

        <p class="text-xl font-medium mb-10 pb-4 border-b border-gray-200 text-center
            @if($user->role === 'admin') text-red-600
            @elseif($user->role === 'guardaparque') text-green-600
            @else text-gray-600 @endif">
            Tu Rol: <span class="uppercase font-extrabold">{{ $user->role }}</span>
        </p>

        <h2 class="text-2xl font-semibold text-gray-700 mb-8 text-center">Centro de Control</h2>

        @php
            $isAdmin = $user->role === 'admin';
            $isGuardaparque = $user->role === 'guardaparque';
            $isUser = $user->role === 'user';
        @endphp

        <div class="card-container 
            @if($isAdmin) triple @elseif($isGuardaparque) double @else single @endif
            {{ $isUser || $isGuardaparque ? 'mx-auto text-center' : '' }}">

            {{-- ADMIN --}}
            @if($isAdmin)
                <div class="action-card bg-admin">
                    <h3 class="text-xl font-bold text-red-700 mb-3"><i class="fas fa-crown mr-2"></i> Administración</h3>
                    <p class="text-gray-700 mb-4 text-sm">Gestión completa del sistema, usuarios y configuración.</p>

                    <div class="space-y-2 mt-4">
                        <a href="{{ route('admin.dashboard') }}"
                            class="block text-center py-2 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors text-sm">
                            <i class="fas fa-desktop mr-1"></i> Dashboard
                        </a>
                        <a href="{{ route('administracion.usuarios.index') }}"
                            class="block text-center py-2 px-4 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition-colors text-sm">
                            <i class="fas fa-users-cog mr-1"></i> Gestión de Usuarios
                        </a>
                        <a href="{{ route('admin.config') }}"
                            class="block text-center py-2 px-4 bg-red-400 hover:bg-red-500 text-white font-semibold rounded-lg transition-colors text-sm">
                            <i class="fas fa-cogs mr-1"></i> Configuración
                        </a>
                    </div>
                </div>

                <div class="action-card bg-guardaparque">
                    <h3 class="text-xl font-bold text-green-700 mb-3"><i class="fas fa-user-shield mr-2"></i> Gestión de
                        Campo</h3>
                    <p class="text-gray-700 mb-4 text-sm">Creación y monitoreo de la fauna y alertas IoT.</p>

                    <div class="space-y-2 mt-4">
                        <a href="{{ route('guardaparques.dashboard') }}"
                            class="block text-center py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors text-sm">
                            <i class="fas fa-binoculars mr-1"></i> Dashboard
                        </a>
                        <a href="{{ route('animales.index') }}"
                            class="block text-center py-2 px-4 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors text-sm">
                            <i class="fas fa-edit mr-1"></i> CRUD de Especies
                        </a>
                    </div>
                </div>

                <div class="action-card bg-user">
                    <h3 class="text-xl font-bold text-cyan-700 mb-3"><i class="fas fa-paw mr-2"></i> Consultas / Juegos</h3>
                    <p class="text-gray-700 mb-4 text-sm">Acceso a fichas de especies y entretenimiento.</p>

                    <div class="space-y-2 mt-4">
                        <a href="{{ route('consultas.index') }}"
                            class="block text-center py-2 px-4 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg transition-colors text-sm">
                            <i class="fas fa-search mr-1"></i> Consultas
                        </a>
                        <a href="{{ route('qr.scanner.ui') }}"
                            class="block text-center py-2 px-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg transition-colors text-sm">
                            <i class="fas fa-qrcode mr-1"></i> Escanear QR
                        </a>
                        <a href="{{ route('juegos.futbol') }}"
                            class="block text-center py-2 px-4 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded-lg transition-colors text-sm">
                            <i class="fas fa-gamepad mr-1"></i> Jugar Fútbol
                        </a>
                    </div>
                </div>
            @endif

            {{-- GUARDAPARQUE --}}
            @if($isGuardaparque)
                <div class="action-card bg-guardaparque guardaparque-card">
                    <h3 class="text-2xl font-bold text-green-700 mb-4"><i class="fas fa-shield-alt mr-2"></i> Panel de
                        Guardaparques</h3>
                    <p class="text-gray-700 mb-6 text-base">Acceso a herramientas de campo y control de especies.</p>

                    <div class="space-y-4 mt-4">
                        <a href="{{ route('guardaparques.dashboard') }}"
                            class="block text-center btn-big bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard de Gestión
                        </a>
                        <a href="{{ route('animales.index') }}"
                            class="block text-center btn-big bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors">
                            <i class="fas fa-edit mr-1"></i> CRUD de Especies
                        </a>
                    </div>
                </div>

                <div class="action-card bg-user guardaparque-card">
                    <h3 class="text-2xl font-bold text-cyan-700 mb-4"><i class="fas fa-search mr-2"></i> Consultas y
                        Exploración</h3>
                    <p class="text-gray-700 mb-6 text-base">Acceso rápido a fichas y escaneo QR.</p>

                    <div class="space-y-4 mt-4">
                        <a href="{{ route('consultas.index') }}"
                            class="block text-center btn-big bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg transition-colors">
                            <i class="fas fa-search mr-1"></i> Consultas
                        </a>
                        <a href="{{ route('qr.scanner.ui') }}"
                            class="block text-center btn-big bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg transition-colors">
                            <i class="fas fa-qrcode mr-1"></i> Escanear QR
                        </a>
                        <a href="{{ route('juegos.futbol') }}"
                            class="block text-center btn-big bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded-lg transition-colors">
                            <i class="fas fa-gamepad mr-1"></i> Jugar Fútbol
                        </a>
                    </div>
                </div>
            @endif

            {{-- USUARIO --}}
            @if($isUser)
                <div class="action-card bg-user user-card">
                    <h3 class="text-3xl font-bold text-cyan-700 mb-4"><i class="fas fa-paw mr-2"></i> Consultas y
                        Exploración</h3>
                    <p class="text-gray-700 mb-6 text-lg">Explora las especies registradas, escanea códigos QR y disfruta
                        del juego educativo.</p>

                    <div class="space-y-4 mt-4">
                        <a href="{{ route('consultas.index') }}"
                            class="block text-center btn-big bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg transition-colors">
                            <i class="fas fa-search mr-1"></i> Consultas
                        </a>
                        <a href="{{ route('qr.scanner.ui') }}"
                            class="block text-center btn-big bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg transition-colors">
                            <i class="fas fa-qrcode mr-1"></i> Escanear QR
                        </a>
                        <a href="{{ route('juegos.futbol') }}"
                            class="block text-center btn-big bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded-lg transition-colors">
                            <i class="fas fa-gamepad mr-1"></i> Jugar Fútbol
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-12 text-center border-t pt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="py-2 px-6 bg-gray-200 text-gray-700 font-semibold rounded-full hover:bg-gray-300 transition-colors">
                    Cerrar Sesión <i class="fas fa-sign-out-alt ml-2"></i>
                </button>
            </form>
        </div>
    </div>

</body>

</html>