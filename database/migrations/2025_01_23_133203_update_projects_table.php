<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('status')->default('à venir'); // en cours, à venir, terminé, annulé
            $table->date('start_date')->nullable();
            $table->string('partners')->nullable();
            $table->json('team_members')->nullable(); // Stocke les membres de l'équipe
            $table->text('risks')->nullable();
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['status', 'start_date', 'partners', 'team_members', 'risks']);
        });
    }
}
