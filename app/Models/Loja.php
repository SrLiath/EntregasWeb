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
        'id_categoria',
        'estados_atendidos',
        'cidades_atendidas',
        'bairros_atendidos',
        'produtos'
    ];

    protected $casts = [
        'estados_atendidos' => 'array',
        'cidades_atendidas' => 'array',
        'bairros_atendidos' => 'array',
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