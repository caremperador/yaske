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
        Schema::table('diaspremium_revendedores', function (Blueprint $table) {
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
            $table->string('slug')->nullable()->unique()->after('user_id'); // Asegúrate de que sea única
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diaspremium_revendedores', function (Blueprint $table) {
            $table->dropColumn(['foto_perfil', 'slug', 'estado_conectado', 'ultimo_conexion', 'pais', 'numero_telefono', 'mensaje_perfil', 'transacciones_exitosas', 'transacciones_rechazadas', 'transacciones_canceladas', 'nombres_beneficiario', 'apellidos_beneficiario', 'link_telegram', 'link_whatsapp', 'metodos_pago', 'cantidad_minima', 'precio']);
        });
    }
};
