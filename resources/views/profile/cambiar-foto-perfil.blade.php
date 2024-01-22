{{-- resources/views/cambiar-foto-perfil.blade.php --}}

@extends('layouts.template-configuracion')

@section('title', 'Cambiar Foto de Perfil')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Cambiar Foto de Perfil</h2>
    
    @if (session('success'))
        <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">
            Éxito
        </div>
        <div class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
        <form action="{{ route('cambiar_foto_perfil.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="foto_perfil" class="block text-gray-400 text-sm font-bold mb-2">Subir nueva foto de perfil:</label>
                <input type="file" name="foto_perfil" id="foto_perfil"
                       class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cambiar Foto
            </button>
        </form>
    </div>
</div>
@endsection
