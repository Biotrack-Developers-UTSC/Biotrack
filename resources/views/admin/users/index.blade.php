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

    {{-- Muestra mensajes de éxito (ej. después de crear o editar) --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
        {{-- Tabla responsiva --}}
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
                    
                    {{-- Iterar sobre la colección de usuarios --}}
                    @forelse($users as $user) 
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->email }}
                            </td>
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
                                
                                {{-- Botón de Eliminar con formulario para petición DELETE --}}
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
    
    {{-- Paginación --}}
    <div class="mt-4">
        {{ $users->links() }}
    </div>

</div>
@endsection