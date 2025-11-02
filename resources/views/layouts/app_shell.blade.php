<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'BioTrack')</title>

  {{-- Variables dinámicas para colores, hero, etc. --}}
  <style>
      :root {
          --primary-color: {{ $config['primary_color'] ?? '#FF5733' }};
          --secondary-color: {{ $config['secondary_color'] ?? '#C70039' }};
          --hero-bg: url('{{ $config['hero_bg'] ?? 'https://placehold.co/1920x800/0b1220/ffffff?text=Fondo+de+Cancha' }}');
          --text-color: {{ $config['text_color'] ?? '#ffffff' }};
          --accent-color: {{ $config['accent_color'] ?? '#FFD700' }};
      }
  </style>

  {{-- Aquí cargamos los estilos de cada página --}}
  @yield('styles')
</head>

<body>
  <div class="app">
    <header>
      <div class="container header-content">
        <div>
          <strong>BioTrack</strong>
          <span class="badge">v0.1</span>
        </div>
        <nav>
          <a href="{{ route('index') }}">Inicio</a>
          @auth
            <a href="{{ route('juegos.futbol') }}" class="{{ request()->routeIs('juegos.futbol') ? 'active' : '' }}">⚽ Juego</a>
            <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('animales.index') }}" class="{{ request()->routeIs('animales.*') ? 'active' : '' }}">Animales</a>
            <a href="{{ route('alertas.index') }}" class="{{ request()->routeIs('alertas.*') ? 'active' : '' }}">Alertas</a>
            <a href="{{ route('admin.config') }}" class="{{ request()->routeIs('admin.config') ? 'active' : '' }}">Guía IoT</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">@csrf
              <button style="background:none;border:0;color:#fca5a5;cursor:pointer">Salir</button>
            </form>
          @else
            <a href="{{ route('login') }}">Entrar</a>
            <a href="{{ route('register') }}">Registro</a>
          @endauth
        </nav>
      </div>
    </header>

    <main>
      <div class="container">
        @yield('content')
      </div>
    </main>

    <footer>
      <div class="container">© BioTrack {{ date('Y') }}</div>
    </footer>
  </div>
</body>

</html>
