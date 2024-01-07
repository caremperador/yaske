<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Puntuacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador de Puntuaciones
 *
 * Este controlador maneja la lógica de negocio relacionada con las puntuaciones de los videos
 * por parte de los usuarios.
 */
class PuntuacionController extends Controller
{
    /**
     * Almacena una nueva puntuación o actualiza una existente.
     *
     * Este método maneja la solicitud POST enviada desde el formulario de puntuación de la vista.
     * Valida la entrada y luego verifica si el usuario actual ya ha puntuado el video en cuestión.
     * Si es así, actualiza la puntuación existente; de lo contrario, crea una nueva puntuación.
     *
     * @param Request $request La solicitud HTTP con los datos del formulario.
     * @param Video $video El video que está siendo puntuado, inyectado por el enrutamiento de Laravel.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Video $video)
    {
        /* Validación de la entrada de la puntuación.
         * Se asegura de que el campo 'puntuacion' esté presente en la solicitud,
         * que sea un entero y esté entre 1 y 5. */
        $validatedData = $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
        ]);

        // Verificar si el usuario actual ya ha votado por el video.
        $existingPuntuacion = Puntuacion::where('user_id', Auth::id())
            ->where('video_id', $video->id)
            ->first();

        /* Si ya existe una puntuación, actualízala con el nuevo valor.
         * Esto evita que un usuario pueda votar múltiples veces. */
        if ($existingPuntuacion) {
            $existingPuntuacion->update(['puntuacion' => $validatedData['puntuacion']]);
        } else {
            // Si no existe una puntuación previa, crea una nueva con los datos proporcionados.
            Puntuacion::create([
                'user_id' => Auth::id(), // ID del usuario autenticado
                'video_id' => $video->id, // ID del video que se está puntuando
                'puntuacion' => $validatedData['puntuacion'] // Valor de la puntuación
            ]);
        }

        // Redirige al usuario a la página anterior con un mensaje de éxito.
        return back()->with('success', 'Tu puntuación ha sido guardada.');
    }
}
