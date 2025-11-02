{{-- resources/views/guardaparques/alertas/index.blade.php --}}
<div class="overflow-x-auto">
    @if($alertas->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded mb-4 shadow">
            No hay alertas registradas por el momento.
        </div>
    @else
        <table class="min-w-full divide-y divide-gray-200 shadow rounded-lg">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-4 py-2 text-left font-bold text-green-700">ID</th>
                    <th class="px-4 py-2 text-left font-bold text-green-700">Título</th>
                    <th class="px-4 py-2 text-left font-bold text-green-700">Mensaje</th>
                    <th class="px-4 py-2 text-left font-bold text-green-700">Severidad</th>
                    <th class="px-4 py-2 text-left font-bold text-green-700">Sensor</th>
                    <th class="px-4 py-2 text-left font-bold text-green-700">Ubicación</th>
                    <th class="px-4 py-2 text-left font-bold text-green-700">Estado</th>
                    <th class="px-4 py-2 text-left font-bold text-green-700">Creado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($alertas as $alerta)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-2">{{ $alerta->id_alerta }}</td>
                        <td class="px-4 py-2">{{ $alerta->titulo }}</td>
                        <td class="px-4 py-2">{{ $alerta->mensaje }}</td>
                        <td class="px-4 py-2">
                            @if(strtolower($alerta->severidad) === 'alta')
                                <span class="text-red-700 font-semibold">{{ ucfirst($alerta->severidad) }}</span>
                            @elseif(strtolower($alerta->severidad) === 'media')
                                <span class="text-yellow-700 font-semibold">{{ ucfirst($alerta->severidad) }}</span>
                            @else
                                <span class="text-green-700 font-semibold">{{ ucfirst($alerta->severidad) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $alerta->sensor_id }}</td>
                        <td class="px-4 py-2">{{ $alerta->ubicacion }}</td>
                        <td class="px-4 py-2">
                            @if(strtolower($alerta->estado) === 'resuelta')
                                <span class="text-green-600 font-semibold">{{ ucfirst($alerta->estado) }}</span>
                            @else
                                <span class="text-red-600 font-semibold">{{ ucfirst($alerta->estado) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $alerta->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $alertas->links() }}
        </div>
    @endif
</div>
