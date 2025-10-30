<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

  {{-- Tarjeta 1: Usuarios / Registros --}}
  <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Usuarios Totales</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1">
          {{-- Esto sería dinámico: \App\Models\User::count() --}}
          42
        </p>
      </div>
      <i class="fas fa-users text-4xl text-red-400 opacity-70"></i>
    </div>
    <a href="{{ route('administracion.usuarios.index') }}" class="text-xs text-red-500 hover:underline mt-2 block">
      Gestionar usuarios →
    </a>
  </div>

  {{-- Tarjeta 2: Especies Registradas --}}
  <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Especies Registradas</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1">
          {{-- Esto sería dinámico: \App\Models\Animal::count() --}}
          105
        </p>
      </div>
      <i class="fas fa-paw text-4xl text-green-400 opacity-70"></i>
    </div>
    <a href="{{ route('animales.index') }}" class="text-xs text-green-500 hover:underline mt-2 block">
      Ver CRUD de especies →
    </a>
  </div>

  {{-- Tarjeta 3: Alertas Pendientes --}}
  <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-500">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Alertas Activas</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1">
          {{-- Esto sería dinámico: \App\Models\Alerta::where('estado', 'Nueva')->count() --}}
          8
        </p>
      </div>
      <i class="fas fa-exclamation-triangle text-4xl text-yellow-400 opacity-70"></i>
    </div>
    <a href="{{ route('alertas.index') }}" class="text-xs text-yellow-500 hover:underline mt-2 block">
      Revisar alertas IoT →
    </a>
  </div>

</div>