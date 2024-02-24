 <!-- ... (contenedor video) ... -->
 <div>


    <div class="aspect-w-16 rounded-lg aspect-h-9 bg-gray-900">
        <div class="relative" style="padding-top: 56.25%;">
            @php
                $usuarioPremium = Auth::check() && Auth::user()->hasRole('premium');
                $diasPremiumUsuario = $usuarioPremium ? Auth::user()->diasPremiumUsuario()->first() : null;
                $videoUrl = $video->sub_url_video ?? ($video->es_url_video ?? ($video->lat_url_video ?? $video->url_video));
                $fechaFinPasada = $diasPremiumUsuario && $diasPremiumUsuario->fin_fecha_dias_usuario_premium ? Carbon::parse($diasPremiumUsuario->fin_fecha_dias_usuario_premium)->isPast() : true;
            @endphp

            @if ($video->estado == 1)
                @if ($usuarioPremium && ($diasPremiumUsuario->inicio_fecha_dias_usuario_premium == null || $fechaFinPasada))
                    <div
                        class="bg-black rounded-lg absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center">
                        <!-- Container for the play image -->
                        <div class="mb-3">
                            <!-- Add margin bottom to create space between the image and the button -->
                            <form action="{{ route('activar-dia-premium', ['video_id' => $video->id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit">
                                    <img src="/images/complementos/play.png" class="hover:opacity-70"
                                        width="110" height="110" alt="Play" />
                                </button>
                            </form>
                        </div>
                        <!-- Container for the button -->
                        <div>
                            <form action="{{ route('activar-dia-premium', ['video_id' => $video->id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-xs">
                                    <i class="fas fa-gem mr-1"></i>
                                    Gastar un día premium para ver este video
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif ($usuarioPremium)
                    <!-- Mostrar Video -->
                    @if ($videoUrl)
                        <iframe class="videoFrame absolute top-0 left-0 w-full h-full"
                            src="{{ $videoUrl }}" title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    @else
                        {{-- Mostrar alternativa si no hay enlaces de video --}}
                        <p>No hay video disponible</p>
                    @endif
                @else
                    <div
                        class="bg-black rounded-lg absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center">
                        <!-- Container for the play image -->
                        <div class="mb-3">
                            <!-- Add margin bottom to create space between the image and the button -->

                            <a href="{{ route('seleccionarRevendedor') }}">
                                <img src="/images/complementos/play.png" class="opacity-80" width="110"
                                    height="110" alt="Play" />
                            </a>
                        </div>
                        <!-- Container for the button -->
                        <div>
                            <a href="{{ route('seleccionarRevendedor') }}"
                                class="bg-red-800 hover:bg-red-600 uppercase text-white font-bold py-2 px-4 rounded text-xs">
                                <i class="fas fa-lock mr-1" aria-hidden="true"></i>
                                Video premium!
                            </a>
                        </div>
                    </div>
                @endif
            @elseif ($video->estado == 0)
                <!-- Mostrar Video para videos gratis -->
                @if ($videoUrl)
                    <iframe class="videoFrame absolute top-0 left-0 w-full h-full" src="{{ $videoUrl }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                @else
                    {{-- Mostrar alternativa si no hay enlaces de video --}}
                    <p>No hay video disponible</p>
                @endif
            @endif
        </div>
    </div>





    <!-- ... empieza contenedor de informacion del video ... -->
    <div class="mt-1">
        <div class="flex flex-col sm:flex-row">

            @if ($video->sub_url_video)
                <button data-video-url="{{ $video->sub_url_video }}"
                    class="changeVideoButton mx-1 mb-1 bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    <i class="fa fa-volume-up pr-1"></i>Inglés Subtitulado
                </button>
            @endif
            @if ($video->es_url_video)
                <button data-video-url="{{ $video->es_url_video }}"
                    class="changeVideoButton mx-1 mb-1  bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    <i class="fa fa-volume-up pr-1"></i>Español (España)
                </button>
            @endif
            @if ($video->lat_url_video)
                <button data-video-url="{{ $video->lat_url_video }}"
                    class="changeVideoButton x-1 mb-1  bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    <i class="fa fa-volume-up pr-1"></i>Español (Latinoamérica)
                </button>
            @endif
            @if ($video->url_video)
                <button data-video-url="{{ $video->url_video }}"
                    class="changeVideoButton mx-1 mb-1  bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    <i class="fa fa-volume-up pr-1"></i>Inglés
                </button>
            @endif


        </div>

        <div class="mx-auto max-w-7xl px-2 sm:px-2 lg:px-2">
            <h2 class="text-3xl font-bold pt-4">{{ $video->titulo }}</h2>
            <!-- Video description -->
            <p class="text-gray-300 text-sm mt-4">{{ $video->descripcion }}</p>
        </div>
        <div class="flex items-center justify-between mt-3">
            <div class="flex items-center justify-between mt-3">
                <!-- Botones de navegación -->
                @if ($video->lista)
                    <a href="{{ route('listas.show', $video->lista->id) }}"
                        class="text-white bg-blue-600 hover:bg-blue-700 font-semibold py-2 px-4 rounded shadow mr-5">
                        <i class="fas fa-list-ul pr-1"></i> Ir a la Lista
                    </a>
                @endif

                <div class="flex gap-2">
                    @if ($prevVideo)
                        <a href="{{ route('videos.show', $prevVideo->id) }}"
                            class="text-white bg-gray-600 hover:bg-gray-700 font-semibold py-2 px-4 rounded shadow">
                            <i class="fa fa-backward pr-1"></i>Anterior video</a>
                    @endif

                    @if ($nextVideo)
                        <a href="{{ route('videos.show', $nextVideo->id) }}"
                            class="text-white bg-gray-600 hover:bg-gray-700 font-semibold py-2 px-4 rounded shadow">
                            Siguiente video<i class="fa fa-forward pl-1"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- ... fin de contenedor de informacion del video ... -->
</div>
<!-- ... fin de contenedor video ... -->