<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameReadToReadAtInNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Vérifie que la colonne `read` existe avant de tenter de la renommer
            if (Schema::hasColumn('notifications', 'read')) {
                $table->renameColumn('read', 'read_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Vérifie que la colonne `read_at` existe avant de tenter de la renommer
            if (Schema::hasColumn('notifications', 'read_at')) {
                $table->renameColumn('read_at', 'read');
            }
        });
    }
}
