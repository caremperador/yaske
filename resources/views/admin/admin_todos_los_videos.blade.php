@extends('layouts.template-configuracion')
@section('title', 'Resultados de Búsqueda')
@section('content')

    <div class="bg-gray-800">


        <h2 class="text-xl font-bold mb-4 px-4 pt-4">Resultados de Búsqueda</h2>

        <!-- Formulario de Búsqueda -->
        <div class="flex justify-center my-4">
            <form action="{{ route('admin.todos_los_videos') }}" method="GET" class="w-full max-w-md">
                <div class="flex items-center border-b border-black py-2">
                    <input type="search" name="query" placeholder="Buscar videos..."
                        class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                    <button type="submit"
                        class="flex-shrink-0 bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-sm border-4 text-white py-1 px-2 rounded">
                        <i class="fa fa-search pr-1"></i>Buscar
                    </button>
                </div>
            </form>
        </div>

        <ul>
            @forelse ($videos as $video)
                <li>
                    {{ $video->titulo }}
                    <form action="{{ route('admin.video_delete', $video->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $video->id }}">
                        <button type="submit">Eliminar</button>
                    </form>
                </li>
            @empty
                <li class="px-4 py-2">
                    <p>No se encontraron videos.</p>
                </li>
            @endforelse
        </ul>

        <!-- Paginación -->
        <div class="px-4 py-3">
            {{ $videos->links() }}
        </div>
    </div>

@endsection
