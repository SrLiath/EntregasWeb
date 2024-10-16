<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    // Define a tabela associada ao modelo
    protected $table = 'pedidos';

    // Permite a atribuição em massa para esses campos
    protected $fillable = ['nome_cliente', 'data_pedido', 'pedidos', 'id_loja', 'id_pedido_loja', 'valor'];

    // Casting do campo 'pedidos' para JSON automaticamente
    protected $casts = [
        'pedidos' => 'array',
    ];

    /**
     * Função boot para manipular eventos do modelo
     * Garante que id_pedido_loja seja incrementado sequencialmente por loja
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($pedido) {
            // Verifica o usuário autenticado
            $usuario = auth()->user();

            // Verifica se o 'lojaId' do usuário é igual ao 'id_loja' do pedido
            if ($usuario->lojaId !== $pedido->id_loja) {
                throw new \Exception('Usuário não tem permissão para criar ou alterar pedidos nesta loja.');
            }

            // Verifica o último pedido da loja para gerar o próximo número sequencial
            $ultimoPedido = Pedido::where('id_loja', $pedido->id_loja)
                ->orderBy('id_pedido_loja', 'desc')
                ->first();

            // Define o próximo número sequencial
            $pedido->id_pedido_loja = $ultimoPedido ? $ultimoPedido->id_pedido_loja + 1 : 1;
        });
    }

    /**
     * Define uma relação com a tabela 'lojas'
     * Muitos pedidos pertencem a uma loja
     */
    public function loja()
    {
        return $this->belongsTo(Loja::class, 'id_loja');
    }
}