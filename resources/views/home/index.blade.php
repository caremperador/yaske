@extends('layouts.template')
@section('title', 'Inicio')

@section('content')
    {{-- <div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @foreach ($secciones as $seccion)
            <!-- Sección -->
            <h2 class="text-3xl font-bold text-white mb-4">{{ $seccion['tipo']->name }}</h2>
            
            <!-- Videos sin lista -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach ($seccion['videos'] as $video)
                    <!-- Video card -->
                    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <a href="{{ route('videos.show', $video->id) }}" class="block">
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->titulo }}" class="w-full h-36 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-white">{{ $video->titulo }}</h3>
                                <!-- Información del video -->
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Listas del tipo -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach ($seccion['listas'] as $lista)
                    <!-- Lista card -->
                    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <a href="{{ route('listas.show', $lista->id) }}" class="block">
                            <img src="{{ $lista->thumbnail }}" alt="{{ $lista->titulo }}" class="w-full h-36 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-white">{{ $lista->titulo }}</h3>
                                <!-- Información de la lista -->
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div> --}}


    <div class="flex flex-col justify-center">
        <div class="relative m-3 flex flex-wrap mx-auto justify-center">
            <div class="grid xs:grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2  2xl:grid-cols-4 gap-2">
                @foreach ($videos as $video)
                    <!-- video card -->
                    <div class="relative w-[340px] bg-white/5 shadow-md rounded-3xl p-2 mx-1 my-3 ">
                        <div class="overflow-x-hidden rounded-2xl relative">
                            <a href="{{ route('videos.show', $video->id) }}" class="block"> <img
                                    class="h-40 rounded-2xl w-full object-cover"
                                    src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->titulo }}"></a>
                            @if ($video->lista)
                                <a href="{{ route('listas.show', $video->lista->id) }}"
                                    class="absolute left-2 top-2 cursor-pointer"><i class="fas fa-list-ul"></i></a>
                            @endif
                            <p class="absolute right-2 top-2 cursor-pointer">
                                @foreach ($video->categorias as $categoria)
                                    @if ($categoria->name == 'Prime Video')
                                        <img src="/images/logo/logo-prime-video.png" height="35" width="35" />
                                    @elseif ($categoria->name == 'Netflix')
                                        <img src="/images/logo/logo-netflix.png" height="35" width="35" />
                                    @endif
                                @endforeach
                            </p>
                        </div>
                        <div class="mt-4 pl-2 mb-2 flex justify-between ">
                            <div>
                                <p class="text-md font-semibold text-gray-200 mb-4 line-clamp-1">{{ $video->titulo }}
                                </p>
                                <p class="text-md text-gray-400 mt-0"></p>
                                <!-- Idiomas disponibles -->
                                @if ($video->url_video)
                                    <span class="text-xxs text-gray-300 uppercase bg-gray-600 px-2 py-1 rounded"><i
                                            class="fa fa-volume-up pr-1"></i>Ing</span>
                                @endif
                                @if ($video->es_url_video)
                                    <span class="text-xxs text-gray-300 uppercase bg-gray-600 px-2 py-1 rounded"><i
                                            class="fa fa-volume-up pr-1"></i>Es</span>
                                @endif
                                @if ($video->lat_url_video)
                                    <span class="text-xxs text-gray-300 uppercase bg-gray-600 px-2 py-1 rounded"><i
                                            class="fa fa-volume-up pr-1"></i>Lat</span>
                                @endif
                                @if ($video->sub_url_video)
                                    <span class="text-xxs text-gray-300 uppercase bg-gray-600 px-2 py-1 rounded"><i
                                            class="fa fa-volume-up pr-1"></i>Sub</span>
                                @endif
                            </div>
                            <div class="flex flex-col-reverse mb-1 mr-2 text- group cursor-pointer">
                                @if ($video->estado == 0)
                                    <span
                                        class="text-xxs text-gray-300 font-bold uppercase bg-green-800 px-2 py-1 rounded">Gratis</span>
                                @else
                                    <span
                                        class="text-xxs text-gray-300 font-bold uppercase bg-red-800 px-2 py-1 rounded">Premium</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>

    </div>


    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="mx-auto max-w-3xl">
            <!-- Paginación -->
            <div class="my-6">
                {{ $videos->links() }}
            </div>
        </div>
    </div>


@endsection
