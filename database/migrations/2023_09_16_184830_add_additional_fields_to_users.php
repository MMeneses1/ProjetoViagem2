<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToUsers extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('sexo')->nullable();
            $table->text('biografia')->nullable();
            $table->string('telefone')->nullable();
            $table->string('pais')->nullable();
            $table->string('idioma')->nullable();
            $table->string('foto_perfil')->nullable();
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['sexo', 'biografia', 'telefone', 'pais', 'idioma', 'foto_perfil']);
        });
    }
}
