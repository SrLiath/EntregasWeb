<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loja extends Model
{
    use HasFactory;

    protected $table = 'lojas';

    protected $fillable = [
        'imagem',
        'nome',
        'horario_inicio',
        'horario_fim',
        'id_tipo',
        'estados_atendidos',
        'cidades_atendidas',
        'bairros_atendidos',
        'produtos',
        'responsavel',
        'cpf',
        'tel',
        'email',
        'senha',
        'site',
        'insta',
        'fb',
        'wpp',
        'tel2',
        'abertura',
        'fechamento',
        'estabelecimento',
        'url',
        'dias'
    ];

    protected $casts = [
        'estados_atendidos' => 'array',
        'cidades_atendidas' => 'array',
        'bairros_atendidos' => 'array',
        // Cast other fields as necessary
    ];

    // Relacionamento com o modelo Tipo
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'id_tipo');
    }

    // Relacionamento com o modelo Categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}
