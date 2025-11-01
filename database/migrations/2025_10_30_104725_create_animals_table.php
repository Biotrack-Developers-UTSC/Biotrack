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
        Schema::create('animales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_comun')->unique();
            $table->string('nombre_cientifico')->unique();

            // Campo 'habitat' añadido desde el modelo
            $table->string('habitat')->nullable();

            $table->enum('tipo', ['Pacifico', 'Hostil'])->default('Pacifico');
            $table->text('descripcion')->nullable();

            // Campos de archivos
            $table->string('imagen_path')->nullable();
            $table->string('codigo_qr')->nullable();

            // Campos de monitoreo (opcionales)
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};