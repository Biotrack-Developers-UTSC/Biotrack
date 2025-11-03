@extends('layouts.dashboard')
@section('title', 'Centro de Control - BioTrack')

@section('content')
    <style>
        /* 🎨 Animaciones y estilos del panel */
        .dashboard-card {
            flex: 1 1 280px;
            /* mínimo ancho 280px, crecer hasta llenar espacio */
            max-width: 320px;
            /* máximo ancho de cada tarjeta */
            padding: 2.2rem;
            border-radius: 1.25rem;
            background: white;
            border-left: 6px solid transparent;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            opacity: 0;
            transform: scale(0.95);
            animation: fadeZoomIn 0.8s ease forwards;
        }

        .dashboard-card:nth-child(1) {
            animation-delay: 0.2s;
        }

        .dashboard-card:nth-child(2) {
            animation-delay: 0.4s;
        }

        .dashboard-card:nth-child(3) {
            animation-delay: 0.6s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-big {
            display: block;
            width: 100%;
            padding: 1rem;
            border-radius: 0.9rem;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .btn-big:hover {
            transform: scale(1.03);
        }

        .bg-admin {
            border-color: #F87171;
        }

        .bg-guardaparque {
            border-color: #34D399;
        }

        .bg-user {
            border-color: #22D3EE;
        }

        @keyframes fadeZoomIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Rectángulo de bienvenida ligeramente más grande */
        .welcome-card {
            max-width: 700px;
            padding: 3rem 2.5rem;
            border-radius: 1.5rem;
            background: white;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .welcome-card h1 {
            font-size: 3.2rem;
            margin-bottom: 0.8rem;
        }

        .welcome-card h2 {
            font-size: 1.8rem;
            color: #4B5563;
        }

        /* Contenedor de tarjetas flexible */
        .cards-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        @media (max-width: 1024px) {
            .dashboard-card {
                max-width: 90%;
            }
        }
    </style>

    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 py-12">
        <!-- Rectángulo de bienvenida -->
        <div class="welcome-card animate-fadeIn">
            <h1>¡Bienvenido, {{ Auth::user()->name }}!</h1>
            <h2>Centro de Control BioTrack</h2>
        </div>

        @php $role = Auth::user()->role; @endphp

        <div class="cards-container">
            {{-- ADMIN --}}
            @if($role === 'admin')
                <div class="dashboard-card bg-admin">
                    <h3 class="text-xl font-bold text-red-700 mb-3">
                        <i class="fas fa-crown mr-2"></i> Administración
                    </h3>
                    <p class="text-gray-600 mb-4">Gestión del sistema y sensores IoT.</p>
                    <div class="space-y-3">
                        <a href="{{ route('admin.iot') }}" class="btn-big bg-red-600 text-white hover:bg-red-700">
                            <i class="fas fa-microchip mr-1"></i> Configuración IoT
                        </a>
                        <a href="{{ route('administracion.usuarios.index') }}"
                            class="btn-big bg-red-500 text-white hover:bg-red-600">
                            <i class="fas fa-users-cog mr-1"></i> Gestión de Usuarios
                        </a>
                        <a href="{{ route('admin.flujocorreo') }}" class="btn-big bg-red-400 text-white hover:bg-red-500">
                            <i class="fas fa-file-alt mr-1"></i> Documentación
                        </a>
                        <a href="{{ route('admin.config') }}" class="btn-big bg-red-300 text-white hover:bg-red-400">
                            <i class="fas fa-cogs mr-1"></i> Configuración General
                        </a>
                    </div>
                </div>
            @endif

            {{-- GUARDAPARQUE --}}
            @if(in_array($role, ['admin', 'guardaparque']))
                <div class="dashboard-card bg-guardaparque">
                    <h3 class="text-xl font-bold text-green-700 mb-3">
                        <i class="fas fa-shield-alt mr-2"></i> Panel de Guardaparques
                    </h3>
                    <p class="text-gray-600 mb-4">Monitoreo y control de especies.</p>
                    <div class="space-y-3">
                        <a href="{{ route('guardaparques.alertas.index') }}"
                            class="btn-big bg-green-500 text-white hover:bg-green-600">
                            <i class="fas fa-bell mr-1"></i> Consultar Alertas
                        </a>
                        <a href="{{ route('animales.index') }}" class="btn-big bg-green-400 text-white hover:bg-green-500">
                            <i class="fas fa-paw mr-1"></i> CRUD de Especies
                        </a>
                        <a href="{{ route('consultas.usuarios') }}" class="btn-big bg-green-300 text-white hover:bg-green-400">
                            <i class="fas fa-users mr-1"></i> Consultar Usuarios
                        </a>
                    </div>
                </div>
            @endif

            {{-- USUARIO --}}
            @if(in_array($role, ['admin', 'guardaparque', 'user']))
                <div class="dashboard-card bg-user">
                    <h3 class="text-xl font-bold text-cyan-700 mb-3">
                        <i class="fas fa-user mr-2"></i> Consultas y Juegos
                    </h3>
                    <p class="text-gray-600 mb-4">Explora especies, escanea QR o juega.</p>
                    <div class="space-y-3">
                        <a href="{{ route('consultas.index') }}" class="btn-big bg-cyan-600 text-white hover:bg-cyan-700">
                            <i class="fas fa-search mr-1"></i> Consultas
                        </a>
                        <a href="{{ route('qr.scanner.ui') }}" class="btn-big bg-cyan-500 text-white hover:bg-cyan-600">
                            <i class="fas fa-qrcode mr-1"></i> Escanear QR
                        </a>
                        <a href="{{ route('juegos.futbol') }}" class="btn-big bg-yellow-400 text-gray-900 hover:bg-yellow-500">
                            <i class="fas fa-futbol mr-1"></i> Jugar Fútbol
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection