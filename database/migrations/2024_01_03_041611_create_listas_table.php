<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('listas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('es_titulo')->nullable();
            $table->string('lat_titulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('thumbnail');
            $table->string('tmdb_id')->unique()->nullable();
            $table->foreignId('tipo_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listas');
    }
};
