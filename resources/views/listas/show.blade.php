@extends('layouts.template')

@section('title', 'Lista ' . $lista->titulo)

@section('content')
    <div class="mx-auto max-w-7xl px-1 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="mx-auto max-w-7xl">

            <div class="flow-root mb-4">
                <div class="float-left mr-2 mb-1">
                    <img src="{{ $lista->thumbnail }}" class="w-84 h-40 object-cover" alt="{{ $lista->titulo }}" />
                </div>
                <div class="mt-1">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-300 "> <!-- Truncates text if it overflows -->
                        {{ $lista->titulo }}
                    </h1>
                    <p class="text-gray-400  text-ellipsis">{{ $lista->descripcion }}
                    </p>
                </div>
            </div>

            <div class="bg-gray-800 clearfix ">
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
    </div>
@endsection

@section('footer')
    <!-- Aquí tu footer si es necesario -->
@endsection
