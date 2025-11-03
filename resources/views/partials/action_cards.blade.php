@php
    $isAdmin = $user->role === 'admin';
    $isGuardaparque = $user->role === 'guardaparque';
    $isUser = $user->role === 'user';
    $columns = $isAdmin ? 'md:grid-cols-3' : ($isGuardaparque ? 'md:grid-cols-2' : 'md:grid-cols-1');
    $padding = $isAdmin ? 'p-8 md:p-12' : ($isGuardaparque ? 'p-10 md:p-14' : 'p-12 md:p-16');
@endphp

<div class="grid grid-cols-1 {{ $columns }} gap-6 mb-8 mx-auto text-center">

    {{-- ADMIN --}}
    @if($isAdmin)
        <a href="{{ route('administracion.usuarios.index') }}"
            class="action-card bg-admin {{ $padding }} text-xl rounded-xl shadow-lg hover:scale-105 transition-transform">
            <i class="fas fa-users-cog mr-2"></i> Gestión de Usuarios
        </a>
        <a href="{{ route('admin.config') }}"
            class="action-card bg-admin {{ $padding }} text-xl rounded-xl shadow-lg hover:scale-105 transition-transform">
            <i class="fas fa-cogs mr-2"></i> Configuración de página web
        </a>
        <a href="{{ route('admin.iot') }}"
            class="action-card bg-admin {{ $padding }} text-xl rounded-xl shadow-lg hover:scale-105 transition-transform">
            <i class="fas fa-microchip mr-2"></i> Configuración IoT
        </a>
    @endif

    {{-- GUARDAPARQUE --}}
    @if($isGuardaparque || $isAdmin)
        <a href="{{ route('guardaparques.dashboard') }}"
            class="action-card bg-guardaparque {{ $padding }} text-xl rounded-xl shadow-lg hover:scale-105 transition-transform">
            <i class="fas fa-shield-alt mr-2"></i> Dashboard de Alarmas
        </a>
        <a href="{{ route('animales.index') }}"
            class="action-card bg-guardaparque {{ $padding }} text-xl rounded-xl shadow-lg hover:scale-105 transition-transform">
            <i class="fas fa-edit mr-2"></i> CRUD de Especies
        </a>
    @endif

    {{-- USUARIO GENERAL --}}
    <a href="{{ route('consultas.index') }}"
        class="action-card bg-user {{ $padding }} text-xl rounded-xl shadow-lg hover:scale-105 transition-transform">
        <i class="fas fa-paw mr-2"></i> Consultas
    </a>
    <a href="{{ route('qr.scanner.ui') }}"
        class="action-card bg-user {{ $padding }} text-xl rounded-xl shadow-lg hover:scale-105 transition-transform">
        <i class="fas fa-qrcode mr-2"></i> Escanear QR
    </a>
    <a href="{{ route('juegos.futbol') }}"
        class="action-card bg-user {{ $padding }} text-xl rounded-xl shadow-lg hover:scale-105 transition-transform">
        <i class="fas fa-gamepad mr-2"></i> Jugar Fútbol
    </a>
</div>