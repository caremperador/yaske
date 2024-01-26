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
        Schema::create('diaspremium_revendedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('dias_revendedor_premium')->nullable();
            $table->boolean('estado_conectado')->default(false);
            $table->timestamp('ultimo_conexion')->nullable();
            $table->string('pais')->nullable();
            $table->string('moneda')->nullable();
            $table->string('prefijo_telefonico', 4)->nullable();
            $table->string('numero_telefono')->nullable();
            $table->text('mensaje_perfil')->nullable();
            $table->integer('transacciones_exitosas')->default(0);
            $table->integer('transacciones_rechazadas')->default(0);
            $table->integer('transacciones_canceladas')->default(0);
            $table->string('nombres_beneficiario')->nullable();
            $table->string('apellidos_beneficiario')->nullable();
            $table->string('foto_perfil')->nullable();
            $table->string('link_telegram')->nullable();
            $table->string('link_whatsapp')->nullable();
            $table->json('metodos_pago')->nullable(); // Almacenar como JSON
            $table->integer('cantidad_minima')->default(1); // Valor predeterminado de 1
            $table->decimal('precio', 8, 2)->nullable(); // Por ejemplo, 99999.99
            $table->string('slug')->nullable()->unique(); // Asegúrate de que sea única
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diaspremium_revendedores');
    }
};
