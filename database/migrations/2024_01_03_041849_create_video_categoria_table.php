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
        Schema::create('video_categoria', function (Blueprint $table) {
            $table->foreignId('video_id')->constrained('videos');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->primary(['video_id', 'categoria_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_categoria');
    }
};
