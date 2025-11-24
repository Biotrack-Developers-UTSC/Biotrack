@extends('layouts.dashboard')
@section('title', 'Consulta de Alertas IoT - Guardaparques')

@section('content')
    @php use Illuminate\Support\Str; @endphp

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <h1 class="text-3xl font-extrabold text-green-700 mb-8">
            <i class="fas fa-bell mr-2"></i> Consulta de Alertas IoT
        </h1>

        <p class="text-gray-600 mb-6 text-sm">
            Aquí puedes visualizar las alertas generadas por los sensores IoT o registradas manualmente.
            Solo el administrador puede configurarlas o eliminarlas.
        </p>

        {{-- 🔍 Filtro rápido --}}
        <form method="GET" action="{{ route('guardaparques.alertas.index') }}"
            class="bg-gray-100 rounded-xl p-6 shadow-inner mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="tipo" class="block text-sm font-semibold text-gray-700">Tipo de Alerta</label>
                    <input type="text" name="tipo" id="tipo" value="{{ request('tipo') }}"
                        class="mt-1 w-full border border-gray-400 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                        placeholder="Ej. hostil / no hostil">
                </div>

                <div>
                    <label for="severidad" class="block text-sm font-semibold text-gray-700">Severidad</label>
                    <select name="severidad" id="severidad"
                        class="mt-1 w-full border border-gray-400 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">Todas</option>
                        <option value="Baja" {{ request('severidad') === 'Baja' ? 'selected' : '' }}>Baja</option>
                        <option value="Media" {{ request('severidad') === 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Alta" {{ request('severidad') === 'Alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-filter mr-1"></i> Filtrar
                    </button>
                    <a href="{{ route('guardaparques.alertas.index') }}"
                        class="ml-2 px-4 py-2 bg-gray-400 text-white font-semibold rounded-lg hover:bg-gray-500 transition">
                        <i class="fas fa-undo mr-1"></i> Limpiar
                    </a>
                </div>
            </div>
        </form>

        {{-- 📋 Tabla de alertas --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Título
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Imagen
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Severidad
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Mensaje
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Sensor
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Ubicación
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($alertas as $alerta)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $alerta->id_alerta }}</td>

                            {{-- ✅ Título con etiqueta IoT si viene de un dispositivo --}}
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                {{ $alerta->titulo }}
                                @if(Str::contains(strtolower($alerta->sensor_id ?? ''), 'esp32') || Str::contains(strtolower($alerta->sensor_id ?? ''), 'iot'))
                                    <span
                                        class="ml-2 px-2 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-300">
                                        IoT
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if($alerta->imagen)
                                    <a href="{{ asset($alerta->imagen) }}" target="_blank">
                                        <img src="{{ asset($alerta->imagen) }}"
                                            class="w-20 h-20 object-cover rounded-lg border border-gray-300 shadow-sm">
                                    </a>
                                @else
                                    <span class="text-gray-400">Sin foto</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm">
                                @php
                                    $color = match ($alerta->severidad) {
                                        'Alta' => 'bg-red-200 text-red-900',
                                        'Media' => 'bg-yellow-200 text-yellow-900',
                                        default => 'bg-green-200 text-green-900',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                    {{ $alerta->severidad }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">{{ $alerta->mensaje }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $alerta->sensor_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $alerta->ubicacion }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                @php
                                    $estadoColor = match ($alerta->estado) {
                                        'Nueva' => 'bg-blue-200 text-blue-900',
                                        'En Proceso' => 'bg-yellow-200 text-yellow-900',
                                        'Resuelta' => 'bg-green-200 text-green-900',
                                        default => 'bg-gray-200 text-gray-800',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $estadoColor }}">
                                    {{ $alerta->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $alerta->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-10 text-center text-gray-500 text-lg">
                                No hay alertas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 🔄 Paginación --}}
        <div class="mt-6">
            {{ $alertas->appends(request()->query())->links() }}
        </div>

    </div>
@endsection