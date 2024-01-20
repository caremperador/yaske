{{-- comentarios/edit.blade.php --}}
@extends('layouts.template')

@section('content')
    <form action="{{ route('comentarios.update', $comentario) }}" method="POST">
        @csrf
        @method('PUT')
        @error('contenido')
            <p class="text-red-500 text-2xl">{{ $message }}</p>
        @enderror
        <textarea name="contenido" class="w-full rounded border-gray-300" style="color: black;">{{ $comentario->contenido }}</textarea>
        <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Actualizar mi critica</button>
    </form>
@endsection
