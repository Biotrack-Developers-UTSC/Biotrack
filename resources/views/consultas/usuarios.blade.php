@extends('layouts.dashboard')
@section('title', 'Consulta de Usuarios - BioTrack')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <h1 class="text-3xl font-extrabold text-green-700 mb-8">🔍 Consulta de Usuarios</h1>

    {{-- 🔎 Filtros --}}
    <div class="bg-green-50 p-6 mb-8 rounded-xl shadow-inner border border-green-200">
        <form method="GET" action="{{ route('consultas.usuarios') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700">ID</label>
                <input type="text" name="id" value="{{ request('id') }}" class="mt-1 w-full border border-gray-300 rounded-lg p-2" placeholder="Ej. 1">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nombre</label>
                <input type="text" name="name" value="{{ request('name') }}" class="mt-1 w-full border border-gray-300 rounded-lg p-2" placeholder="Ej. Juan Pérez">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Correo</label>
                <input type="text" name="email" value="{{ request('email') }}" class="mt-1 w-full border border-gray-300 rounded-lg p-2" placeholder="Ej. ejemplo@mail.com">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Rol</label>
                <select name="role" class="mt-1 w-full border border-gray-300 rounded-lg p-2">
                    <option value="">Todos</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guardaparque" {{ request('role') === 'guardaparque' ? 'selected' : '' }}>Guardaparque</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Usuario</option>
                </select>
            </div>
            <div class="md:col-span-5 flex justify-end items-end space-x-3">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">
                    <i class="fas fa-search mr-1"></i> Buscar
                </button>
                <a href="{{ route('consultas.usuarios') }}" class="px-4 py-2 bg-gray-400 text-white font-semibold rounded-lg hover:bg-gray-500">
                    <i class="fas fa-undo mr-1"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    {{-- 🧍‍♂️ Tabla --}}
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-green-800 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Correo</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-green-800 uppercase tracking-wider">Rol</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $roleClass = match($user->role) {
                                    'admin' => 'bg-red-200 text-red-900',
                                    'guardaparque' => 'bg-green-200 text-green-900',
                                    default => 'bg-blue-100 text-blue-800',
                                };
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $roleClass }}">
                                {{ $user->role }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">No se encontraron usuarios.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📄 Paginación --}}
    <div class="mt-6">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection
