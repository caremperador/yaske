<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiasPremiumUser extends Model
{
    use HasFactory;
    protected $table = 'diaspremium_users';
    protected $fillable = [
        'user_id',
        'is_activated',
        'dias_usuario_premium',
        'inicio_fecha_dias_usuario_premium',
        'fin_fecha_dias_usuario_premium',
    ];

    protected $dates = [
        'inicio_fecha_dias_usuario_premium',
        'fin_fecha_dias_usuario_premium',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
