<?php

// App\Http\Controllers\UsuariosCompradores.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsuariosCompradoresController extends Controller

{
    public function index_cambiar_foto_perfil()
    {
        $user = Auth::user();
        return view('profile.cambiar-foto-perfil', compact('user'));
    }
    public function store_cambiar_foto_perfil(Request $request)
    {
        $request->validate([
            'foto_perfil' => 'required|image|max:2048', // Limitar el tamaño del archivo a 2MB
        ]);

        $user = Auth::user();

        if ($request->hasFile('foto_perfil') && $request->file('foto_perfil')->isValid()) {
            // Borrar la foto de perfil antigua si existe
            if ($user->foto_perfil) {
                Storage::delete('public/' . $user->foto_perfil);
            }

            // Almacenar la nueva foto de perfil
            $path = $request->foto_perfil->store('fotos_perfil', 'public');
            $user->foto_perfil = $path;
            $user->save();

            return back()->with('success', 'Foto de perfil actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo actualizar la foto de perfil.');
    }
}
