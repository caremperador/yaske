<?php

namespace App\Models;

use App\Models\Tipo;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lista extends Model
{
    use HasFactory;

    
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
