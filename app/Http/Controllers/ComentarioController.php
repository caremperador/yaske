<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'video_id' => 'required|exists:videos,id',
            'contenido' => 'required|min:200|max:750', // Añade restricción de longitud máxima
        ]);

        // Verifica si el usuario ya ha comentado en este video
        $existingComment = Comentario::where('user_id', auth()->id())
            ->where('video_id', $request->video_id)
            ->first();

        if ($existingComment) {
            return back()->with('error', 'Ya has comentado en este video.');
        }


        $comentario = new Comentario();
        $comentario->contenido = $request->contenido;
        $comentario->user_id = auth()->id(); // Asigna el ID del usuario autenticado
        $comentario->video_id = $request->video_id;
        $comentario->save();

        return back()->with('success', 'Comentario agregado.');
    }

    public function edit(Comentario $comentario)
    {
        // Verificar que el usuario es el autor del comentario
        if (auth()->id() !== $comentario->user_id) {
            return back()->with('error', 'No tienes permiso para editar este comentario.');
        }

        return view('comentarios.edit', compact('comentario'));
    }

    public function update(Request $request, Comentario $comentario)
    {
        $request->validate([
            'contenido' => 'required|min:200',
        ]);

        // Verificar que el usuario es el autor del comentario
        if (auth()->id() !== $comentario->user_id) {
            return back()->with('error', 'No tienes permiso para editar este comentario.');
        }

        $comentario->contenido = $request->contenido;
        $comentario->save();

        return redirect()->route('videos.show', $comentario->video_id)->with('success', 'Comentario actualizado.');
    }
}
