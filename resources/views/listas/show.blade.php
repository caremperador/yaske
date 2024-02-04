@extends('layouts.template')

@section('title', 'Lista ' . $lista->titulo)

@section('content')
    <div class="mx-auto max-w-7xl px-1 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="mx-auto max-w-7xl">

            <div class="flow-root mb-4">
                <div class="float-left mr-2 mb-1">
                    <img src="{{ asset('storage/' . $lista->thumbnail) }}" class="w-84 h-40 object-cover"
                        alt="{{ $lista->titulo }}" />
                </div>
                <div class="mt-1">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-300 "> <!-- Truncates text if it overflows -->
                        {{ $lista->titulo }}
                    </h1>
                    <p class="text-gray-400  text-ellipsis">{{ $lista->descripcion }}
                    </p>
                </div>
            </div>

            <div class="bg-gray-800 ">
                <!-- Lista de Videos Relacionados -->
                <div class="text-white">
                    <h2 class="text-xl font-bold mb-4 px-4 pt-4">Videos en esta lista</h2>

                    @forelse ($videos as $video)
                        <a href="{{ route('videos.show', $video->id) }}"
                            class="hover:bg-gray-700 transition duration-150 ease-in-out block relative">
                            <div class="border-b border-gray-700 flow-root">

                                <div class="relative h-24 w-36 float-left mr-1 mb-1 thumbnail-container"
                                    onMouseOver="showPlayIcon(this)" onMouseOut="hidePlayIcon(this)">
                                    <!-- Thumbnail -->
                                    <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->titulo }}"
                                        class="h-24 w-36 object-cover">
                                    <!-- Play Button -->
                                    <img src="/images/complementos/play.png" alt="Play" class="play-icon hidden absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" width="50" height="50" />


                                    <!-- Estado del video -->
                                    <p class="absolute bottom-1 right-1 cursor-pointer">
                                        @if ($video->estado == 0)
                                            <span
                                                class="text-xxs text-gray-300 font-bold  bg-green-800 px-1 py-1 rounded">Gratis</span>
                                        @else
                                            <span
                                                class="text-xxs text-gray-300 font-bold  bg-red-800 px-1 py-1 rounded">Premium</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="mt-1">
                                    <h1 class="text-md font-bold text-gray-300 truncate">{{ $video->titulo }}</h1>
                                    <p class="text-gray-400 text-ellipsis truncate">{{ $video->descripcion }}</p>

                                    <!-- Idiomas disponibles -->
                                    @if ($video->url_video)
                                        <span class="text-xxs bg-gray-700 px-2 py-1 rounded"><i
                                                class="fa fa-volume-up pr-1"></i>Ing</span>
                                    @endif
                                    @if ($video->es_url_video)
                                        <span class="text-xxs bg-gray-700 px-2 py-1 rounded"><i
                                                class="fa fa-volume-up pr-1"></i>Esp</span>
                                    @endif
                                    @if ($video->lat_url_video)
                                        <span class="text-xxs bg-gray-700 px-2 py-1 rounded"><i
                                                class="fa fa-volume-up pr-1"></i>Lat</span>
                                    @endif
                                    @if ($video->sub_url_video)
                                        <span class="text-xxs bg-gray-700 px-2 py-1 rounded"><i
                                                class="fa fa-volume-up pr-1"></i>Sub</span>
                                    @endif
                                </div>
                            </div>
                        </a>

                    @empty
                        <div class="px-4 py-2">
                            <p>No hay videos en esta lista.</p>
                        </div>
                    @endforelse


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
