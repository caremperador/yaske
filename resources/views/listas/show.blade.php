@extends('layouts.template')

@section('title', 'Detalles de la Lista')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Thumbnail, Título y Descripción de la Lista -->
        <div class="mb-8">
            <div class="bg-cover bg-center rounded-lg shadow-md h-64"
                style="background-image: url('{{ $lista->thumbnail }}');"></div>
            <div class="mt-4">
                <h1 class="text-4xl font-bold text-gray-300">{{ $lista->titulo }}</h1>
                <p class="mt-2 text-gray-400">{{ $lista->descripcion }}</p>
            </div>
        </div>

        <div class="bg-gray-800">
            <!-- Lista de Videos Relacionados -->
            <div class="text-white">
                <h2 class="text-xl font-bold mb-4 px-4 pt-4">Videos en esta lista</h2>
                <ul>
                    @forelse ($videos as $video)
                        <li class="border-b border-gray-700">
                            <a href="{{ route('videos.show', $video->id) }}"
                                class="flex items-center p-4 hover:bg-gray-700 transition duration-150 ease-in-out">
                                <div class="flex-shrink-0">
                                    <img src="{{ $video->thumbnail }}" alt="{{ $video->titulo }}"
                                        class="h-20 w-32 object-cover">
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-semibold">{{ $video->titulo }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $video->descripcion }}</p>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="px-4 py-2">
                            <p>No hay videos en esta lista.</p>
                        </li>
                    @endforelse
                </ul>

                <!-- Paginación -->
                <div class="px-4 py-3">
                    {{ $videos->links() }}
                </div>
            </div>
        </div>




    </div>
@endsection

@section('footer')
    <!-- Aquí tu footer si es necesario -->
@endsection
