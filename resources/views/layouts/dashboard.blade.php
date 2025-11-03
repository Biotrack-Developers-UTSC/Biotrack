<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel - BioTrack')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #A7F3D0, #7DD3FC);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        .navbar {
            background-color: #064E3B;
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .nav-links a {
            color: #fff;
            margin: 0 0.75rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: #A7F3D0;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-user i {
            color: #A7F3D0;
        }

        main {
            padding: 2rem;
            max-width: 1400px;
            margin: 3rem auto;
        }
    </style>
</head>

<body>
    {{-- 🟩 Navbar superior --}}
    <nav class="navbar">
        <div class="flex items-center gap-2">
            <i class="fas fa-leaf text-green-300 text-2xl"></i>
            <span class="font-bold text-lg">BioTrack</span>
        </div>

        <div class="nav-links hidden md:flex">
            <a href="{{ route('index') }}"><i class="fas fa-home mr-1"></i>Inicio</a>

            {{-- 🔴 ADMIN --}}
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.iot') }}"><i class="fas fa-microchip mr-1"></i> IoT</a>
                <a href="{{ route('administracion.usuarios.index') }}"><i class="fas fa-users-cog mr-1"></i> Usuarios</a>
                <a href="{{ route('admin.config') }}"><i class="fas fa-cogs mr-1"></i> Config</a>
                <a href="{{ route('admin.flujocorreo') }}"><i class="fas fa-file-alt mr-1"></i> Docs</a>
            @endif

            {{-- 🟢 GUARDAPARQUE --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'guardaparque')
                <a href="{{ route('guardaparques.alertas.index') }}"><i class="fas fa-bell mr-1"></i> Alertas</a>
                <a href="{{ route('animales.index') }}"><i class="fas fa-paw mr-1"></i> Especies</a>
            @endif

            {{-- 🔵 USUARIO --}}
            @if(in_array(Auth::user()->role, ['admin', 'guardaparque', 'user']))
                <a href="{{ route('consultas.index') }}"><i class="fas fa-search mr-1"></i> Consultas</a>
                <a href="{{ route('qr.scanner.ui') }}"><i class="fas fa-qrcode mr-1"></i> Escanear</a>
                <a href="{{ route('juegos.futbol') }}"><i class="fas fa-futbol mr-1"></i> Juego</a>
            @endif
        </div>

        <div class="nav-user">
            <i class="fas fa-user-circle text-2xl"></i>
            <span class="font-medium">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" title="Cerrar sesión"
                    class="ml-2 bg-red-500 hover:bg-red-600 text-white rounded-full px-3 py-1 text-sm font-medium">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </nav>

    {{-- 🧭 Contenido dinámico --}}
    <main>
        @yield('content')
    </main>
</body>

</html>