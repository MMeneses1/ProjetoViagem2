<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaginaTable extends Migration
{
    public function up()
    {
        Schema::create('pagina', function (Blueprint $table) {
            $table->id();
            $table->text('content')->nullable(); // Conteúdo da postagem (pode ser nulo)
            $table->string('image')->nullable(); // Nome do arquivo de imagem (pode ser nulo)
            $table->unsignedBigInteger('post_id');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagina');
    }
}
