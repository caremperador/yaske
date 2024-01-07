<?php

namespace App\Models;

use App\Models\Lista;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tipo extends Model
{
    use HasFactory;

    public function videos()
    {

        return $this->hasMany(Video::class, 'tipo_id');
    }
    public function listas()
    {
        return $this->hasMany(Lista::class);
    }
}
