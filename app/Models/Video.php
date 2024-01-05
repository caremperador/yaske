<?php

namespace App\Models;

use App\Models\Tipo;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;
    /*  protected $fillable = ['titulo', 'descripcion', 'url_video', 'thumbnail', 'lista_id', 'categoria_id'];
    // o
    protected $guarded = []; */
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'video_categoria', 'video_id', 'categoria_id');
    }
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }
    public function lista()
    {
        return $this->belongsTo(Lista::class);
    }
}
