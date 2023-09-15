<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->string('email')->unique(); // Campo de e-mail único
            $table->string('nome');
            $table->string('username')->unique(); // Nome de usuário único
            $table->string('password');
            $table->timestamps(); // Campos de data e hora de criação/atualização
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
