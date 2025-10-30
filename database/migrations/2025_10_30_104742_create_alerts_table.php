<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alertas', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental del ORM

            // Campo 'id_alerta' añadido desde el modelo (Identificador externo, ej. del sensor)
            $table->string('id_alerta')->unique();

            $table->string('titulo');
            $table->text('mensaje');
            $table->enum('severidad', ['Baja', 'Media', 'Alta'])->default('Baja');

            // Información del origen de la alerta
            $table->string('sensor_id')->nullable();
            $table->string('ubicacion')->nullable(); // Ej: Coordenadas, Zona A

            $table->enum('estado', ['Nueva', 'En Proceso', 'Resuelta'])->default('Nueva');

            $table->timestamps(); // Registra cuándo fue creada y actualizada en el sistema
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};