@extends('layouts.game_shell')
@section('title', 'UTSC Soccer Legends - Juego Oficial')

@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/game_page.css') }}">
    <style>
        /* Variables de color temático (Basado en los colores BioTrack/UTSC y del juego) */
        :root {
            --primary-color: #2e7d32;
            /* Verde Oscuro UTSC/BioTrack */
            --secondary-color: #fdd835;
            /* Amarillo de la Pelota/Éxito */
            --accent-color: #e53935;
            /* Rojo de Alertas/Fuerza */
            --text-color: #ffffff;
            --hero-bg: url('{{ asset('images/hero-bg-soccer.jpg') }}');
            /* Imagen de fondo para el Hero */
            --dark-background: #1e1e1e;
            /* Fondo oscuro para contraste */
        }

        /* Estilos base */
        .game-frame-container {
            display: flex;
            justify-content: center;
            margin: 40px 0;
        }

        .game-frame {
            width: 90%;
            max-width: 900px;
            height: 600px;
            border: 5px solid var(--secondary-color);
            border-radius: 12px;
            background-color: var(--dark-background);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }

        .game-frame:hover {
            transform: translateY(-5px);
        }

        /* Estilos del Botón de Descarga (Download) */
        .download-btn {
            display: inline-block;
            background-color: var(--secondary-color);
            color: var(--dark-background);
            font-weight: bold;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin: 10px 15px;
        }

        .download-btn:hover {
            background-color: #ffea75;
            transform: scale(1.05);
        }

        /* Nueva clase para tarjetas oscuras y contrastantes */
        .feature-card.dark {
            background: var(--dark-background);
            color: var(--text-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-card.dark .feature-icon i {
            color: var(--secondary-color);
        }

        /* Estilo para hacer las imágenes clickeables */
        .screenshot img {
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .screenshot img:hover {
            opacity: 0.8;
        }

        /* ===== ESTILOS PARA EL MODAL DE LA GALERÍA ===== */
        .modal {
            display: none;
            /* Oculto por defecto */
            position: fixed;
            z-index: 2000;
            /* Asegura que esté por encima de todo */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
            /* Fondo negro semi-transparente */
            padding-top: 60px;
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 90%;
            max-width: 1200px;
            max-height: 80%;
            object-fit: contain;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')

    <div class="hero">
        <div class="hero-content container" style="text-align: center; margin: 0 auto; max-width: 900px;">
            <span class="tagline">La Leyenda del Fútbol Universitario Comienza Aquí</span>
            <h1>UTSC Soccer Legends</h1>
            <p style="text-align: center; margin: 15px auto 20px auto;">
                Proyecto integrador de 10mo tetra que se trata de un juego basado en el mundial 2025 para la valoracion
                del proyecto junto con la pagina web: BioTrack. Selecciona tu equipo, domina los controles de **Movimiento,
                Patada y Tacleo**
                y demuestra tus habilidades en el campo de fútbol 2D.
            </p>
            {{-- ===== Botones de Acción (Grandes y Centrados) ===== --}}
            <section class="hero-actions" style="text-align: center; padding: 40px 20px 0;">
                <a href="#jugar" class="btn" style="font-size: 1.5rem; padding: 15px 40px; margin: 10px;">
                    ⚽ Jugar Ahora
                </a>
                <a href="#download" class="btn btn-secondary" style="font-size: 1.5rem; padding: 15px 40px; margin: 10px;">
                    ⬇️ Descargar Beta
                </a>
            </section>
        </div>
    </div>

    {{-- ===== Características Clave (2x2) ===== --}}
    <section id="features" class="features bg-dark">
        <div class="container">
            <h2 class="section-title">Características Clave</h2>

            {{-- Estilo 2x2: Usamos grid y limitamos la repetición a 2 --}}
            <div class="features-grid" style="grid-template-columns: repeat(2, 1fr); max-width: 900px; margin: auto;">

                {{-- Característica 1 --}}
                <div class="feature-card dark">
                    <div class="feature-icon"><i class="fas fa-desktop"></i></div>
                    <h3>Jugabilidad 2D Clásica</h3>
                    <p>Movimientos y física que incluyen **colisiones de jugadores y pelota**, tiros y pases precisos.</p>
                </div>

                {{-- Característica 2 --}}
                <div class="feature-card dark">
                    <div class="feature-icon"><i class="fas fa-robot"></i></div>
                    <h3>IA Adaptativa</h3>
                    <p>Los oponentes CPU taclean, patean y el **portero realiza bloqueos** con 'dives'.</p>
                </div>

                {{-- Característica 3 --}}
                <div class="feature-card dark">
                    <div class="feature-icon"><i class="fas fa-hand-rock"></i></div>
                    <h3>Controles Dinámicos</h3>
                    <p>Capacidad de controlar **dos jugadores a la vez** y campo de visión para pases estratégicos.</p>
                </div>

                {{-- Característica 4 --}}
                <div class="feature-card dark">
                    <div class="feature-icon"><i class="fas fa-trophy"></i></div>
                    <h3>Sistema de Torneos</h3>
                    <p>Participa en ligas y campeonatos para alcanzar la gloria y desbloquear celebraciones de
                        victoria/derrota.</p>
                </div>

            </div>
        </div>
    </section>

    <section id="jugar" class="features bg-light">
        <div class="container">
            <h2 class="section-title">🕹️ Demo Web: Juega al Instante</h2>

            <div class="game-frame-container">
                <iframe src="{{ asset('game/index.html') }}" class="game-frame" allowfullscreen loading="lazy">
                </iframe>

            </div>

            <p style="text-align:center; color: #555; margin-bottom: 25px;">Si tienes problemas de carga, la versión
                descargable ofrece un rendimiento óptimo.</p>

            <div style="text-align:center;">
                <a href="{{ asset('game.zip') }}" class="download-btn download-primary" download>
                    <i class="fas fa-laptop-code"></i> Descargar Demo Web (.zip)
                </a>
                <a href="{{ asset('Manual_Usuario_UTSC_Soccer_Legends.pdf') }}" target="_blank"
                    class="download-btn download-secondary">
                    <i class="fas fa-book"></i> Manual de Usuario
                </a>
            </div>
        </div>
    </section>

    {{-- ===== Galería de Capturas (Añadido atributo onclick) ===== --}}
    <section class="screenshots bg-dark">
        <div class="container">
            <h2 class="section-title text-white">Galería de Capturas</h2>
            <div class="screenshots-grid">
                {{-- Cada imagen llama a la función JS showModal con su propia ruta --}}
                <div class="screenshot"><img src="{{ asset('game/game_image1.png') }}" alt="Campo de Juego Completo"
                        onclick="showModal(this.src)"></div>
                <div class="screenshot"><img src="{{ asset('game/game_image2.png') }}" alt="Menú principal del videojuego"
                        onclick="showModal(this.src)">
                </div>
                <div class="screenshot"><img src="{{ asset('game/game_image3.png') }}" alt="Pantalla de inicio del juego"
                        onclick="showModal(this.src)">
                </div>
                <div class="screenshot"><img src="{{ asset('game/game_image4.png') }}"
                        alt="Selección de equipos con uniformes" onclick="showModal(this.src)"></div>
            </div>
        </div>
    </section>

    <section class="history features bg-light">
        <h2 class="section-title">Historia y Vínculo BioTrack</h2>
        <p style="text-align:center; max-width:800px; margin:auto;">
            **UTSC Soccer Legends** es el componente de **Gamificación** del proyecto integrador BioTrack, buscando integrar
            entretenimiento y educación. El juego te lleva al **Mundial 2025** donde compites tras pasar un **Quiz de
            preguntas relacionadas con BioTrack**, facilitando el aprendizaje sobre la conservación digital.
        </p>
    </section>

    <section class="teams features bg-dark">
        <div class="container">
            <h2 class="section-title text-white">Equipos y Personalización</h2>
            <div class="features-grid">
                <div class="feature-card dark">
                    <div class="feature-icon"><i class="fas fa-robot"></i></div>
                    <h3>Registro de Skins</h3>
                    <p>Elige entre una variedad de **texturas para skins y uniformes** para crear tu equipo ideal,
                        incluyendo banderas.</p>
                </div>
                <div class="feature-card dark">
                    <div class="feature-icon"><i class="fas fa-robot"></i></div>
                    <h3>Personalización de Avatares</h3>
                    <p>Selecciona tu avatar y personaje para tener una experiencia de juego única.</p>
                </div>
                <div class="feature-card dark">
                    <div class="feature-icon"><i class="fas fa-robot"></i></div>
                    <h3>Control de la Liga</h3>
                    <p>Los equipos CPU tienen **etiquetas de control (Humano/IA)** y se agregan manualmente para equipos de
                        6 personas.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="requirements" class="features bg-light">
        <div class="container">
            <h2 class="section-title">⚙️ Requisitos del Sistema y Controles</h2>
            <div class="requirements-grid features-grid">
                <div class="feature-card">
                    <h3>Requisitos del Sistema</h3>
                    <ul>
                        <li>Sistema Operativo: Windows, macOS, o Linux.</li>
                        <li>Procesador: Recomendado Dual Core 2.0 GHz o superior.</li>
                        <li>Memoria: 2 GB de RAM o más.</li>
                        <li>**Requisitos Previos**: Revisar el Manual de Usuario Antes de Instalar.</li>
                    </ul>
                </div>
                <div class="feature-card">
                    <h3>Controles del Videojuego</h3>
                    <p>Los controles son intuitivos, con acciones específicas para:</p>
                    <ul>
                        <li>Movimiento del Jugador (Detección de tacleo y patada al estar cerca).</li>
                        <li>Tiro y Patada (Animación visible de pelota pateada).</li>
                        <li>Pases (Pases por encima si estás lejos, patada si estás cerca).</li>
                    </ul>
                </div>
                <div class="feature-card">
                    <h3>Objetivo del Jugador</h3>
                    <p>El objetivo es anotar goles mientras la IA rival intenta evitarlo, utilizando las habilidades de
                        tacleo, tiro y la coordinación de tus dos jugadores activos.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="download" class="download bg-dark">
        <div class="container" style="text-align:center;">
            <h2 class="section-title text-white">¡Descarga UTSC Soccer Legends (Versión Beta)!</h2>
            <p style="color: lightgray; max-width:700px; margin:auto; margin-bottom:30px;">
                La Versión Beta del videojuego está disponible. ¡Descárgala para realizar tus pruebas y envía tu **Reporte
                de Pruebas**!
            </p>
            <div>
                <a href="{{ asset('downloads/FutbolUT_Windows_Beta.zip') }}" class="download-btn" download>Descargar para
                    Windows</a>
                <a href="{{ asset('downloads/FutbolUT_macOS_Beta.zip') }}" class="download-btn" download>Descargar para
                    macOS</a>
                <a href="{{ asset('downloads/FutbolUT_Linux_Beta.zip') }}" class="download-btn" download>Descargar para
                    Linux</a>
            </div>
            <p style="color: #bbb; margin-top: 20px;">*Revisa el Manual de Usuario para los pasos de instalación y posibles
                errores/soluciones.*</p>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        // Obtener el elemento del modal
        var modal = document.getElementById("imageModal");

        // Obtener la imagen dentro del modal y la fuente de la imagen
        var modalImg = document.getElementById("modalImage");

        // Función para mostrar el modal con la imagen clickeada
        function showModal(imageSrc) {
            modal.style.display = "block";
            modalImg.src = imageSrc;
        }

        // Función para cerrar el modal
        function closeModal() {
            modal.style.display = "none";
        }

        // Opcional: Cerrar el modal al hacer clic fuera de la imagen
        window.onclick = function (event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
@endsection

{{-- ===== ESTRUCTURA DEL MODAL (Añadir al final del

<body> de layouts/game_shell.blade.php o aquí) ===== --}}
    {{-- Se recomienda colocar esto al final del

    <body> del layout principal para que esté disponible en cualquier página --}}
        {{-- Si no tienes acceso al layout, puedes agregarlo justo antes de @endsection --}}
        <div id="imageModal" class="modal" onclick="closeModal()">
            <span class="close">&times;</span>
            <img class="modal-content" id="modalImage">
        </div>