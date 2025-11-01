@extends('layouts.app')
@section('title', 'Gestión de Usuarios y Roles')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <header class="mb-8 flex justify-between items-center">
        <h1 class="text-4xl font-extrabold text-red-700">Panel de Administración de Usuarios</h1>
        <a href="{{ route('administracion.usuarios.create') }}" 
           class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors shadow-md flex items-center">
            <i class="fas fa-user-plus mr-2"></i> Añadir Nuevo Usuario
        </a>
    </header>

    {{-- ✅ Mensaje de éxito --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- 🔍 Filtros mejorados --}}
    <div class="bg-gray-100 p-6 mb-8 rounded-xl shadow-inner border border-gray-300">
        <form method="GET" action="{{ route('administracion.usuarios.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            
            <div>
                <label for="id" class="block text-sm font-semibold text-gray-700">ID</label>
                <input type="text" name="id" id="id" value="{{ request('id') }}" 
                    class="mt-1 w-full bg-gray-50 border border-gray-400 text-gray-800 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 placeholder-gray-400"
                    placeholder="Ej. 1">
            </div>

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700">Nombre</label>
                <input type="text" name="name" id="name" value="{{ request('name') }}" 
                    class="mt-1 w-full bg-gray-50 border border-gray-400 text-gray-800 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 placeholder-gray-400"
                    placeholder="Ej. Juan Pérez">
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700">Correo</label>
                <input type="text" name="email" id="email" value="{{ request('email') }}" 
                    class="mt-1 w-full bg-gray-50 border border-gray-400 text-gray-800 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 placeholder-gray-400"
                    placeholder="Ej. ejemplo@mail.com">
            </div>

            <div>
                <label for="role" class="block text-sm font-semibold text-gray-700">Rol</label>
                <select name="role" id="role" 
                    class="mt-1 w-full bg-gray-50 border border-gray-400 text-gray-800 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
                    <option value="">Todos</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guardaparque" {{ request('role') === 'guardaparque' ? 'selected' : '' }}>Guardaparque</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Usuario</option>
                </select>
            </div>

            <div class="md:col-span-5 flex justify-end items-end space-x-3">
                <button type="submit" 
                    class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors shadow">
                    <i class="fas fa-filter mr-1"></i> Filtrar
                </button>

                <a href="{{ route('administracion.usuarios.index') }}" 
                    class="px-4 py-2 bg-gray-400 text-white font-semibold rounded-lg hover:bg-gray-500 transition-colors shadow">
                    <i class="fas fa-undo mr-1"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    {{-- 🧍‍♂️ Tabla --}}
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-red-700 uppercase tracking-wider">Rol</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-red-700 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user) 
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $roleClass = match($user->role) {
                                        'admin' => 'bg-red-200 text-red-900',
                                        'guardaparque' => 'bg-green-200 text-green-900',
                                        default => 'bg-blue-100 text-blue-800',
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $roleClass }} uppercase">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('administracion.usuarios.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('administracion.usuarios.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar a este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 text-lg">
                                No se encontraron usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 📄 Paginación --}}
    <div class="mt-6">
        {{ $users->appends(request()->query())->links() }}
    </div>

</div>
@endsection
