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
            $table->text('notes')->nullable()->after('end_time'); // Colonne pour les notes
        });
    }
    
    public function down()
    {
        Schema::table('mentorship_sessions', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
    
};
