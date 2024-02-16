@extends('layouts.template')
@section('title', 'Inicio')

@section('content')



    <!-- Swiper -->
    <div class="swiper SwiperPortadas h-auto rounded-lg">
        <div class="swiper-wrapper">

            @forelse ($videosCalidadCam as $video)
                <!-- Slide  -->
                <div class="swiper-slide">
                    <div class="flex border border-black bg-black relative">
                        <!-- div izquierda -->
                        <div class="flex flex-col justify-center p-10 items-center z-20 text-justify text-white w-1/2">
                            <h2 class="text-base md:text-2xl lg:text-3xl xl:text-4xl font-bold mb-3 tracking-tighter">{{ $video->titulo }}</h2>
                            <p class="text-xs md:text-base lg:text-lg sm:hidden mb-5">
                                {{ Str::limit($video->descripcion, 100, '...') }}
                            </p>
                            <div class="flex items-center space-x-2">
                                <!-- Icono de play -->
                                <a href="{{ route('videos.show', $video->id) }}"> <i
                                        class="fas fa-play-circle text-3xl md:text-4xl lg:text-5xl xl:text-6xl"></i>
                                    <span
                                        class="sm:text-lg md:text-xl lg:text-2xl xl:text-3xl  font-semibold">Play</span></a>
                            </div>
                        </div>
                        <!-- div derecha con la imagen -->
                        <div class="w-1/2 max-h-full pt-10 md:pt-0 bg-cover bg-center">
                            <div>
                                <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Placeholder Image"
                                    class="w-full h-full object-cover" />
                            </div>
                        </div>
                        <!-- div con el degradado, que se superpone sobre la imagen -->
                        <div class="absolute top-0 right-0 bottom-0 w-[55%] h-full z-20 pointer-events-none ">
                            <div
                                class="h-full bg-gradient-to-r from-black from-10% from via-black/25 via-30% to-black/0 to-90%">
                            </div>
                        </div>
                    </div>
                </div>


            @empty

                <p>No se encontraron videos.</p>
            @endforelse
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div class="px-4 pt-5 text-xl md:text-2xl lg:text-3xl">Ultimos videos agregados <a href="#"><i
                class="fas fa-angle-double-right"></i>
        </a></div>


    <!-- Swiper carusel -->
    <div class="swiper swiper-container swiperCarusel my-4">
        <div class="swiper-wrapper">

            @foreach ($videos as $video)
                <!-- Slide-->
                <div class="swiper-slide">
                    <div class="aspect-w-20 aspect-h-10  relative">
                        <a href="{{ route('videos.show', $video->id) }}">
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Imagen 1"
                                class="w-full h-auto object-cover"></a>
                        <!-- logo de plataforma -->

                        <div class="absolute right-2 top-2 h-5 w-5 lg:h-6 lg:w-6 xl:h-7 xl:w-7  cursor-pointer">
                            @foreach ($video->categorias as $categoria)
                                @if ($categoria->name == 'amazon-prime')
                                    <img src="/images/logo/logo-prime-video.png" height="35" width="35" />
                                @elseif ($categoria->name == 'netflix')
                                    <img src="/images/logo/logo-netflix.png" class="object-contain" />
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <p class="px-2 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl truncate overflow-hidden w-full">
                        @if ($video->estado == 1)
                            <i class="fas fa-gem text-yellow-600 mr-1 my-1 text-xs md:text-base"></i>
                        @endif

                        {{ $video->titulo }}
                    </p>
                </div>
            @endforeach
        </div>
        <!--<div class="swiper-pagination"></div>-->
        <div class="swiper-button-next hidden"></div>
        <div class="swiper-button-prev hidden"></div>
    </div>



    <div class="px-4 pt-5 text-xl md:text-2xl lg:text-3xl">Estrenos netflix <a href="#"><i
                class="fas fa-angle-double-right"></i>
        </a></div>

    <!-- Swiper carusel -->
    <div class="swiper swiper-container swiperCarusel my-4">
        <div class="swiper-wrapper">

            @foreach ($estrenosNetflix as $video)
                <!-- Slide-->
                <div class="swiper-slide">
                    <div class="aspect-w-20 aspect-h-10  relative">
                        <a href="{{ route('videos.show', $video->id) }}">
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Imagen 1"
                                class="w-full h-auto object-cover"></a>
                        <!-- logo de plataforma -->

                        <div class="absolute right-2 top-2 h-5 w-5 lg:h-6 lg:w-6 xl:h-7 xl:w-7  cursor-pointer">
                            @foreach ($video->categorias as $categoria)
                                @if ($categoria->name == 'amazon-prime')
                                    <img src="/images/logo/logo-prime-video.png" height="35" width="35" />
                                @elseif ($categoria->name == 'netflix')
                                    <img src="/images/logo/logo-netflix.png" class="object-contain" />
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <p class="px-2 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl truncate overflow-hidden w-full">
                        @if ($video->estado == 1)
                            <i class="fas fa-gem text-yellow-600 mr-1 my-1 text-xs md:text-base"></i>
                        @endif

                        {{ $video->titulo }}
                    </p>
                </div>
            @endforeach
        </div>
        <!--<div class="swiper-pagination"></div>-->
        <div class="swiper-button-next hidden"></div>
        <div class="swiper-button-prev hidden"></div>
    </div>





    <div class="px-4 pt-5 text-xl md:text-2xl lg:text-3xl">Peliculas <a href="#"><i
                class="fas fa-angle-double-right"></i>
        </a></div>

    <!-- Swiper carusel -->
    <div class="swiper swiper-container swiperCarusel my-4">
        <div class="swiper-wrapper">

            @foreach ($peliculas as $video)
                <!-- Slide-->
                <div class="swiper-slide">
                    <div class="aspect-w-20 aspect-h-10  relative">
                        <a href="{{ route('videos.show', $video->id) }}">
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Imagen 1"
                                class="w-full h-auto object-cover"></a>
                        <!-- logo de plataforma -->

                        <div class="absolute right-2 top-2 h-5 w-5 lg:h-6 lg:w-6 xl:h-7 xl:w-7  cursor-pointer">
                            @foreach ($video->categorias as $categoria)
                                @if ($categoria->name == 'amazon-prime')
                                    <img src="/images/logo/logo-prime-video.png" height="35" width="35" />
                                @elseif ($categoria->name == 'netflix')
                                    <img src="/images/logo/logo-netflix.png" class="object-contain" />
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <p class="px-2 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl truncate overflow-hidden w-full">
                        @if ($video->estado == 1)
                            <i class="fas fa-gem text-yellow-600 mr-1 my-1 text-xs md:text-base"></i>
                        @endif

                        {{ $video->titulo }}
                    </p>
                </div>
            @endforeach
        </div>
        <!--<div class="swiper-pagination"></div>-->
        <div class="swiper-button-next hidden"></div>
        <div class="swiper-button-prev hidden"></div>
    </div>


    {{-- 


    <div class="flex flex-col justify-center">

        <div class="relative m-3 flex flex-wrap mx-auto justify-center">



            <div class="grid xs:grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3  2xl:grid-cols-4 gap-2">
                @foreach ($videos as $video)
                    <!-- video card -->
                    <div class="relative w-[340px] bg-white/5 shadow-md rounded-3xl p-2 mx-1 my-3 ">
                        <div class="overflow-x-hidden rounded-2xl relative thumbnail-container"
                            onMouseOver="showPlayIcon(this)" onMouseOut="hidePlayIcon(this)">
                            <a href="{{ route('videos.show', $video->id) }}" class="block"> <img
                                    class="h-40 rounded-2xl w-full object-cover"
                                    src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->titulo }}">
                                <img src="/images/complementos/play.png" width="60" height="60" class="play-icon"
                                    alt="Play"
                                    style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" />
                            </a>
                            @if ($video->lista)
                                <a href="{{ route('listas.show', $video->lista->id) }}"
                                    class="absolute left-2 top-2 cursor-pointer"><i class="fas fa-list-ul"></i></a>
                            @endif

                            <p class="absolute right-2 top-2 cursor-pointer">
                                @foreach ($video->categorias as $categoria)
                                    @if ($categoria->name == 'amazon-prime')
                                        <img src="/images/logo/logo-prime-video.png" height="35" width="35" />
                                    @elseif ($categoria->name == 'netflix')
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
    </div> --}}


@endsection
