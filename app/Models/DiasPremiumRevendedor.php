<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\AdminConfiguracionPais;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiasPremiumRevendedor extends Model
{
    use HasFactory;
    protected $table = 'diaspremium_revendedores';
    protected $fillable = [
        'user_id', 'dias_revendedor_premium', 'estado_conectado', 'ultimo_conexion',
        'metodos_pago', 'pais', 'numero_telefono', 'mensaje_perfil',
        'transacciones_exitosas', 'transacciones_rechazadas', 'transacciones_canceladas', 'nombres_beneficiario', 'apellidos_beneficiario', 'link_telegram', 'link_whatsapp', 'cantidad_minima', 'precio'
    ];

    protected $dates = ['ultimo_conexion'];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
   
    public function configuracionPais()
    {
        return $this->belongsTo(AdminConfiguracionPais::class, 'pais', 'pais');
    }
}
