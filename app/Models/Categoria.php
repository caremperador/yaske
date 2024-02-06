<?php

namespace App\Models;

use App\Models\Lista;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;
    // En el modelo Categoria
    public function listas()
    {
        return $this->belongsToMany(Lista::class, 'categoria_lista');
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'video_categoria');
    }
}
