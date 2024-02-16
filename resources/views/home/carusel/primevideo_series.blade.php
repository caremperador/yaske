 <!-- Swiper carusel -->
 <div class="swiper swiper-container swiperCarusel my-4">
    <div class="swiper-wrapper">

        @foreach ($seriesPrimevideo as $lista)
            <!-- Slide-->
            <div class="swiper-slide">
                <div class="aspect-w-20 aspect-h-10  relative">
                    <a href="{{ route('listas.show', $lista->id) }}">
                        <img src="{{ asset('storage/' . $lista->thumbnail) }}" alt="Imagen 1"
                            class="w-full h-auto object-cover"></a>
                    <!-- logo de plataforma -->

                    <div class="absolute right-2 top-2 h-5 w-5 lg:h-6 lg:w-6 xl:h-7 xl:w-7  cursor-pointer">
                        @foreach ($lista->categorias as $categoria)
                            @if ($categoria->name == 'prime-video')
                                <img src="/images/logo/logo-prime-video.png" height="35" width="35" />
                            @elseif ($categoria->name == 'netflix')
                                <img src="/images/logo/logo-netflix.png" class="object-contain" />
                            @endif
                        @endforeach

                    </div>
                </div>
                @php
                    $esPremium = $lista->videos->contains(function ($video) {
                        return $video->estado == 1;
                    });
                @endphp
                <p class="px-2 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl truncate overflow-hidden w-full">
                    @if ($esPremium)
                        <i class="fas fa-gem text-yellow-600 mr-1 my-1 text-xs md:text-base"></i>
                    @endif

                    {{ $lista->titulo }}
                </p>
            </div>
        @endforeach
    </div>
    <!--<div class="swiper-pagination"></div>-->
    <div class="swiper-button-next hidden"></div>
    <div class="swiper-button-prev hidden"></div>
</div>
