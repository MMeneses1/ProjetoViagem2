<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiariosTable extends Migration
{
    public function up()
    {
        Schema::create('diarios', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('address')->nullable(); // Adicionando a coluna 'address'
            $table->text('post_ids')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diarios');
    }
}
