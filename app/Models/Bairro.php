<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    use HasFactory;

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'id_cidade');
    }
}