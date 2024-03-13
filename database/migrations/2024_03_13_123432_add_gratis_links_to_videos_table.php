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
        Schema::table('videos', function (Blueprint $table) {
            $table->string('url_video_gratis')->nullable();
            $table->string('es_url_video_gratis')->nullable();
            $table->string('lat_url_video_gratis')->nullable();
            $table->string('sub_url_video_gratis')->nullable();
            $table->boolean('tiene_gratis')->default(false); // Indica si el video tiene enlaces gratis.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('url_video_gratis');
            $table->dropColumn('es_url_video_gratis');
            $table->dropColumn('lat_url_video_gratis');
            $table->dropColumn('sub_url_video_gratis');
            $table->dropColumn('tiene_gratis');
        });
    }
};
