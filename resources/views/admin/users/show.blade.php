@extends('layouts.dashboard')
@section('title', 'Detalles de Usuario: ' . $usuario->name)

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-red-700">

            <header class="mb-8 flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800">{{ $usuario->name }}</h1>
                    <p class="text-gray-500 mt-1">Detalle de la cuenta y permisos.</p>
                </div>
                <a href="{{ route('administracion.usuarios.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </header>

            <div class="space-y-6">

                {{-- Tarjeta de Rol --}}
                <div class="p-4 rounded-lg bg-red-50 border border-red-200 flex items-center justify-between">
                    <p class="text-lg font-semibold text-red-700">Rol Asignado:</p>
                    @php
                        $roleClass = match ($usuario->role) {
                            'admin' => 'bg-red-700',
                            'guardaparque' => 'bg-green-700',
                            default => 'bg-blue-700',
                        };
                    @endphp
                    <span class="px-4 py-1 text-white font-bold rounded-full {{ $roleClass }} uppercase shadow-md">
                        {{ $usuario->role }}
                    </span>
                </div>

                {{-- Detalles de Contacto --}}
                <div class="border-t pt-4">
                    <p class="text-lg font-semibold text-gray-700 mb-3">Información de la Cuenta:</p>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 w-6 mr-3"></i>
                            <p>Email: <span class="font-medium text-gray-900">{{ $usuario->email }}</span></p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-gray-400 w-6 mr-3"></i>
                            {{-- Asegúrate de que $usuario->created_at sea un objeto Carbon --}}
                            <p>Miembro desde: <span
                                    class="font-medium text-gray-900">{{ $usuario->created_at->format('d M, Y') }}</span>
                            </p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-gray-400 w-6 mr-3"></i>
                            <p>Verificación Email:
                                <span class="font-medium text-gray-900">
                                    @if($usuario->email_verified_at)
                                        ✅ Verificado ({{ $usuario->email_verified_at->format('Y-m-d') }})
                                    @else
                                        ❌ Pendiente
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Botón de Edición --}}
                <div class="mt-8 border-t pt-6 text-center">
                    <a href="{{ route('administracion.usuarios.edit', $usuario) }}"
                        class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                        <i class="fas fa-pencil-alt mr-2"></i> Editar Registro
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection