@inject('diasPremiumController', 'App\Http\Controllers\DiasPremiumController')
@php
    use Carbon\Carbon;
@endphp
@extends('layouts.template')
@section('title', 'Yaske - ' . $video->titulo)
@section('js_cabecera')
    <script>
        function changeVideo(url) {
            document.getElementById('videoFrame').src = url;
        }
    </script>
@endsection
@section('content')
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="mx-auto max-w-6xl">
            <!-- ... (contenedor video) ... -->
            <div class="mt-8p-6 rounded-lg shadow-lg">


                <div class="aspect-w-16 rounded-lg aspect-h-9 bg-gray-900">
                    <div class="relative" style="padding-top: 56.25%;">
                        @php
                            $usuarioPremium = Auth::check() && Auth::user()->hasRole('premium');
                            $diasPremiumUsuario = $usuarioPremium
                                ? Auth::user()
                                    ->diasPremiumUsuario()
                                    ->first()
                                : null;
                            $videoUrl = $video->sub_url_video ?? ($video->es_url_video ?? ($video->lat_url_video ?? $video->url_video));
                            $fechaFinPasada = $diasPremiumUsuario && $diasPremiumUsuario->fin_fecha_dias_usuario_premium ? Carbon::parse($diasPremiumUsuario->fin_fecha_dias_usuario_premium)->isPast() : true;
                        @endphp

                        @if ($video->estado == 1)
                            @if ($usuarioPremium && ($diasPremiumUsuario->inicio_fecha_dias_usuario_premium == null || $fechaFinPasada))
                                <!-- Mostrar Botón para activar día premium -->
                                {{--   <div class="bg-black rounded-lg absolute top-0 left-0 w-full h-full flex justify-center items-center"
                                style="background-image: url('/images/complementos/play.png'); background-repeat: no-repeat; background-position: center; background-size: 125px 125px;">
                                <div class="z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                                    <form action="{{ route('activar-dia-premium', ['video_id' => $video->id]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                            <i class="fas fa-gem mr-1" aria-hidden="true"></i>
                                            Gastar un día premium para ver este video
                                        </button>
                                    </form>
                                </div>
                            </div> --}}
                                <div
                                    class="bg-black rounded-lg absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center">
                                    <!-- Container for the play image -->
                                    <div class="mb-4">
                                        <!-- Add margin bottom to create space between the image and the button -->
                                        <form action="{{ route('activar-dia-premium', ['video_id' => $video->id]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit">
                                                <img src="/images/complementos/play.png" class="hover:opacity-70"
                                                    width="120" height="120" alt="Play" />
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
                                    <iframe id="videoFrame" class="absolute top-0 left-0 w-full h-full"
                                        src="{{ $videoUrl }}" title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                @else
                                    {{-- Mostrar alternativa si no hay enlaces de video --}}
                                    <p>No hay video disponible</p>
                                @endif
                            @else
                                <!-- Mostrar Imagen de Marcador de Posición para usuarios no premium -->
                                {{-- <img src="https://via.placeholder.com/300x250" alt="Contenido Premium"
                            class="absolute top-0 left-0 w-full h-full"> --}}
                                {{-- <div
                                class="bg-black rounded-lg absolute top-0 left-0 w-full h-full flex justify-center items-center">
                                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                                    <a href="{{ route('seleccionarRevendedor') }}"
                                        class="bg-red-500 text-white font-bold py-2 px-4 rounded">
                                        <i class="fas fa-gem mr-1" aria-hidden="true"></i>
                                        este video es premium!
                                    </a>

                                </div>
                            </div> --}}

                                <div
                                    class="bg-black rounded-lg absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center">
                                    <!-- Container for the play image -->
                                    <div class="mb-4">
                                        <!-- Add margin bottom to create space between the image and the button -->

                                        <a href="{{ route('seleccionarRevendedor') }}">
                                            <img src="/images/complementos/play.png" class="opacity-70" width="120"
                                                height="120" alt="Play" />
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
                                <iframe id="videoFrame" class="absolute top-0 left-0 w-full h-full"
                                    src="{{ $videoUrl }}" title="YouTube video player" frameborder="0"
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
                            <button onclick="changeVideo('{{ $video->sub_url_video }}')"
                                class="mx-2 mb-1 bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                                <i class="fa fa-volume-up pr-1"></i>Inglés Subtitulado
                            </button>
                        @endif
                        @if ($video->es_url_video)
                            <button onclick="changeVideo('{{ $video->es_url_video }}')"
                                class="mx-2 mb-1  bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                                <i class="fa fa-volume-up pr-1"></i>Español (España)
                            </button>
                        @endif
                        @if ($video->lat_url_video)
                            <button onclick="changeVideo('{{ $video->lat_url_video }}')"
                                class="mx-2 mb-1  bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                                <i class="fa fa-volume-up pr-1"></i>Español (Latinoamérica)
                            </button>
                        @endif
                        @if ($video->url_video)
                            <button onclick="changeVideo('{{ $video->url_video }}')"
                                class="mx-2 mb-1  bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                                <i class="fa fa-volume-up pr-1"></i>Inglés
                            </button>
                        @endif


                    </div>

                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
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

            {{-- ... aqui empieza el div de puntuaciones del video ... --}}
            <div class="mt-8 bg-gray-800 p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-bold mb-4 text-white">Calificaciones para este video</h3>

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
                                class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Enviar
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
                                placeholder="Añade un comentario..." minlength="200" maxlength="750"></textarea>
                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Añadir
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
