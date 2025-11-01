@extends('layouts.app')
@section('title', 'Catálogo de Especies')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <header class="mb-8">
            <div class="space-x-3 mb-4 flex flex-wrap items-center justify-between">
                <div class="space-x-3">
                    <a href="{{ route('welcome') }}" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        ← Volver al Inicio
                    </a>
                    @auth
                        @php $rolUsuario = auth()->user()->rol ?? auth()->user()->role ?? ''; @endphp
                        @if (in_array($rolUsuario, ['admin', 'guardabosques']))
                            <a href="{{ route('animales.index') }}"
                                class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                                Ir al CRUD de Especies
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Catálogo de Especies Silvestres 🌿</h1>
            <p class="text-gray-600">Explora la fauna monitoreada por BioTrack. Usa el escáner QR para ver fichas
                detalladas.</p>
        </header>

        {{-- FILTROS --}}
        <form method="GET" action="{{ route('consultas.index') }}"
            class="bg-white p-6 rounded-xl shadow-lg mb-8 grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
            <input type="text" name="id" value="{{ request('id') }}" placeholder="Filtrar por ID"
                class="border p-2 rounded focus:ring-2 focus:ring-cyan-500">
            <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="Buscar por nombre común"
                class="border p-2 rounded focus:ring-2 focus:ring-cyan-500">
            <input type="text" name="nombre_cientifico" value="{{ request('nombre_cientifico') }}"
                placeholder="Buscar por nombre científico" class="border p-2 rounded focus:ring-2 focus:ring-cyan-500">
            <select name="tipo" class="border p-2 rounded focus:ring-2 focus:ring-cyan-500">
                <option value="">Todos los tipos</option>
                <option value="Pacifico" {{ request('tipo') == 'Pacifico' ? 'selected' : '' }}>Pacífico</option>
                <option value="Hostil" {{ request('tipo') == 'Hostil' ? 'selected' : '' }}>Hostil</option>
            </select>
            <button type="submit" class="bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 transition">
                Filtrar
            </button>
            <button onclick="window.location.href='{{ route('qr.scanner.ui') }}'" type="button"
                class="w-full md:w-auto px-4 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 flex items-center justify-center">
                <i class="fas fa-qrcode mr-2"></i> Escanear QR
            </button>
        </form>

        {{-- TABLA --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
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
                        @forelse($animales as $animal)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $animal->id }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if ($animal->codigo_qr)
                                        <img src="{{ asset('storage/' . $animal->codigo_qr) }}"
                                            class="w-24 h-24 object-contain mx-auto rounded-md shadow">
                                    @else
                                        <span class="text-gray-400 text-sm">Sin QR</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($animal->imagen_path)
                                        <img src="{{ asset('storage/' . $animal->imagen_path) }}"
                                            class="w-24 h-24 object-cover mx-auto rounded-lg shadow">
                                    @else
                                        <div
                                            class="w-24 h-24 bg-gray-100 flex items-center justify-center text-gray-400 text-xs rounded-lg mx-auto">
                                            Sin imagen
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-800">{{ $animal->nombre_comun }}</td>
                                <td class="px-4 py-3 italic text-gray-700">{{ $animal->nombre_cientifico }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium {{ $animal->tipo === 'Pacifico' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $animal->tipo }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $animal->habitat }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('animales.ficha_publica', $animal->id) }}"
                                        class="text-cyan-600 hover:text-cyan-900">
                                        Ver Ficha Detallada
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-gray-500 text-lg">
                                    No se encontraron especies.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $animales->links() }}
            </div>

        </div>
    </div>
@endsection