@extends('layouts.app')
@section('title', 'Gestión de Especies (CRUD)')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-8 flex justify-between items-center">
            <h1 class="text-4xl font-extrabold text-green-700">CRUD de Especies Silvestres</h1>
            <a href="{{ route('animales.create') }}"
                class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-md flex items-center">
                <i class="fas fa-plus mr-2"></i> Registrar Nueva Especie
            </a>
        </header>

        {{-- Mensajes de éxito --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            {{-- Tabla responsiva --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Común
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">
                                Científico</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">
                                Hábitat</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-green-700 uppercase tracking-wider">Tipo
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-green-700 uppercase tracking-wider">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">

                        {{-- Iterar sobre la colección de animales --}}
                        @forelse($animales as $animal)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $animal->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $animal->nombre_comun }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $animal->nombre_cientifico }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $animal->habitat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $typeClass = $animal->tipo === 'Pacifico' ? 'bg-blue-200 text-blue-900' : 'bg-red-200 text-red-900';
                                    @endphp
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $typeClass }} uppercase">
                                        {{ $animal->tipo }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                    {{-- Ver Detalle (La vista interna completa) --}}
                                    <a href="{{ route('animales.ficha', $animal) }}" title="Ver detalles y QR"
                                        class="text-green-600 hover:text-green-800">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    {{-- Editar --}}
                                    <a href="{{ route('animales.edit', $animal) }}" title="Editar datos"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>

                                    {{-- Eliminar --}}
                                    <form action="{{ route('animales.destroy', $animal) }}" method="POST" class="inline"
                                        onsubmit="return confirm('¿Estás seguro de ELIMINAR esta especie?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Eliminar registro" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 text-lg">
                                    No se encontraron especies registradas.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginación (Si se usa paginate en el Controller) --}}
        <div class="mt-4">
            {{ $animales->links() }}
        </div>

    </div>
@endsection