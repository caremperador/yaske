<?php

namespace App\Models;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function user() // Cambiado a user()
    {
        return $this->belongsTo(User::class); // Cambiado a User::class
    }
}
