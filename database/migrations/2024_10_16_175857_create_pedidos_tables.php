<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->string('nome_cliente'); // Nome do cliente
            $table->timestamp('data_pedido')->default(DB::raw('CURRENT_TIMESTAMP')); // Data do pedido com valor padrão "agora"
            $table->json('pedidos'); // Pedidos em formato JSON
            $table->foreignId('id_loja')->constrained('lojas')->onDelete('cascade'); // Chave estrangeira para lojas

            $table->integer('id_pedido_loja'); // Número sequencial do pedido dentro da loja

            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};