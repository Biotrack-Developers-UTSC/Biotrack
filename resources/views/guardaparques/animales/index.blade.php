@extends('layouts.app')

@section('title', 'Gestión de Especies')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Gestión de Especies</h1>

        {{-- Mensajes de éxito --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filtros --}}
        <form method="GET" action="{{ route('animales.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4">
            <input type="text" name="id" value="{{ request('id') }}" placeholder="Filtrar por ID"
                class="border p-2 rounded focus:ring-2 focus:ring-emerald-500">
            <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="Buscar por nombre común"
                class="border p-2 rounded focus:ring-2 focus:ring-emerald-500">
            <input type="text" name="nombre_cientifico" value="{{ request('nombre_cientifico') }}"
                placeholder="Buscar por nombre científico" class="border p-2 rounded focus:ring-2 focus:ring-emerald-500">
            <select name="tipo" class="border p-2 rounded focus:ring-2 focus:ring-emerald-500">
                <option value="">Todos los tipos</option>
                <option value="Pacifico" {{ request('tipo') == 'Pacifico' ? 'selected' : '' }}>Pacífico</option>
                <option value="Hostil" {{ request('tipo') == 'Hostil' ? 'selected' : '' }}>Hostil</option>
            </select>
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
                Filtrar
            </button>
        </form>

        <div class="mb-6 flex justify-end">
            <a href="{{ route('animales.create') }}"
                class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
                <i class="fas fa-plus"></i> Nueva Especie
            </a>
        </div>

        {{-- Tabla --}}
        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-center">Código QR</th>
                        <th class="px-4 py-3 text-center">Imagen</th>
                        <th class="px-4 py-3 text-left">Nombre Común</th>
                        <th class="px-4 py-3 text-left">Nombre Científico</th>
                        <th class="px-4 py-3 text-left">Tipo</th>
                        <th class="px-4 py-3 text-left">Hábitat</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($animales as $animal)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $animal->id }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($animal->codigo_qr)
                                    <img src="{{ asset('storage/' . $animal->codigo_qr) }}" alt="QR"
                                        class="w-24 h-24 mx-auto object-contain rounded-md shadow">
                                @else
                                    <span class="text-gray-400 text-sm">Sin QR</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($animal->imagen_path)
                                    <img src="{{ asset('storage/' . $animal->imagen_path) }}"
                                        alt="Imagen de {{ $animal->nombre_comun }}"
                                        class="w-24 h-24 object-cover rounded-lg shadow-md mx-auto">
                                @else
                                    <div
                                        class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs mx-auto">
                                        Sin imagen
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $animal->nombre_comun }}</td>
                            <td class="px-4 py-3 text-gray-700 italic">{{ $animal->nombre_cientifico }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium {{ $animal->tipo === 'Pacifico' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $animal->tipo }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ $animal->habitat }}</td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('animales.show', $animal) }}" class="text-blue-600 hover:text-blue-800"><i
                                        class="fas fa-eye"></i></a>
                                <a href="{{ route('animales.ficha_publica', $animal) }}"
                                    class="text-cyan-600 hover:text-cyan-800"><i class="fas fa-map"></i></a>
                                <a href="{{ route('animales.edit', $animal) }}" class="text-amber-600 hover:text-amber-800"><i
                                        class="fas fa-edit"></i></a>
                                <form action="{{ route('animales.destroy', $animal) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('¿Seguro que deseas eliminar esta especie?')"
                                        class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $animales->links() }}
        </div>
    </div>
@endsection