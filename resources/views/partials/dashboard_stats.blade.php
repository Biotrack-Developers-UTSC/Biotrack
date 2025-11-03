<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-red-500 text-center">
        <i class="fas fa-users text-4xl text-red-400 mb-3"></i>
        <p class="text-gray-500 uppercase text-sm">Usuarios Totales</p>
        <p class="text-3xl font-extrabold text-gray-800">{{ \App\Models\User::count() }}</p>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-green-500 text-center">
        <i class="fas fa-paw text-4xl text-green-400 mb-3"></i>
        <p class="text-gray-500 uppercase text-sm">Especies Registradas</p>
        <p class="text-3xl font-extrabold text-gray-800">{{ \App\Models\Animal::count() }}</p>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-yellow-500 text-center">
        <i class="fas fa-exclamation-triangle text-4xl text-yellow-400 mb-3"></i>
        <p class="text-gray-500 uppercase text-sm">Alertas Activas</p>
        <p class="text-3xl font-extrabold text-gray-800">{{ \App\Models\Alerta::where('estado', 'Nueva')->count() }}</p>
    </div>
</div>