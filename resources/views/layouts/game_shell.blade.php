<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Juego - BioTrack')</title>

    {{-- Tailwind + íconos --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Estilos generales opcionales --}}
    <style>
        body {
            background: linear-gradient(135deg, #C7F9CC, #80ED99);
            font-family: 'Poppins', sans-serif;
            color: #1B4332;
            min-height: 100vh;
        }

        /* 🔝 Navbar */
        .navbar {
            background-color: #064E3B;
            color: white;
            padding: 0.8rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .nav-links a {
            color: white;
            margin: 0 0.7rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: #A7F3D0;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .nav-user i {
            color: #A7F3D0;
        }

        /* 🎮 Contenido principal */
        main {
            padding: 1rem 1.5rem;
            max-width: 1200px;
            margin: 1rem auto 3rem auto;
        }

        footer {
            text-align: center;
            padding: 1rem 0;
            background: #064E3B;
            color: white;
            font-size: 0.9rem;
        }
    </style>

    {{-- Estilos específicos del juego --}}
    @yield('styles')
</head>

<body>

    {{-- 🔝 Navbar superior --}}
    <nav class="navbar">
        <div class="flex items-center gap-2">
            <i class="fas fa-futbol text-yellow-300 text-2xl"></i>
            <span class="font-bold text-lg">FutbolUT Godot</span>
        </div>

        <div class="nav-links hidden md:flex">
            <a href="{{ route('index') }}"><i class="fas fa-home mr-1"></i>Inicio</a>

            {{-- 🔴 ADMIN --}}
            @if(Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('admin.iot') }}"><i class="fas fa-microchip mr-1"></i> IoT</a>
                <a href="{{ route('administracion.usuarios.index') }}"><i class="fas fa-users-cog mr-1"></i> Usuarios</a>
                <a href="{{ route('admin.config') }}"><i class="fas fa-cogs mr-1"></i> Config</a>
            @endif

            {{-- 🟢 GUARDAPARQUE --}}
            @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'guardaparque']))
                <a href="{{ route('guardaparques.alertas.index') }}"><i class="fas fa-bell mr-1"></i> Alertas</a>
                <a href="{{ route('animales.index') }}"><i class="fas fa-paw mr-1"></i> Especies</a>
            @endif

            {{-- 🔵 USUARIO --}}
            @if(Auth::check())
                <a href="{{ route('consultas.index') }}"><i class="fas fa-search mr-1"></i> Consultas</a>
                <a href="{{ route('qr.scanner.ui') }}"><i class="fas fa-qrcode mr-1"></i> Escanear</a>
                <a href="{{ route('juegos.futbol') }}" class="text-yellow-300 font-semibold"><i
                        class="fas fa-futbol mr-1"></i> Juego</a>
            @endif
        </div>

        <div class="nav-user">
            @auth
                <i class="fas fa-user-circle text-2xl"></i>
                <span class="font-medium">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" title="Cerrar sesión"
                        class="ml-2 bg-red-500 hover:bg-red-600 text-white rounded-full px-3 py-1 text-sm font-medium">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-white hover:text-yellow-300 font-semibold"><i
                        class="fas fa-sign-in-alt mr-1"></i> Entrar</a>
            @endauth
        </div>
    </nav>

    {{-- 🎮 Contenido principal --}}
    <main>
        @yield('content')
    </main>

    {{-- ⚽ Footer simple --}}
    <footer>
        © {{ date('Y') }} FutbolUT Godot — Proyecto BioTrack Games
    </footer>

</body>

</html>