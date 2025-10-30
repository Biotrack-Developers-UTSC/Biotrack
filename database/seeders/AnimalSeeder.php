<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Jaguar (Hostil)
        Animal::create([
            'nombre_comun' => 'Jaguar',
            'nombre_cientifico' => 'Panthera onca',
            'habitat' => 'Selva tropical densa',
            'tipo' => 'Hostil',
            'descripcion' => 'El felino más grande de América. Es un depredador apex y solitario, crucial para el ecosistema.',
            'imagen_path' => null,
            'codigo_qr' => null,
            'latitud' => 20.6735,
            'longitud' => -87.0583,
        ]);

        // 2. Tucán Esmeralda (Pacífico)
        Animal::create([
            'nombre_comun' => 'Tucán Esmeralda',
            'nombre_cientifico' => 'Aulacorhynchus prasinus',
            'habitat' => 'Bosques de montaña y nubosos',
            'tipo' => 'Pacífico',
            'descripcion' => 'Ave pequeña con un pico de color verde brillante. Se alimenta principalmente de frutas y reside en el dosel arbóreo.',
            'imagen_path' => null,
            'codigo_qr' => null,
            'latitud' => 17.0654,
            'longitud' => -96.7237,
        ]);

        // 3. Ocelote (Hostil)
        Animal::create([
            'nombre_comun' => 'Ocelote',
            'nombre_cientifico' => 'Leopardus pardalis',
            'habitat' => 'Matorral costero y zonas pantanosas',
            'tipo' => 'Hostil',
            'descripcion' => 'Felino de tamaño medio, conocido por sus manchas distintivas. Principalmente nocturno, caza roedores y reptiles pequeños.',
            'imagen_path' => null,
            'codigo_qr' => null,
            'latitud' => 19.4326,
            'longitud' => -99.1332,
        ]);

        $this->command->info('Especies de prueba creadas con éxito.');
    }
}
