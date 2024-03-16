@inject('diasPremiumController', 'App\Http\Controllers\DiasPremiumController')
@php
    use Carbon\Carbon;
@endphp
@extends('layouts.template')
@section('title', 'Yaske - Ver ' . $video->titulo . ' online')
@section('meta-descripcion', 'Ver gratis ' . $video->titulo . ' completo online en HD. ' . $video->descripcion)
@section('metas-wsp-tg-tw')
    <!-- ... otras etiquetas ... -->
    <meta property="og:title" content="{{ $video->titulo }}" />
    <meta property="og:description" content="{{ $video->descripcion }}" />
    <meta property="og:image" content="{{ asset('storage/' . $video->thumbnail) }}" />
    <meta property="og:url" content="https://tusitio.com/pagina-del-post" />

    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{ $video->titulo }}" />
    <meta property="twitter:description" content="{{ $video->descripcion }}" />
    <meta property="twitter:image" content="{{ asset('storage/' . $video->thumbnail) }}" />
@endsection
@section('background')

    <div class="relative w-full">
        <p class="absolute top-4 right-3">Visitas: {{ $video->views_count }}</p>
        <!-- La imagen ocupa el ancho completo y su exceso de altura se oculta -->
        <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Imagen de portada"
            class="w-full h-auto md:max-h-screen object-cover object-top">

        <!-- Degradado de izquierda a derecha -->
        <div class="absolute inset-0 left-0 hidden sm:block"
            style="
      background-image: 
        linear-gradient(to left, rgba(0, 0, 0, 0) 10%, #111827 85%);
  "></div>
        <!-- Degradado de abajo hacia arriba -->
        <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-gray-900 to-transparent"></div>
        <!-- Contenido superpuesto, como título y botones, si es necesario -->
        <div class="absolute bottom-0 left-0 p-4 w-full md:w-[85%] lg:w-[75%] xl:w-[60] xl:mb-20">
            <!-- Otros elementos del contenido... -->
            <div class=" text-white p-4 rounded-lg">
                <p class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-2 md:mb-4 text-center md:text-left">
                    {{ $video->titulo }}</p>
                <div class="hidden md:inline-flex flex-col text-xs lg:text-base">
                    @if ($video->sub_url_video)
                        <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'sub']) }}"
                            class="bg-white text-black rounded-full px-4 py-2 mb-4">
                            <i class="fa fa-play mr-1"></i>Play Subtitulado Premium
                        </a>
                    @endif
                    @if ($video->es_url_video)
                        <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'es']) }}"
                            class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                            Español (España) Premium</a>
                    @endif
                    @if ($video->lat_url_video)
                        <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'lat']) }}"
                            class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                            Español (Latinoamérica) Premium</a>
                    @endif
                    @if ($video->url_video)
                        <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'eng']) }}"
                            class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                            Inglés Premium</a>
                    @endif
                    {{-- links gratis --}}
                    @if ($video->sub_url_video_gratis)
                        <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'sub-gratis']) }}"
                            class="bg-white text-black rounded-full px-4 py-2 mb-4">
                            <i class="fa fa-play mr-1"></i>Play Subtitulado gratis
                        </a>
                    @endif
                    @if ($video->es_url_video_gratis)
                        <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'es-gratis']) }}"
                            class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                            Español (España) gratis</a>
                    @endif
                    @if ($video->lat_url_video_gratis)
                        <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'lat-gratis']) }}"
                            class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                            Español (Latinoamérica) gratis</a>
                    @endif
                    @if ($video->url_video_gratis)
                        <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'eng-gratis']) }}"
                            class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                            Inglés gratis</a>
                    @endif
                </div>
            </div>
            <p class="hidden xl:block lg:text-2xl px-4 mb-5">{{ $video->descripcion }}</p>
        </div>
    </div>

    <div class="md:hidden flex flex-col mx-2 text-center">
        @if ($video->sub_url_video)
            <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'sub']) }}"
                class="bg-white text-black rounded-full px-4 py-2 mb-4">
                <i class="fa fa-play mr-1"></i>Play Subtitulado Premium
            </a>
        @endif
        @if ($video->es_url_video)
            <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'es']) }}"
                class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                Español (España) Premium</a>
        @endif
        @if ($video->lat_url_video)
            <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'lat']) }}"
                class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                Español (Latinoamérica) Premium</a>
        @endif
        @if ($video->url_video)
            <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'eng']) }}"
                class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                Inglés Premium</a>
        @endif
        {{-- links gratis --}}
        @if ($video->sub_url_video_gratis)
            <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'sub-gratis']) }}"
                class="bg-white text-black rounded-full px-4 py-2 mb-4">
                <i class="fa fa-play mr-1"></i>Play Subtitulado gratis
            </a>
        @endif
        @if ($video->es_url_video_gratis)
            <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'es-gratis']) }}"
                class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                Español (España) gratis</a>
        @endif
        @if ($video->lat_url_video_gratis)
            <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'lat-gratis']) }}"
                class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                Español (Latinoamérica) gratis</a>
        @endif
        @if ($video->url_video_gratis)
            <a href="{{ route('videos.mostrarVideo', ['video' => $video->id, 'idioma' => 'eng-gratis']) }}"
                class="bg-white text-black rounded-full px-4 py-2 mb-4"><i class="fa fa-play mr-1"></i>Play
                Inglés gratis</a>
        @endif
    </div>

    <p class="block xl:hidden m-2">{{ $video->descripcion }}</p>


@endsection
@section('content')

    <!-- Contenedor principal -->
    <div class="mx-auto max-w-7xl px-1 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="mx-auto max-w-7xl">


            <!-- mensaje de exito o error en envio de formulario -->
            @if (session('success'))
                <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">
                    Éxito
                </div>
                <div class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-500 text-white font-bold rounded-t px-4 py-2">
                    Información
                </div>
                <div class="border border-t-0 border-blue-400 rounded-b bg-blue-100 px-4 py-3 text-blue-700">
                    {{ session('info') }}
                </div>
            @endif
            {{-- ... aqui empieza el div de puntuaciones del video ... --}}
            <div class="mt-8 bg-gray-800 p-6 rounded-lg shadow-lg">



                @if (auth()->check())
                    @if ($video->estado == '0')

                        <h3 class="text-xl font-bold mb-1 text-white">¿Deseas Reportar un enlace caido?</h3>

                        <form action="{{ route('reportar.enlace', $video->id) }}" method="POST" class="py-4">
                            @csrf
                            <div class="inline-flex rounded-md shadow-sm bg-gray-500 border border-gray-700">
                                <select name="tipo"
                                    class="appearance-none w-full bg-gray-500 text-white border-none py-2 pl-4 pr-8 rounded-l focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <!-- Opción predeterminada -->
                                    <option value="" disabled selected>Selecciona un idioma</option>
                                    @if ($video->url_video_gratis)
                                        <option value="default">Inglés</option>
                                    @endif
                                    @if ($video->es_url_video_gratis)
                                        <option value="es">Español (España)</option>
                                    @endif
                                    @if ($video->lat_url_video_gratis)
                                        <option value="lat">Español (Latinoamérica)</option>
                                    @endif
                                    @if ($video->sub_url_video_gratis)
                                        <option value="sub">Inglés Subtitulado</option>
                                    @endif
                                </select>
                                <button type="submit"
                                    class="flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-r">
                                    <i class="fas fa-flag mr-2"></i> Reportar
                                </button>
                            </div>
                        </form>
                    @endif
                @endif


                @if (auth()->check())
                    @if (auth()->user()->hasRole('admin'))
                        <a target="blank" href="{{ route('videos.edit', $video->id) }}"
                            class="text-xxs bg-gray-500 px-2 py-1 rounded">Editar</a>
                    @endif
                @endif

                <h3 class="text-xl font-bold mb-4 mt-2 text-white">Calificaciones para este video</h3>

                {{-- Sección de calificaciones --}}
                <div class="mt-8 bg-gray-800 p-6 rounded-lg shadow-lg">
                    {{-- Puntuación promedio y estrellas --}}
                    <div class="flex items-center mb-4">
                        <div class="text-4xl text-yellow-400 mr-2">{{ number_format($puntuacionPromedio, 1) }}</div>
                        <div>
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="text-yellow-400">{{ $puntuacionPromedio >= $i ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                        <div class="text-xs text-gray-400 ml-2">({{ $totalOpiniones }} califaciones)</div>
                    </div>

                    {{-- Barras de calificación por puntuación --}}
                    @foreach ($opinionesPorPuntuacion as $puntuacion => $cantidad)
                        <div class="flex items-center my-1">
                            <div class="text-xs w-6">{{ $puntuacion }}</div>
                            <div class="w-full bg-gray-700 rounded-full h-2 overflow-hidden">
                                <div class="bg-green-500 h-2"
                                    style="width: {{ $totalOpiniones > 0 ? ($cantidad / $totalOpiniones) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ... formulario de puntuacion ... --}}

                @auth
                    <div class="my-4">
                        <h3 class="text-xl font-bold mb-4 text-white">Puntúa este video</h3>
                        <form action="{{ route('videos.puntuar', $video) }}" method="POST" id="rating-form">
                            @csrf
                            <div class="flex space-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label>
                                        <input type="radio" name="puntuacion" value="{{ $i }}" class="hidden"
                                            onchange="updateRatingText({{ $i }})"
                                            {{ $video->puntuacionUsuario(Auth::user()) == $i ? 'checked' : '' }} />
                                        <span
                                            class="text-4xl cursor-pointer rating-star {{ $video->puntuacionUsuario(Auth::user()) >= $i ? 'text-yellow-400' : 'text-gray-400' }} hover:text-yellow-400">&#9733;</span>
                                    </label>
                                @endfor
                            </div>
                            <div id="rating-text" class="text-yellow-500 mt-2"></div>
                            <button type="submit"
                                class="mt-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Enviar
                                Puntuación</button>
                        </form>
                    </div>
                @endauth

            </div>
            {{-- ... aqui termina el div de califaciones del video ... --}}

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
                    @if ($usuarioHaVotado)
                        {{-- Formulario de Comentarios --}}
                        <form action="{{ route('comentarios.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="video_id" value="{{ $video->id }}">
                            <textarea name="contenido" class="w-full rounded border-gray-300 p-2" style="color: black;"
                                placeholder="Añade un comentario..." minlength="100" maxlength="750"></textarea>
                            <button type="submit"
                                class="mt-2 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">Añadir
                                crítica</button>
                        </form>
                    @else
                        <p>Debes puntuar el video antes de poder comentar.</p>
                    @endif
                @else
                    <p><a href="{{ route('login') }}" class="text-blue-600">Inicia sesión</a> para comentar.</p>
                @endauth

                {{-- Mostrar Comentarios --}}
                @foreach ($video->comentarios as $comentario)
                    <div class="bg-gray-700 text-white mt-4 p-4 rounded shadow">
                        <div class="flex items-center mb-2">

                            @php
                                $user = $comentario->user;
                                $diasPremiumRevendedor = $user->diasPremiumRevendedor;
                                $fotoPerfil = null;
                                $esRevendedor = false;

                                if ($diasPremiumRevendedor && $diasPremiumRevendedor->foto_perfil) {
                                    $fotoPerfil = Storage::url($diasPremiumRevendedor->foto_perfil);
                                    $esRevendedor = true;
                                } elseif ($user->foto_perfil) {
                                    $fotoPerfil = Storage::url($user->foto_perfil);
                                }
                            @endphp

                            @if ($fotoPerfil)
                                @if ($esRevendedor && $diasPremiumRevendedor->slug)
                                    <a href="{{ route('perfilRevendedor', $diasPremiumRevendedor->slug) }}">
                                        <img src="{{ $fotoPerfil }}" alt="Profile"
                                            class="rounded-full w-8 h-8 mr-2 border border-red-500">
                                    </a>
                                @else
                                    <img src="{{ $fotoPerfil }}" alt="Profile" class="rounded-full w-8 h-8 mr-2">
                                @endif
                            @else
                                <i class="fas fa-user pr-2"></i>
                            @endif


                            @if ($esRevendedor && $diasPremiumRevendedor->slug)
                                <a href="{{ route('perfilRevendedor', $diasPremiumRevendedor->slug) }}">
                                    <strong class="text-blue-600 hover:text-blue-800">Revendedor:
                                    </strong><strong>{{ $comentario->user->name }}</strong>
                                </a>
                            @else
                                <strong>{{ $comentario->user->name }}</strong>
                            @endif


                            @php
                                $puntuacionUsuario = $comentario->user
                                    ->puntuaciones()
                                    ->where('video_id', $video->id)
                                    ->value('puntuacion');
                            @endphp
                            <span class="ml-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span
                                        class="{{ $puntuacionUsuario >= $i ? 'text-yellow-400' : 'text-gray-400' }}">&#9733;</span>
                                @endfor
                            </span>
                            @if (auth()->id() === $comentario->user_id)
                                <a href="{{ route('comentarios.edit', $comentario) }}"
                                    class="ml-auto text-blue-500">Editar</a>
                            @endif
                        </div>
                        <div class="break-words"> <!-- Asegura que las palabras se rompan correctamente -->
                            <p>{{ $comentario->contenido }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- fin de los contenedores principales -->
    </div>
    </div>

@endsection
@section('footer')
@endsection

@push('scripts')
    <!-- Cambiar el video en el iframe -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.changeVideoButton').forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.getAttribute('data-video-url');
                    changeVideo(url);
                });
            });
        });

        function changeVideo(url) {
            document.querySelectorAll('.videoFrame').forEach(frame => {
                // Cambia solo el protocolo de HTTP a HTTPS si es necesario
                const secureUrl = url.replace(/^http:/, 'https:');
                frame.src = secureUrl;
            });
        }
    </script>
    <!-- Actualizar el texto de la puntuación -->
    <script>
        function updateRatingText(rating) {
            document.getElementById('rating-text').textContent = `Vas a enviar ${rating} estrella(s)`;
            // Actualizar el color de las estrellas
            document.querySelectorAll('.rating-star').forEach((star, index) => {
                star.classList.toggle('text-yellow-400', index < rating);
                star.classList.toggle('text-gray-400', index >= rating);
            });
        }
    </script>
@endpush
