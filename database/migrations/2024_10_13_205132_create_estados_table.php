<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadosTable extends Migration
{
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->id('id_estado'); // Campo id_estado como chave primária
            $table->string('uf', 2)->unique(); // Campo uf como único
            $table->string('nome', 200); // Campo nome
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('estados'); // Remove a tabela se existir
    }
}
