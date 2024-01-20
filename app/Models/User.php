<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Comentario;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'token_referido',
        'token_referido_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
    public function puntuaciones()
    {
        return $this->hasMany(Puntuacion::class);
    }
    public function referidos()
    {
        // Asume que tienes una clave foránea 'revendedor_id' en la tabla 'referidos'
        return $this->hasMany(Referido::class, 'revendedor_id');
    }
    public function diasPremiumRevendedor()
    {
        return $this->hasOne(DiasPremiumRevendedor::class, 'user_id');
    }

    protected $dates = [
        'fin_fecha_dias_usuario_premium',
    ];
    public function diasPremiumUsuario()
    {
        return $this->hasOne(DiasPremiumUser::class, 'user_id');
    }
}
