<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuario Administrador (Acceso total)
        //Esmeralda (Admin)
        User::create([
            'name' => 'Admin de BioTrack: Ruth Esmeralda ',
            'email' => '21085@virtual.utsc.edu.mx',
            'password' => Hash::make('ruth21085'), // Contraseña simple para pruebas
            'role' => 'admin',
            'email_verified_at' => now(), // Verificado para evitar bloqueos
        ]);

        //Alberto (Admin)
        User::create([
            'name' => 'Admin de BioTrack: Alberto Staarthof',
            'email' => '21063@virtual.utsc.edu.mx',
            'password' => Hash::make('alberto21063'), // Contraseña simple para pruebas
            'role' => 'admin',
            'email_verified_at' => now(), // Verificado para evitar bloqueos
        ]);

        //Daniel (Admin)
        User::create([
            'name' => 'Admin de BioTrack: Daniel Flores',
            'email' => '21008@virtual.utsc.edu.mx',
            'password' => Hash::make('daniel21008'), // Contraseña simple para pruebas
            'role' => 'admin',
            'email_verified_at' => now(), // Verificado para evitar bloqueos
        ]);

        //Gerardo (Admin)
        User::create([
            'name' => 'Admin de BioTrack: Jose Gerardo',
            'email' => '21181@virtual.utsc.edu.mx',
            'password' => Hash::make('gerardo21181'), // Contraseña simple para pruebas
            'role' => 'admin',
            'email_verified_at' => now(), // Verificado para evitar bloqueos
        ]);

        //Fabian (Admin)
        User::create([
            'name' => 'Admin de BioTrack: Enrique Fabian',
            'email' => '21024@virtual.utsc.edu.mx',
            'password' => Hash::make('fabian21024'), // Contraseña simple para pruebas
            'role' => 'admin',
            'email_verified_at' => now(), // Verificado para evitar bloqueos
        ]);

        //Sem (Admin)
        User::create([
            'name' => 'Admin de BioTrack: Sem Hernandez',
            'email' => 'sem.hernandez@utsc.edu.mx',
            'password' => Hash::make('adminsem123'), // Contraseña simple para pruebas
            'role' => 'admin',
            'email_verified_at' => now(), // Verificado para evitar bloqueos
        ]);

        // 2. Usuario Guardaparque (Rol intermedio)
        //Esmeralda (Guardaparque)
        User::create([
            'name' => 'Guardaparque Ruth Esmeralda',
            'email' => 'esmeralda.guardaparques@gmail.com',
            'password' => Hash::make('ruthguardia21085'),
            'role' => 'guardaparque',
            'email_verified_at' => now(),
        ]);

        //Alberto (Guardaparque)
        User::create([
            'name' => 'Guardaparque Alberto Staarthof',
            'email' => 'alberto.guardaparques@gmail.com',
            'password' => Hash::make('albertoguardia21063'),
            'role' => 'guardaparque',
            'email_verified_at' => now(),
        ]);

        //Daniel (Guardaparque)
        User::create([
            'name' => 'Guardaparque Daniel Florez',
            'email' => 'daniel.guardaparques@gmail.com',
            'password' => Hash::make('danielguardia21008'),
            'role' => 'guardaparque',
            'email_verified_at' => now(),
        ]);

        //Gerardo (Guardaparque)
        User::create([
            'name' => 'Guardaparque Jose Gerardo',
            'email' => 'gerardo.guardaparques@gmail.com',
            'password' => Hash::make('gerardoguardia21181'),
            'role' => 'guardaparque',
            'email_verified_at' => now(),
        ]);

        //Fabian (Guardaparque)
        User::create([
            'name' => 'Guardaparque Enrique Fabian',
            'email' => 'fabian.guardaparques@gmail.com',
            'password' => Hash::make('fabianguardia21024'),
            'role' => 'guardaparque',
            'email_verified_at' => now(),
        ]);

        // 3. Usuario General (Rol por defecto)
        //Esmeralda (Usuaria)
        User::create([
            'name' => 'Ruth Esmeralda Gurrola Castañeda',
            'email' => 'esmeralda@gmail.com',
            'password' => Hash::make('21085'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        //Alberto (Usuario)
        User::create([
            'name' => 'Alberto Staarthof Limón ',
            'email' => 'alberto@gmail.com',
            'password' => Hash::make('21063'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        //Daniel (Usuario)
        User::create([
            'name' => 'Daniel Florez Zaragoza',
            'email' => 'dafloresza@gmail.com',
            'password' => Hash::make('21008'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        //Gerardo (Usuario)
        User::create([
            'name' => 'Jose Gerardo Leija Contreras',
            'email' => 'geraleija75@gmail.com',
            'password' => Hash::make('21181'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        //Fabian (Usuario)
        User::create([
            'name' => 'Enrique Fabian Perez Medellin',
            'email' => 'perezmedellinenriquefabian@gmail.com',
            'password' => Hash::make('21024'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Usuarios de prueba (admin, guardaparque, user) creados con éxito.');
    }
}