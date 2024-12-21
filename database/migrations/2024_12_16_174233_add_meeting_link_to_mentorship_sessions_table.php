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
        Schema::table('mentorship_sessions', function (Blueprint $table) {
            $table->string('meeting_link')->nullable()->after('notes'); // Remplacez 'column_name' par la colonne après laquelle vous voulez insérer cette colonne.
        });
    }
    
    public function down()
    {
        Schema::table('mentorship_sessions', function (Blueprint $table) {
            $table->dropColumn('meeting_link');
        });
    }
    
};
