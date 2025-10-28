@extends('layouts.app_shell')
@section('title', 'World Soccer Games')

@section('styles')
    {{-- Carga el CSS específico del juego --}}
    <link rel="stylesheet" href="{{ asset('styles/game_page.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    {{-- Contenido de la Página de Venta/Información del Juego --}}

    <section class="hero" id="inicio">
        <div class="container">
            <div class="hero-content">
                <h1>Vive la emoción del fútbol como nunca antes</h1>
                <p>World_Soccer_Games-2025-Edition te ofrece la experiencia de fútbol más realista y emocionante con modos
                    de juego innovadores, muy divertido y entretenido.</p>
                <a href="#descargar" class="btn">Descargar Ahora</a>
            </div>
        </div>
    </section>

    <section class="features" id="caracteristicas">
        <div class="container">
            <h2 class="section-title">Características Principales</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-futbol"></i></div>
                    <h3>Divertido y Entretenido</h3>
                    <p>Disfruta del videojuego que te hará sentir en el campo de juego.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-users"></i></div>
                    <h3>Multijugador</h3>
                    <p>Compite contra jugadores de todo el mundo en emocionantes partidos online.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-trophy"></i></div>
                    <h3>Modo Carrera</h3>
                    <p>Conviértete en manager y lleva a tu equipo a la gloria en el modo carrera.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-tshirt"></i></div>
                    <h3>Equipos y Ligas</h3>
                    <p>Juega con más de 700 equipos oficiales de las mejores ligas del mundo.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-gamepad"></i></div>
                    <h3>Controles Intuitivos</h3>
                    <p>Sistema de controles fácil de aprender pero difícil de dominar.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-video"></i></div>
                    <h3>Comentarios Reales</h3>
                    <p>Comentarios de locutores profesionales que dan vida a cada partido.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="screenshots" id="capturas">
        <div class="container">
            <h2 class="section-title">Capturas del Juego</h2>
            <div class="screenshots-grid">
                <div class="screenshot">
                    <img src="https://placehold.co/1350x700/0b1220/ffffff?text=Captura+de+Partido"
                        alt="Captura de partido en estadio">
                </div>
                <div class="screenshot">
                    <img src="https://placehold.co/1350x700/0b1220/ffffff?text=Celebración+de+Gol"
                        alt="Captura de celebración de gol">
                </div>
                <div class="screenshot">
                    <img src="https://placehold.co/1350x700/0b1220/ffffff?text=Vista+Aérea+del+Estadio"
                        alt="Captura de vista aérea">
                </div>
                <div class="screenshot">
                    <img src="https://placehold.co/1350x700/0b1220/ffffff?text=Menú+Principal"
                        alt="Captura de menú principal">
                </div>
            </div>
        </div>
    </section>

    <section class="download" id="descargar">
        <div class="container">
            <div class="download-content">
                <h2 class="section-title">Descarga World_Soccer_Games-2025-Edition</h2>
                <p>¡No esperes más! Descarga ahora y comienza a vivir la experiencia de fútbol más emocionante.</p>
                <a href="#" class="btn download-btn"><i class="fas fa-download"></i> Descargar Gratis</a>

                <div class="system-requirements">
                    <h3>Requisitos del Sistema</h3>
                    <div class="requirements-grid">
                        <div class="requirement">
                            <h4>Mínimos</h4>
                            <ul>
                                <li>Windows 10 64-bit</li>
                                <li>Intel Core i5-3550 / AMD FX 8150</li>
                                <li>4 GB RAM</li>
                                <li>NVIDIA GTX 660 / AMD Radeon R9 270</li>
                                <li>5 GB espacio disponible</li>
                            </ul>
                        </div>
                        <div class="requirement">
                            <h4>Recomendados</h4>
                            <ul>
                                <li>Windows 11 64-bit</li>
                                <li>Intel Core i7-6700 / AMD Ryzen 5 1600</li>
                                <li>8 GB RAM</li>
                                <li>NVIDIA GTX 1060 / AMD RX 580</li>
                                <li>10 GB espacio disponible</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="platforms">
                    <h3>Disponible en:</h3>
                    <div class="platforms-grid">
                        <div class="platform"><i class="fab fa-windows"></i><span>Windows</span></div>
                        <div class="platform"><i class="fab fa-playstation"></i><span>PlayStation</span></div>
                        <div class="platform"><i class="fab fa-xbox"></i><span>Xbox</span></div>
                        <div class="platform"><i class="fab fa-apple"></i><span>macOS</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Script JavaScript de Animación --}}
    <script>
        // Smooth scrolling para los enlaces de navegación
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Efecto de cambio de color del header al hacer scroll
        window.addEventListener('scroll', function () {
            const header = document.querySelector('header');
            if (header) {
                if (window.scrollY > 100) {
                    header.style.backgroundColor = 'rgba(0, 0, 0, 0.95)';
                } else {
                    header.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                }
            }
        });

        // Efecto de animación para los botones de descarga
        const downloadBtn = document.querySelector('.download-btn');
        if (downloadBtn) {
            downloadBtn.addEventListener('mouseover', function () {
                this.style.transform = 'scale(1.05)';
            });
            downloadBtn.addEventListener('mouseout', function () {
                this.style.transform = 'scale(1)';
            });
        }
    </script>
@endsection