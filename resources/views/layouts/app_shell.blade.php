<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','BioTrack')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    /* App Shell: layout base */
    .app { min-height:100dvh; display:grid; grid-template-rows: 56px 1fr 40px; }
    header { backdrop-filter:saturate(160%) blur(8px); background:#0f172a; color:#fff; }
    nav a { color:#cbd5e1; margin-right:16px; text-decoration:none }
    nav a.active, nav a:hover { color:#fff; }
    main { background:#0b1220; color:#e5e7eb; padding:20px }
    footer { background:#0f172a; color:#94a3b8; display:flex; align-items:center; justify-content:center }
    .container { max-width:1100px; margin:0 auto; padding:0 16px; }
    .badge { background:#22c55e; color:#0b1220; padding:2px 8px; border-radius:999px; font-size:12px; }
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
        <a href="{{ route('home') }}">Inicio</a>
        @auth
          <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard')?'active':'' }}">Dashboard</a>
          <a href="{{ route('animals.index') }}" class="{{ request()->routeIs('animals.*')?'active':'' }}">Animales</a>
          <a href="{{ route('alerts.index') }}" class="{{ request()->routeIs('alerts.*')?'active':'' }}">Alertas</a>
          <a href="{{ route('iot.guide') }}" class="{{ request()->routeIs('iot.guide')?'active':'' }}">Guía IoT</a>
          <form method="POST" action="{{ route('logout') }}" style="display:inline">@csrf<button style="background:none;border:0;color:#fca5a5;cursor:pointer">Salir</button></form>
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
