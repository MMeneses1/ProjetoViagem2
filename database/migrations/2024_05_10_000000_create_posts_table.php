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
            $table->unsignedBigInteger('diario_id');
            $table->string('address')->nullable(); // Adicionando a coluna 'address'
            $table->integer('likes')->default('0'); // Adicionando a coluna 'likes'
            $table->timestamps(); // Data de criação e atualização da postagem

            $table->foreign('diario_id')->references('id')->on('diarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}