<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleOauthTokensToUsersTable extends Migration
{
    /**
     * Exécuter les migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('google_oauth_token')->nullable()->after('email'); // Ajout de google_oauth_token après la colonne email
            $table->text('google_refresh_token')->nullable()->after('google_oauth_token'); // Ajout de google_refresh_token après google_oauth_token
        });
    }

    /**
     * Revenir les migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_oauth_token');
            $table->dropColumn('google_refresh_token');
        });
    }
}
