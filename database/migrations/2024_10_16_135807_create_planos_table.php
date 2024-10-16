<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' com auto incremento
            $table->string('nome', 255); // Coluna 'nome' com limite de 255 caracteres
            $table->text('descricao')->nullable(); // Coluna 'descricao' que permite valores nulos
            $table->decimal('valor', 10, 2); // Coluna 'valor' com duas casas decimais
            $table->timestamps(); // Colunas 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planos'); // Exclui a tabela 'planos' ao reverter a migration
    }
}