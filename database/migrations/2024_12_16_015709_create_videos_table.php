<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_videos_table.php
public function up()
{
    Schema::create('videos', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Titre de la vidéo
        $table->text('description')->nullable(); // Description
        $table->string('thumbnail'); // Miniature de la vidéo
        $table->string('video_path'); // Chemin du fichier vidéo
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Catégorie associée
        $table->timestamp('published_at')->nullable(); // Date de publication
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
