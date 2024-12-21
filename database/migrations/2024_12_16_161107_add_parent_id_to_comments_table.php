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
        Schema::table('comments', function (Blueprint $table) {
            // Ajouter la colonne parent_id
            $table->unsignedBigInteger('parent_id')->nullable()->after('content');
    
            // Définir la relation de clé étrangère pour la colonne parent_id
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            //
        });
    }
};
