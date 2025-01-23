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
        Schema::table('projects', function (Blueprint $table) {
            $table->text('objectives')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('sector')->nullable();
            $table->text('documents')->nullable(); // Pour stocker les chemins des fichiers en JSON
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
