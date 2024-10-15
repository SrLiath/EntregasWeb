<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBairrosTable extends Migration
{
    public function up()
    {
        Schema::create('bairros', function (Blueprint $table) {
            $table->id('id_bairro'); // Campo id_bairro como chave primária
            $table->string('nome', 200); // Campo nome
            $table->foreignId('cidade') // Cria a coluna cidade como foreign key
                  ->constrained('cidades', 'id_cidade') // Referência à cidade
                  ->onDelete('cascade'); // Se a cidade for excluída, os bairros também serão
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('bairros'); // Remove a tabela se existir
    }
}
