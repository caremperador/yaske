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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id'); // ID del comprador
            $table->unsignedBigInteger('seller_id'); // ID del vendedor
            $table->string('photo_path'); // Ruta de la foto subida
            $table->timestamps();

            // Foreign keys y otras restricciones según sea necesario
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
