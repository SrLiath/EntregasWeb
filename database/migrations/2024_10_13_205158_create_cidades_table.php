<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCidadesTable extends Migration
{
    public function up()
    {
        Schema::create('cidades', function (Blueprint $table) {
            $table->id('id_cidade'); // Campo id_cidade como chave primária
            $table->string('nome', 150); // Campo nome
            $table->foreignId('estado') // Cria a coluna estado como foreign key
                  ->constrained('estados', 'id_estado') // Referência ao estado
                  ->onDelete('cascade'); // Se o estado for excluído, as cidades também serão
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('cidades'); // Remove a tabela se existir
    }
}
