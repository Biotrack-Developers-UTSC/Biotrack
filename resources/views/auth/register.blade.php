<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioTrack - Registro</title>
    <link rel="stylesheet" href="{{ asset('styles/authloginregister.css') }}">
</head>

<body>
    <div class="auth-card">
        <div class="auth-header">
            <span class="text-3xl">📝</span>
            <h2>Registro de Usuario</h2>
        </div>

        {{-- ¡CORRECCIÓN CLAVE! Usar la ruta POST para el registro --}}
        <form method="POST" action="{{ route('register.post') }}" id="registerForm">
            @csrf

            <div class="input-group">
                <label for="nombre" style="display: block; font-weight: 500; margin-bottom: 5px;">Nombre</label>
                <input id="nombre" type="text" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name" placeholder="Tu Nombre Completo" />
                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
            </div>

            <div class="input-group">
                <label for="correo" style="display: block; font-weight: 500; margin-bottom: 5px;">Correo
                    Electrónico</label>
                <input id="correo" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    placeholder="tu.correo@biotrack.org" />
                @error('email') <p class="text-danger">{{ $message }}</p> @enderror
            </div>

            <div class="input-group">
                <label for="contraseña" style="display: block; font-weight: 500; margin-bottom: 5px;">Contraseña</label>
                <input id="contraseña" type="password" name="password" required autocomplete="new-password"
                    placeholder="••••••••" />
                @error('password') <p class="text-danger">{{ $message }}</p> @enderror
            </div>

            <div class="input-group">
                <label for="password_confirmation"
                    style="display: block; font-weight: 500; margin-bottom: 5px;">Confirmar Contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="••••••••" />
                @error('password_confirmation') <p class="text-danger">{{ $message }}</p> @enderror
            </div>

            <div class="password-checklist">
                <p style="font-weight: 600; margin-bottom: 5px;">Tu contraseña debe contener:</p>
                <ul>
                    <li id="checkLength">❌ Al menos 8 caracteres</li>
                    <li id="checkUpper">❌ Una letra mayúscula</li>
                    <li id="checkNumber">❌ Un número</li>
                    <li id="checkSpecial">❌ Un carácter especial (!@#$%^&*)</li>
                </ul>
            </div>

            <button type="submit" class="btn-primary">
                Registrarse
            </button>
        </form>

        <p style="text-align: center; margin-top: 25px; font-size: 0.9rem; color: #4b6456;">
            <a class="auth-link" href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión aquí</a>
        </p>

        <a class="btn-secondary" href="{{ route('index') }}">
            ← Volver al Inicio
        </a>
    </div>

    <script>
        // Lógica de validación de contraseña en tiempo real
        const passwordInput = document.getElementById("contraseña");
        const checkLength = document.getElementById("checkLength");
        const checkUpper = document.getElementById("checkUpper");
        const checkNumber = document.getElementById("checkNumber");
        const checkSpecial = document.getElementById("checkSpecial");

        passwordInput.addEventListener("input", () => {
            const pwd = passwordInput.value;

            // Función para actualizar el texto y el emoji
            const updateCheck = (element, condition, text) => {
                const emoji = condition ? "✅" : "❌";
                element.textContent = `${emoji} ${text}`;
            };

            // Comprobaciones
            updateCheck(checkLength, pwd.length >= 8, "Al menos 8 caracteres");
            updateCheck(checkUpper, /[A-Z]/.test(pwd), "Una letra mayúscula");
            updateCheck(checkNumber, /[0-9]/.test(pwd), "Un número");
            updateCheck(checkSpecial, /[!@#$%^&*]/.test(pwd), "Un carácter especial (!@#$%^&*)");
        });
    </script>
</body>

</html>