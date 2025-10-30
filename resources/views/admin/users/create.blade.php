@extends('layouts.app')
@section('title', 'Crear Nuevo Usuario')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-red-500">
        <header class="mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800">Registrar Nuevo Usuario</h1>
            <p class="text-gray-500">Asigna nombre, credenciales y rol de acceso (Admin, Guardia o Usuario).</p>
        </header>

        <form action="{{ route('administracion.usuarios.store') }}" method="post">
            @csrf

            {{-- CAMPO: NOMBRE COMPLETO --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo <span
                        class="text-danger text-red-500">*</span></label>
                <input type="text"
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                    id="name" name="name" value="{{ old('name') }}" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- CAMPO: EMAIL --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail <span
                        class="text-red-500">*</span></label>
                <input type="email"
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                    id="email" name="email" value="{{ old('email') }}" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- CAMPO: CONTRASEÑA --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña <span
                            class="text-red-500">*</span></label>
                    <input type="password"
                        class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                        id="password" name="password" required>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- CAMPO: CONFIRMAR CONTRASEÑA --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar
                        Contraseña <span class="text-red-500">*</span></label>
                    <input type="password"
                        class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                        id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>

            {{-- CAMPO: ROL --}}
            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700">Rol de Acceso <span
                        class="text-red-500">*</span></label>
                <select id="role" name="role" required
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Usuario Regular</option>
                    <option value="guardaparque" {{ old('role') == 'guardaparque' ? 'selected' : '' }}>Guardaparques
                    </option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-between items-center border-t pt-6">
                <a href="{{ route('administracion.usuarios.index') }}"
                    class="text-gray-600 hover:text-gray-900 font-medium">
                    ← Volver a la Lista
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition-colors">
                    <i class="fas fa-save mr-2"></i> Registrar Usuario
                </button>
            </div>
        </form>
    </div>
</div>