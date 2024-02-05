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
        Schema::create('categoria_lista', function (Blueprint $table) {
            // Crea un campo de clave foránea que referencia a 'id' en la tabla 'listas'
            $table->foreignId('lista_id')->constrained()->onDelete('cascade');
            // Crea un campo de clave foránea que referencia a 'id' en la tabla 'categorias'
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
            // Establece una clave primaria compuesta por 'lista_id' y 'categoria_id'
            $table->primary(['lista_id', 'categoria_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Al revertir la migración, se eliminará la tabla 'categoria_lista'
        Schema::dropIfExists('categoria_lista');
    }
};
