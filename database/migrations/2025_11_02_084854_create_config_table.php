<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('config', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index();
            $table->text('value')->nullable();
            $table->string('section')->default('general')->index(); // general, arduino, smtp
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config');
    }
};
