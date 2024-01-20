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
        Schema::create('diaspremium_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_activated')->default(false);
            $table->integer('dias_usuario_premium')->nullable();
            $table->dateTime('inicio_fecha_dias_usuario_premium')->nullable();
            $table->dateTime('fin_fecha_dias_usuario_premium')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diaspremium_users');
    }
    
};
