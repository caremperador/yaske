<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    public function listas()
    {
        return $this->hasMany(Lista::class);
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'video_categoria');
    }
}
