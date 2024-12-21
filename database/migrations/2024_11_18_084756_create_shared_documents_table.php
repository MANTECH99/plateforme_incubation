<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shared_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path'); // Emplacement du fichier dans le stockage
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade'); // Utilisateur qui a téléchargé le fichier
            $table->foreignId('shared_with')->nullable()->constrained('users')->onDelete('cascade'); // Utilisateur avec qui il est partagé
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_documents');
    }
};
