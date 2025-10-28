<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'BioTrack')</title>

  {{-- Aquí se cargarán los estilos de la vista hija (ej. game_page.css) --}}
  @yield('styles')

  <style>
    /* App Shell: layout base */
    .app {
      min-height: 100dvh;
      display: grid;
      grid-template-rows: 56px 1fr 40px;
    }

    header {
      backdrop-filter: saturate(160%) blur(8px);
      background: #0f172a;
      color: #fff;
    }

    nav a {
      color: #cbd5e1;
      margin-right: 16px;
      text-decoration: none
    }

    nav a.active,
    nav a:hover {
      color: #fff;
    }

    main {
      /* Mantenemos el fondo oscuro para el app_shell */
      background: #0b1220;
      color: #e5e7eb;
      padding: 20px
    }

    footer {
      background: #0f172a;
      color: #94a3b8;
      display: flex;
      align-items: center;
      justify-content: center
    }

    .container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 16px;
    }

    .badge {
      background: #22c55e;
      color: #0b1220;
      padding: 2px 8px;
      border-radius: 999px;
      font-size: 12px;
    }
  </style>
</head>

<body>
  <div class="app">
    <header>
      <div class="container" style="display:flex;align-items:center;justify-content:space-between;height:56px;">
        <div>
          <strong>BioTrack</strong>
          <span class="badge">v0.1</span>
        </div>
        <nav>
          <a href="{{ route('index') }}">Inicio</a>

          @auth
            {{-- ENLACE AL JUEGO AÑADIDO --}}
            <a href="{{ route('juegos.futbol') }}" class="{{ request()->routeIs('juegos.futbol') ? 'active' : '' }}">⚽
              Juego</a>

            <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">Dashboard</a>

            <a href="{{ route('animales.index') }}"
              class="{{ request()->routeIs('animales.*') ? 'active' : '' }}">Animales</a>
            <a href="{{ route('alertas.index') }}"
              class="{{ request()->routeIs('alertas.*') ? 'active' : '' }}">Alertas</a>

            <a href="{{ route('admin.config') }}" class="{{ request()->routeIs('admin.config') ? 'active' : '' }}">Guía
              IoT</a>

            <form method="POST" action="{{ route('logout') }}" style="display:inline">@csrf<button
                style="background:none;border:0;color:#fca5a5;cursor:pointer">Salir</button></form>
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