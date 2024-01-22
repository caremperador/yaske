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
        // Migración para la tabla admin_configuracion_pais
        Schema::create('admin_configuracion_pais', function (Blueprint $table) {
            $table->id();
            $table->string('pais');
            $table->decimal('precio_minimo', 8, 2);
            $table->decimal('precio_maximo', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_configuracion_pais');
    }
};
