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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Type de notification (e.g., 'alert', 'message')
            $table->morphs('notifiable'); // Colonne pour morphing (e.g., user_id, user_type)
            $table->text('data'); // Stocker les données de la notification en format JSON
            $table->boolean('read')->default(false); // Indiquer si la notification a été lue
            $table->timestamps(); // Champs 'created_at' et 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
