<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenida - BioTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Fondo que simula el entorno BioTrack: Montaña/Cielo */
        body {
            background: linear-gradient(135deg, #A8D8B9 0%, #7CB9E8 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 4rem;
        }
        /* Contenedor central más visual */
        .welcome-card {
            background-color: white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            border-radius: 1rem;
            width: 100%;
            max-width: 900px;
        }
        /* Colores de Tarjetas por Rol */
        .bg-admin { background-color: #FEE2E2; border: 1px solid #FCA5A5; }
        .bg-guardaparque { background-color: #D1FAE5; border: 1px solid #6EE7B7; }
        .bg-user { background-color: #E0F2F1; border: 1px solid #4DD0E1; }

        /* Estilo para los contenedores de botones (Centrado dinámico) */
        .card-container {
            /* Usamos grid para 3 columnas en md:, y justify-center para centrar si hay menos de 3 */
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1.5rem;
            justify-content: center; /* Centrado para móvil */
        }

        /* 3 columnas en desktop, centradas */
        @media (min-width: 768px) {
            .card-container {
                grid-template-columns: repeat(3, 1fr);
            }
            .card-container.single-col {
                grid-template-columns: 1fr;
            }
            .card-container.double-col {
                 grid-template-columns: repeat(2, 1fr);
            }
        }
        
        .action-card {
            min-width: 250px;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }
        .action-card:hover {
            transform: translateY(-3px);
        }
    </style>
</head>

<body>

    <div class="welcome-card p-6 md:p-10">
        
        <!-- Saludo -->
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2">
            ¡Bienvenido, {{ $user->name }}! 
        </h1>
        
        <p class="text-xl font-medium mb-10 pb-4 border-b border-gray-200 
            @if($user->role === 'admin') text-red-600 
            @elseif($user->role === 'guardaparque') text-green-600 
            @else text-gray-600 
            @endif">
            Tu Rol: <span class="uppercase font-extrabold">{{ $user->role }}</span>
        </p>

        <h2 class="text-2xl font-semibold text-gray-700 mb-8 text-center">Tu Centro de Control</h2>
        
        
        {{-- CENTRADO DINÁMICO DE TARJETAS --}}
        @php
            $isAdmin = ($user->role === 'admin');
            $isGuardaparque = ($user->role === 'guardaparque');
            $isUser = ($user->role === 'user');
            
            // Clase de centrado para Guardaparques y Usuarios (se centran si es solo 1)
            $centeredClass = ($isGuardaparque || $isUser) ? 'max-w-md mx-auto' : 'w-full';
            
            // Definir la clase de grid para la tarjeta. Admin usa grid-cols-3
            $gridClass = $isAdmin ? 'card-container md:grid-cols-3' : 'card-container';

        @endphp

        <div class="{{ $gridClass }} {{ $centeredClass }}">

            @switch($user->role)
                
                {{-- Opciones para ADMIN (3 Tarjetas, 3 Columnas) --}}
                @case('admin')
                    
                    {{-- 1. Tarjeta de Administración --}}
                    <div class="action-card bg-admin">
                        <h3 class="text-xl font-bold text-red-700 mb-3"><i class="fas fa-crown mr-2"></i> Administración</h3>
                        <p class="text-gray-700 mb-4 text-sm">Gestión completa del sistema, usuarios y configuración.</p>
                        
                        <div class="space-y-2 mt-4">
                            <a href="{{ route('admin.dashboard') }}" class="block text-center py-2 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors text-sm">
                                <i class="fas fa-desktop mr-1"></i> Dashboard
                            </a>
                            <a href="{{ route('administracion.usuarios.index') }}" class="block text-center py-2 px-4 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition-colors text-sm">
                                <i class="fas fa-users-cog mr-1"></i> Gestión de Usuarios
                            </a>
                            <a href="{{ route('admin.config') }}" class="block text-center py-2 px-4 bg-red-400 hover:bg-red-500 text-white font-semibold rounded-lg transition-colors text-sm">
                                <i class="fas fa-cogs mr-1"></i> Configuración
                            </a>
                        </div>
                    </div>
                    
                    {{-- 2. Tarjeta de Gestión (Guardaparques) --}}
                    <div class="action-card bg-guardaparque">
                        <h3 class="text-xl font-bold text-green-700 mb-3"><i class="fas fa-user-shield mr-2"></i> Gestión de Campo</h3>
                        <p class="text-gray-700 mb-4 text-sm">Creación y monitoreo de la fauna y alertas IoT.</p>
                        
                        <div class="space-y-2 mt-4">
                            <a href="{{ route('guardaparques.dashboard') }}" class="block text-center py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors text-sm">
                                <i class="fas fa-binoculars mr-1"></i> Dashboard de Gestión
                            </a>
                            <a href="{{ route('animales.index') }}" class="block text-center py-2 px-4 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors text-sm">
                                <i class="fas fa-edit mr-1"></i> CRUD de Especies
                            </a>
                        </div>
                    </div>
                    
                    {{-- 3. Tarjeta de Consultas (Usuario Regular) --}}
                    <div class="action-card bg-user">
                        <h3 class="text-xl font-bold text-cyan-700 mb-3"><i class="fas fa-paw mr-2"></i> Consultas / Juegos</h3>
                        <p class="text-gray-700 mb-4 text-sm">Acceso a fichas de especies, escaner y entretenimiento.</p>
                        
                        <div class="space-y-2 mt-4">
                            <a href="{{ route('consultas.animales') }}" class="block text-center py-2 px-4 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg transition-colors text-sm">
                                <i class="fas fa-search mr-1"></i> Acceder a Consultas
                            </a>
                            {{-- a href="{{ route('qr.scanner.ui') }}" --}}
                            <a href="{{ route('index') }}" class="block text-center py-2 px-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg transition-colors text-sm">
                                <i class="fas fa-qrcode mr-1"></i> Escanear QR
                            </a>
                            <a href="{{ route('juegos.futbol') }}" class="block text-center py-2 px-4 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded-lg transition-colors text-sm">
                                <i class="fas fa-gamepad mr-1"></i> Jugar Fútbol
                            </a>
                        </div>
                    </div>
                    @break
                    
                {{-- Opciones para GUARDAPARQUE (1 Tarjeta, Centrada) --}}
                @case('guardaparque')
                    <div class="action-card bg-green-100">
                        <h3 class="text-xl font-bold text-green-700 mb-3"><i class="fas fa-shield-alt mr-2"></i> Panel de Guardaparques</h3>
                        <p class="text-gray-700 mb-4 text-sm">Acceso a la gestión, creación de especies y uso de herramientas de campo.</p>
                        
                        <div class="space-y-3 mt-4">
                            <a href="{{ route('guardaparques.dashboard') }}" class="block text-center py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors">
                                <i class="fas fa-tachometer-alt mr-1"></i> Dashboard de Gestión
                            </a>
                            <a href="{{ route('animales.index') }}" class="block text-center py-3 px-4 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors">
                                <i class="fas fa-edit mr-1"></i> CRUD de Especies
                            </a>
                            {{-- a href="{{ route('qr.scanner.ui') }}" --}}
                            <a href="{{ route('index') }}" class="block text-center py-3 px-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg transition-colors">
                                <i class="fas fa-qrcode mr-1"></i> Escanear QR
                            </a>
                            <a href="{{ route('juegos.futbol') }}" class="block text-center py-3 px-4 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded-lg transition-colors">
                                <i class="fas fa-gamepad mr-1"></i> Jugar Fútbol
                            </a>
                        </div>
                    </div>
                    @break
                    
                {{-- Opciones para USUARIO REGULAR (1 Tarjeta, Centrada) --}}
                @case('user')
                    <div class="action-card bg-user">
                        <h3 class="text-xl font-bold text-cyan-700 mb-3"><i class="fas fa-paw mr-2"></i> Consultas y Exploración</h3>
                        <p class="text-gray-700 mb-4 text-sm">Acceso a fichas de especies, escaner y datos de monitoreo (solo lectura).</p>
                        
                        <div class="space-y-3 mt-4">
                            <a href="{{ route('consultas.animales') }}" class="block text-center py-3 px-4 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg transition-colors">
                                <i class="fas fa-search mr-1"></i> Acceder a Consultas
                            </a>
                            {{-- a href="{{ route('qr.scanner.ui') }}" --}}
                            <a href="{{ route('index') }}" class="block text-center py-3 px-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg transition-colors">
                                <i class="fas fa-qrcode mr-1"></i> Escanear QR
                            </a>
                            <a href="{{ route('juegos.futbol') }}" class="block text-center py-3 px-4 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded-lg transition-colors">
                                <i class="fas fa-gamepad mr-1"></i> Jugar Fútbol
                            </a>
                        </div>
                    </div>
                    @break
                    
                @default
                    <p class="col-span-3 text-center text-gray-500">Tu rol no tiene un panel asignado.</p>
            @endswitch
            
        </div>
        
        <div class="mt-12 text-center border-t pt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="py-2 px-6 bg-gray-200 text-gray-700 font-semibold rounded-full hover:bg-gray-300 transition-colors">
                    Cerrar Sesión <i class="fas fa-sign-out-alt ml-2"></i>
                </button>
            </form>
        </div>

    </div>

</body>

</html>
