<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID do usuário que criou a postagem
            $table->text('content')->nullable(); // Conteúdo da postagem (pode ser nulo)
            $table->string('image')->nullable(); // Nome do arquivo de imagem (pode ser nulo)
            $table->timestamps(); // Data de criação e atualização da postagem
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}