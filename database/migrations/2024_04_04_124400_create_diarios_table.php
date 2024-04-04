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
            $table->text('post_ids')->nullable(); // Permitindo valores nulos
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diarios');
    }
}