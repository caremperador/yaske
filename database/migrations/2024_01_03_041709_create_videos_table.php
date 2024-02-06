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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->string('es_titulo')->nullable();
            $table->string('lat_titulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('tmdb_id')->unique()->nullable();
            $table->string('thumbnail');
            $table->foreignId('lista_id')->nullable()->constrained();
            $table->foreignId('tipo_id')->constrained();
            $table->string('url_video')->nullable(); 
            $table->string('es_url_video')->nullable();
            $table->string('lat_url_video')->nullable();
            $table->string('sub_url_video')->nullable();
            $table->boolean('estado'); // 0: inactivo, 1: activo
            $table->boolean('es_calidad_cam')->default(false); // Añade esta línea
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
