<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    use HasFactory;

    // Define a tabela associada a este model (opcional se o nome da tabela seguir o padrão)
    protected $table = 'planos';

    // Define os atributos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'descricao',
        'valor',
    ];

    // Define os atributos que devem ser escondidos para arrays
    protected $hidden = [
        // Se houver atributos que você não deseja expor
    ];

    // Se você precisar de qualquer relacionamento com outros models, pode definir aqui
    // Exemplo: 
    // public function categoria()
    // {
    //     return $this->belongsTo(Categoria::class);
    // }
}