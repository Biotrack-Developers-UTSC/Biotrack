@extends('layouts.app')
@section('title', 'Editar Usuario: ' . $usuario->name)

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-red-500">
        <header class="mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800">Editar Usuario: {{ $usuario->name }}</h1>
            <p class="text-gray-500">Modifica los datos del usuario y asigna un nuevo rol o contraseña.</p>
        </header>

        <form action="{{ route('administracion.usuarios.update', $usuario) }}" method="post">
            @csrf
            @method('PATCH')

            {{-- CAMPO: NOMBRE COMPLETO --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo <span
                        class="text-red-500">*</span></label>
                <input type="text"
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                    id="name" name="name" value="{{ old('name', $usuario->name) }}" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- CAMPO: EMAIL (Debe ser único, por eso se ignora el ID actual) --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail <span
                        class="text-red-500">*</span></label>
                <input type="email"
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                    id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- CAMPO: ROL --}}
            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700">Rol de Acceso <span
                        class="text-red-500">*</span></label>
                <select id="role" name="role" required
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    @foreach(['user', 'guardaparque', 'admin'] as $role)
                        <option value="{{ $role }}" {{ old('role', $usuario->role) == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <h3 class="text-lg font-semibold text-gray-700 mb-3 border-t pt-4">Cambiar Contraseña (Opcional)</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- CAMPO: NUEVA CONTRASEÑA --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                    <input type="password"
                        class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                        id="password" name="password" placeholder="Dejar vacío para no cambiar">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- CAMPO: CONFIRMAR NUEVA CONTRASEÑA --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nueva
                        Contraseña</label>
                    <input type="password"
                        class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                        id="password_confirmation" name="password_confirmation">
                </div>
            </div>

            <div class="flex justify-between items-center border-t pt-6 mt-4">
                <a href="{{ route('administracion.usuarios.index') }}"
                    class="text-gray-600 hover:text-gray-900 font-medium">
                    ← Volver a la Lista
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i> Actualizar Usuario
                </button>
            </div>
        </form>
    </div>


</div>