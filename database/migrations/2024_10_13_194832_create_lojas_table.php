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
        Schema::create('lojas', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->string('imagem'); // Caminho da imagem
            $table->string('nome'); // Nome da loja
            $table->time('horario_inicio'); // Horário de início
            $table->time('horario_fim'); // Horário de fim
            $table->foreignId('id_tipo')->constrained('tipos')->onDelete('cascade'); // Chave estrangeira para tipos
            $table->foreignId('id_categoria')->constrained('categorias')->onDelete('cascade'); // Chave estrangeira para categorias
            
            // Novos campos para estados, cidades e bairros atendidos
            $table->json('estados_atendidos');
            $table->json('cidades_atendidas'); 
            $table->json('bairros_atendidos'); 
            
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lojas');
    }
};
