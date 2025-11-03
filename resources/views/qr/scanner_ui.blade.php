@extends('layouts.dashboard')
@section('title', 'Escaneo de Código QR')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-b from-green-100 to-green-200 py-20">
    <!-- Tarjeta central -->
    <div class="bg-white shadow-2xl rounded-3xl p-16 w-full max-w-2xl border border-gray-200">
        <h1 class="text-5xl font-extrabold text-center text-gray-800 mb-8">Escanear Código QR del Animal</h1>
        <p class="text-center text-gray-600 text-xl mb-10">
            Coloque el cursor en el campo y escanee el código (ej: <span class="font-mono font-semibold text-xl">ANIMAL-1</span>)
        </p>

        <!-- Input de QR -->
        <div class="relative mb-10">
            <input type="text" id="qrInput" placeholder="Escanee aquí..." autofocus
                class="w-full px-8 py-6 rounded-3xl border border-gray-300 focus:ring-6 focus:ring-green-300 focus:outline-none text-center text-2xl font-mono shadow-md transition" />
            <span class="absolute right-8 top-1/2 transform -translate-y-1/2 text-gray-400 text-3xl">🔍</span>
        </div>

        <!-- Botones -->
        <div class="flex justify-between gap-8">
            <a href="{{ route('animales.index') }}"
               class="flex-1 bg-blue-500 text-white font-bold px-8 py-5 rounded-3xl text-center text-xl hover:bg-blue-600 transition">
               Lista de Animales
            </a>
            <a href="{{ route('welcome') }}"
               class="flex-1 bg-gray-400 text-white font-bold px-8 py-5 rounded-3xl text-center text-xl hover:bg-gray-500 transition">
               Volver al Inicio
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const qrInput = document.getElementById('qrInput');

    qrInput.addEventListener('input', () => {
        const value = qrInput.value.trim().toUpperCase();
        const match = /^ANIMAL-(\d+)$/.exec(value);

        if (match) {
            const id = match[1];
            setTimeout(() => {
                window.location.href = `/animales/ficha/${id}`;
            }, 800);
        }
    });
});
</script>
@endsection
