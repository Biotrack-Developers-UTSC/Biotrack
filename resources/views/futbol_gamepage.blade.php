@extends('layouts.app_shell')

@section('title', 'Juego de Fútbol Godot')

@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/game_page.css') }}">
@endsection

@section('content')

    <!-- ===== Hero ===== -->
    <div class="hero">
        <div class="hero-content">
            <h1>¡Bienvenido a FutbolUT Godot!</h1>
            <p>Selecciona tu equipo, compite en torneos y demuestra tus habilidades en la cancha.</p>
            <a href="#features" class="btn">Ver Características</a>
        </div>
    </div>

    <!-- ===== Características ===== -->
    <section id="features" class="features">
        <h2 class="section-title">Características del Juego</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-futbol"></i></div>
                <h3>Partidos Realistas</h3>
                <p>Movimientos y física similares a un partido real de fútbol.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-users"></i></div>
                <h3>Multijugador</h3>
                <p>Compite con amigos o jugadores de todo el mundo en tiempo real.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-trophy"></i></div>
                <h3>Torneos</h3>
                <p>Participa en ligas y campeonatos con diferentes niveles de dificultad.</p>
            </div>
        </div>
    </section>

    <!-- ===== Capturas del Juego ===== -->
    <section class="screenshots">
        <h2 class="section-title">Capturas del Juego</h2>
        <div class="screenshots-grid">
            <div class="screenshot"><img src="https://placehold.co/400x250/0b1220/fff?text=Cancha+1" alt="Cancha 1"></div>
            <div class="screenshot"><img src="https://placehold.co/400x250/0b1220/fff?text=Cancha+2" alt="Cancha 2"></div>
            <div class="screenshot"><img src="https://placehold.co/400x250/0b1220/fff?text=Cancha+3" alt="Cancha 3"></div>
            <div class="screenshot"><img src="https://placehold.co/400x250/0b1220/fff?text=Cancha+4" alt="Cancha 4"></div>
        </div>
    </section>

    <!-- ===== Historia del Juego ===== -->
    <section class="history features">
        <h2 class="section-title">Historia</h2>
        <p style="text-align:center; max-width:800px; margin:auto;">
            FutbolUT Godot nace como un proyecto estudiantil para recrear la emoción del fútbol en 2D con Godot.
            Crea tu equipo, participa en ligas y vive la pasión del fútbol desde tu computadora o dispositivo.
        </p>
    </section>

    <!-- ===== Equipos ===== -->
    <section class="teams features">
        <h2 class="section-title">Equipos Disponibles</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>Equipo A</h3>
                <p>Descripción breve del equipo, estilo de juego y fortalezas.</p>
            </div>
            <div class="feature-card">
                <h3>Equipo B</h3>
                <p>Descripción breve del equipo, estilo de juego y fortalezas.</p>
            </div>
            <div class="feature-card">
                <h3>Equipo C</h3>
                <p>Descripción breve del equipo, estilo de juego y fortalezas.</p>
            </div>
        </div>
    </section>

    <!-- ===== Torneos ===== -->
    <section class="tournaments features">
        <h2 class="section-title">Torneos y Ligas</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>Liga Local</h3>
                <p>Participa en ligas locales y sube en el ranking.</p>
            </div>
            <div class="feature-card">
                <h3>Copa Nacional</h3>
                <p>Compite con equipos de todo el país para ser campeón.</p>
            </div>
            <div class="feature-card">
                <h3>Torneo Internacional</h3>
                <p>Enfréntate a jugadores de otros países y demuestra tu nivel.</p>
            </div>
        </div>
    </section>

    <!-- ===== Descarga del Juego ===== -->
    <section class="download features">
        <h2 class="section-title">Descargar Juego</h2>
        <p style="text-align:center; max-width:700px; margin:auto; margin-bottom:20px;">
            Descarga FutbolUT Godot y empieza a jugar hoy mismo. Compatible con Windows, macOS y Linux.
        </p>
        <div style="text-align:center;">
            <a href="#" class="btn">Descargar para Windows</a>
            <a href="#" class="btn">Descargar para macOS</a>
            <a href="#" class="btn">Descargar para Linux</a>
        </div>
    </section>

@endsection