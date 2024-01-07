<?php

namespace App\Models;

use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\Puntuacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;
    /*  protected $fillable = ['titulo', 'descripcion', 'url_video', 'thumbnail', 'lista_id', 'categoria_id'];
    // o */
    protected $guarded = []; 
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
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
    public function puntuaciones()
    {
        return $this->hasMany(Puntuacion::class);
    }
    public function puntuacionUsuario($user)
    {
        return $this->puntuaciones()->where('user_id', $user->id)->value('puntuacion');
    }
    public function puntuacionPromedio()
    {
        return $this->puntuaciones()->avg('puntuacion');
    }
}
