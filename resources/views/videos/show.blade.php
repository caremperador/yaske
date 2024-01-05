@extends('layouts.template')
@section('title', 'Yaske - Pagina principal')
@section('content')



    <div class="flex justify-center">
        <div class="w-full lg:w-8/12 xl:w-9/12">

            <div class="aspect-w-16 aspect-h-9 bg-gray-900">

                <!-- Responsive Video Container -->
                <div class="relative" style="padding-top: 56.25%;">
                    <!-- YouTube Video Embed -->
                    <iframe class="absolute top-0 left-0 w-full h-full" src="{{ $video->url_video }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>


            <div class="mt-4">
                <h2 class="text-2xl font-bold">{{ $video->titulo }}</h2>
                <p class="text-gray-400 text-sm mt-1">{{ $video->name }} </p>
                <!-- Video description -->
                <p class="text-gray-400 text-sm mt-4">{{ $video->descripcion }}</p>
                <div class="flex items-center justify-between mt-3">



                    <div class="flex items-center justify-between mt-3">
                        <!-- Botones de navegación -->
                        @if ($video->lista)
                            <a href="{{ route('listas.show', $video->lista->id) }}"
                                class="text-white bg-blue-600 hover:bg-blue-700 font-semibold py-2 px-4 rounded shadow mr-5">
                                Ir a la Lista de Videos
                            </a>
                        @endif

                        <div class="flex gap-2">
                            @if ($prevVideo)
                                <a href="{{ route('videos.show', $prevVideo->id) }}"
                                    class="text-white bg-gray-600 hover:bg-gray-700 font-semibold py-2 px-4 rounded shadow">
                                    Anterior
                                </a>
                            @endif

                            @if ($nextVideo)
                                <a href="{{ route('videos.show', $nextVideo->id) }}"
                                    class="text-white bg-gray-600 hover:bg-gray-700 font-semibold py-2 px-4 rounded shadow">
                                    Siguiente
                                </a>
                            @endif
                        </div>
                    </div>



                </div>

            </div>
        </div>

    </div>

    {{-- Sección de Comentarios --}}
    <div class="mt-8 bg-gray-800 p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-white">Críticas para este video</h3>

        {{-- Mensajes de éxito o error --}}
        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario de Comentarios --}}
        @auth
            <form action="{{ route('comentarios.store') }}" method="POST">
                @csrf
                <input type="hidden" name="video_id" value="{{ $video->id }}">
                <textarea name="contenido" class="w-full rounded border-gray-300 p-2" style="color: black;" placeholder="Añade un comentario..."
                    minlength="200" maxlength="750"></textarea>
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Añadir crítica</button>
            </form>
        @else
            <p><a href="{{ route('login') }}" class="text-blue-600">Inicia sesión</a> para comentar.</p>
        @endauth

        {{-- Mostrar Comentarios --}}
        @foreach ($video->comentarios as $comentario)
            <div class="bg-gray-700 text-white mt-4 p-4 rounded shadow">
                <div class="flex items-center mb-2">
                    <!-- Heroicons: user icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 14.474l-1.05 1.05a9 9 0 1012.728 0l-1.05-1.05m-10.606 0h10.606" />
                    </svg>
                    <strong>{{ $comentario->user->name }}</strong>
                    @if (auth()->id() === $comentario->user_id)
                        <a href="{{ route('comentarios.edit', $comentario) }}" class="ml-auto text-blue-500">Editar</a>
                    @endif
                </div>
                <p>{{ $comentario->contenido }}</p>
            </div>
        @endforeach
    </div>
    </div>
    </div>


@endsection
@section('footer')





@endsection
