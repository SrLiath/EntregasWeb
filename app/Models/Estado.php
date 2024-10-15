<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    // Define a relação com o modelo Cidade
    public function cidades()
    {
        return $this->hasMany(Cidade::class, 'id_estado'); // ajuste 'estado_id' se o nome da chave estrangeira for diferente
    }
}
