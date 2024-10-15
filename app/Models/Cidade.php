<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    // Define a relação com o modelo Estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id'); 
    }
}

