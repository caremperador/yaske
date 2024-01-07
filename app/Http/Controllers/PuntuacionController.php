<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Puntuacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PuntuacionController extends Controller
{
    public function store(Request $request, Video $video)
    {
        // Validar la puntuación
        $validatedData = $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
        ]);

        // Verificar si el usuario ya ha votado
        $existingPuntuacion = Puntuacion::where('user_id', Auth::id())
            ->where('video_id', $video->id)
            ->first();

        if ($existingPuntuacion) {
            // Si ya existe una puntuación, actualízala
            $existingPuntuacion->update(['puntuacion' => $validatedData['puntuacion']]);
        } else {
            // Si no existe, crea una nueva puntuación
            Puntuacion::create([
                'user_id' => Auth::id(),
                'video_id' => $video->id,
                'puntuacion' => $validatedData['puntuacion']
            ]);
        }

        return back()->with('success', 'Tu puntuación ha sido guardada.');
    }
}
