@extends('layouts.template-configuracion')

@section('title', 'Resultados de Búsqueda')

@section('content')

    <div class="bg-gray-800 min-h-screen p-4">
        <h2 class="text-2xl font-bold text-white mb-6">Todos los videos</h2>

        <!-- Formulario de Búsqueda -->
        <div class="flex justify-center mb-6">
            <form action="{{ route('admin.todos_los_videos') }}" method="GET" class="w-full max-w-lg">
                <div class="flex items-center border-b border-teal-500 py-2">
                    <input type="search" name="query" placeholder="Buscar videos..."
                        class="appearance-none bg-transparent border-none w-full text-white mr-3 py-1 px-2 leading-tight focus:outline-none"
                        value="{{ request('query') }}">
                    <button type="submit"
                        class="flex-shrink-0 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Buscar
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de Videos -->
        <div class="space-y-4">
            @forelse ($videos as $video)
                <div class="bg-gray-700 rounded-lg overflow-hidden shadow-lg p-4 flex items-center">
                    <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->titulo }}"
                        class="w-32 h-20 object-cover rounded mr-4">
                    <div class="flex-grow">
                        <h3 class="text-xl font-bold text-white">
                            <a href="{{ route('videos.show', $video->id) }}">{{ $video->titulo }}</a>
                        </h3>
                        <div class="flex space-x-2 mt-2">
                            <!-- Idiomas disponibles -->
                            <!-- ... Tus etiquetas de idiomas aquí ... -->
                        </div>
                    </div>
                    <form action="{{ route('admin.video_delete', $video->id) }}" method="POST" class="ml-4 mr-2">
                        @csrf
                        <input type="hidden" name="id" value="{{ $video->id }}">
                        <button type="submit" class="text-red-500 hover:text-red-700">Eliminar</button>
                    </form>

                    <a href="{{ route('videos.edit', $video->id) }}" class="text-orange-500 hover:text-orange-700">Editar</a>

                </div>
            @empty
                <div class="text-white text-center">
                    <p>No se encontraron videos.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $videos->links() }}
        </div>
    </div>

@endsection
