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
        Schema::table('users', function (Blueprint $table) {
            $table->string('fonction')->nullable();
            $table->string('genre')->nullable();
            $table->text('biographie')->nullable();
            $table->string('telephone')->nullable();
            $table->string('ville')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('startup_nom')->nullable();
            $table->string('startup_slogan')->nullable();
            $table->string('startup_adresse')->nullable();
            $table->string('startup_secteur')->nullable();
            $table->text('pitch')->nullable();
            $table->string('profile_picture')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
