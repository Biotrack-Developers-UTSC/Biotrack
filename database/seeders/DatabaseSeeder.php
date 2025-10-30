<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seeders de Autenticación (Usuarios y Roles)
        $this->call([
            RoleUserSeeder::class, // Debe ejecutarse primero para crear los usuarios
        ]);

        // 2. Seeders de Contenido (Datos de la aplicación)
        $this->call([
            AnimalSeeder::class, // Ahora se ejecutan los animales
            // AlertaSeeder::class, // Pendiente de crear
        ]);

        // Nota: Asegúrate de tener los controladores de Auth/Users creados para evitar errores.
    }
}