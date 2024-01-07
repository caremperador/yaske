<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Puntuacion
 *
 * Este modelo representa la puntuación que un usuario da a un video. Laravel automáticamente
 * asocia este modelo con una tabla llamada 'puntuacions' en la base de datos.
 */
class Puntuacion extends Model
{
    use HasFactory; // Trait incluido por Laravel para ayudar con la creación de instancias del modelo.

    /**
     * @var string $table Nombre de la tabla asociada con el modelo.
     */
    protected $table = 'puntuacions';

    /**
     * @var array $fillable Atributos que son asignables en masa.
     *
     * 'fillable' es una propiedad de seguridad que define qué atributos pueden ser asignados en masa.
     * Esto significa que al crear o actualizar una instancia del modelo, solo los atributos definidos aquí
     * pueden ser establecidos directamente desde la entrada del usuario.
     */
    protected $fillable = ['user_id', 'video_id', 'puntuacion'];

    /**
     * Relación uno a muchos inversa con el modelo User.
     *
     * Esta función define una relación inversa con el modelo User, indicando que cada puntuación pertenece
     * a un usuario. Esto permite acceder al usuario que realizó una puntuación mediante la propiedad 'user'
     * en una instancia de Puntuacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // 'belongsTo' indica que Puntuacion pertenece a User.
        return $this->belongsTo(User::class);
    }

    /**
     * Relación uno a muchos inversa con el modelo Video.
     *
     * Similar a la función user(), esta función define una relación con el modelo Video, indicando que
     * cada puntuación pertenece a un video. Esto permite acceder al video que fue puntuado mediante la
     * propiedad 'video' en una instancia de Puntuacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video()
    {
        // 'belongsTo' indica que Puntuacion pertenece a Video.
        return $this->belongsTo(Video::class);
    }
}
