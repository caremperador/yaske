<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminConfiguracionPais extends Model
{
    use HasFactory;

    protected $table = 'admin_configuracion_pais';

    // Asegúrate de que solo estos campos se puedan asignar masivamente.
    protected $fillable = ['pais', 'precio_minimo', 'precio_maximo'];
}
