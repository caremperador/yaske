<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Referido extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'revendedor_id'];

    public function referido()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function revendedor()
    {
        return $this->belongsTo(User::class, 'revendedor_id');
    }
}
