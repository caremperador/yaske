@extends('layouts.template-configuracion')

@section('title', 'crear capitulo')
<meta name="api-key" content="f412d3e39460dae1a70eb007668c4e3b">

@section('content')
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-white max-w-4xl mx-auto my-10">
        @if ($errors->any())
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Errores
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700 mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-2xl font-bold mb-8 text-center">Agregar Capítulo a Lista</h1>
        <form action="{{ route('capitulos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="tmdb_url" class="block mb-2 text-sm font-medium">URL de TMDB</label>
                <input type="text" name="tmdb_url" id="tmdb_url"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-6">
                <label for="thumbnail_preview" class="block mb-2 text-sm font-medium">Previsualización de la
                    Miniatura:</label>
                <img id="thumbnail_preview" src="" alt="Previsualización de la miniatura"
                    class="hidden w-full max-w-xs mx-auto rounded-lg">
            </div>
            {{-- tipo id series --}}
            <input type="hidden" name="thumbnail_url" id="thumbnail_url">
            <input type="hidden" name="tipo_id" value="10">

            <div class="mb-6">
                <label for="thumbnail" class="block mb-2 text-sm font-medium">Miniatura (opcional):</label>
                <input type="file" name="thumbnail" id="thumbnail"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-6">
                <label for="lista_id" class="block mb-2 text-sm font-medium">Seleccionar Lista</label>
                <select name="lista_id" id="lista_id"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Seleccione una Lista</option>
                    @foreach ($listas as $lista)
                        <option value="{{ $lista->id }}" data-tmdb-id="{{ $lista->tmdb_id }}">{{ $lista->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="titulo" class="block mb-2 text-sm font-medium">Título del Capítulo</label>
                <input type="text" name="titulo" id="titulo" required
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-6">
                <label for="descripcion" class="block mb-2 text-sm font-medium">Descripción del Capítulo</label>
                <textarea name="descripcion" id="descripcion" required
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    rows="4"></textarea>
            </div>
            <h2> links premium</h2>
            <div class="mb-6">
                <label for="url_video" class="block mb-2 text-sm font-medium">URL del Video (Inglés)</label>
                <input type="text" name="url_video" id="url_video"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-6">
                <label for="es_url_video" class="block mb-2 text-sm font-medium">URL del Video (Español)</label>
                <input type="text" name="es_url_video" id="es_url_video"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-6">
                <label for="lat_url_video" class="block mb-2 text-sm font-medium">URL del Video (Latino)</label>
                <input type="text" name="lat_url_video" id="lat_url_video"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-6">
                <label for="sub_url_video" class="block mb-2 text-sm font-medium">URL del Video (Subtítulos)</label>
                <input type="text" name="sub_url_video" id="sub_url_video"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
            {{-- links gratis --}}
            <h2> links gratis</h2>
            <div class="mb-6">
                <label for="url_video_gratis" class="block mb-2 text-sm font-medium">URL del Video (Inglés) gratis</label>
                <input type="text" name="url_video_gratis" id="url_vide_gratiso"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-6">
                <label for="es_url_video_gratis" class="block mb-2 text-sm font-medium">URL del Video (Español)
                    gratis</label>
                <input type="text" name="es_url_video_gratis" id="es_url_video_gratis"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-6">
                <label for="lat_url_video_gratis" class="block mb-2 text-sm font-medium">URL del Video (Latino)
                    gratis</label>
                <input type="text" name="lat_url_video" id="lat_url_video_gratis"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-6">
                <label for="sub_url_video_gratis" class="block mb-2 text-sm font-medium">URL del Video (Subtítulos)
                    gratis</label>
                <input type="text" name="sub_url_video_gratis" id="sub_url_video_gratis"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>



            <div class="mb-6">
                <label for="estado" class="block mb-2 text-sm font-medium">Estado</label>
                <select name="estado" id="estado"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="1">Premium</option>
                    <option value="0">Gratis</option>
                </select>
            </div>

            <button type="submit"
                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Agregar
                Capítulo</button>
        </form>
    </div>


    <script>
        document.getElementById('tmdb_url').addEventListener('change', async function() {
            const tmdbUrl = this.value;
            const serieMatch = tmdbUrl.match(/\/tv\/(\d+)/);

            if (serieMatch) {
                const serieId = serieMatch[1];
                const apiKey = document.querySelector('meta[name="api-key"]').getAttribute('content');

                try {
                    // Intenta seleccionar la lista basada en el ID de TMDB
                    const listas = document.querySelectorAll('#lista_id option');
                    let listaFound = false;
                    listas.forEach((option) => {
                        if (option.dataset.tmdbId === serieId) {
                            option.selected = true;
                            listaFound = true;
                        }
                    });

                    if (!listaFound) {
                        console.log("La lista correspondiente no fue encontrada.");
                    }

                    // Continúa con la lógica para manejar episodios si es necesario
                    // Por ejemplo, si la URL incluye detalles del episodio, obtén esos detalles
                    const episodioMatch = tmdbUrl.match(/\/season\/(\d+)\/episode\/(\d+)/);
                    if (episodioMatch) {
                        const temporada = episodioMatch[1];
                        const episodio = episodioMatch[2];

                        // Obtener detalles de la serie para el título y el año
                        const serieUrl =
                            `https://api.themoviedb.org/3/tv/${serieId}?api_key=${apiKey}&language=es-ES`;
                        const serieResponse = await fetch(serieUrl);
                        const serieData = await serieResponse.json();
                        const year = serieData.first_air_date ? serieData.first_air_date.substring(0, 4) : '';

                        // Obtener detalles del episodio para la descripción
                        const episodioUrl =
                            `https://api.themoviedb.org/3/tv/${serieId}/season/${temporada}/episode/${episodio}?api_key=${apiKey}&language=es-ES`;
                        const episodioResponse = await fetch(episodioUrl);
                        const episodioData = await episodioResponse.json();

                        // Formatear y asignar el título
                        document.getElementById('titulo').value =
                            `${serieData.name} (${year}) capítulo ${episodio} temporada ${temporada}`;

                        // Asignar la descripción
                        document.getElementById('descripcion').value = episodioData.overview;

                        // Previsualizar la miniatura
                        const thumbnailUrl = episodioData.still_path ?
                            `https://image.tmdb.org/t/p/w500${episodioData.still_path}` : '';
                        if (thumbnailUrl) {
                            document.getElementById('thumbnail_url').value = thumbnailUrl;
                            const preview = document.getElementById('thumbnail_preview');
                            preview.src = thumbnailUrl;
                            preview.style.display = 'block';
                        }
                    }
                } catch (error) {
                    console.error('Error al obtener datos de TMDB:', error);
                }
            } else {
                console.error('Formato de URL no reconocido.');
            }
        });
    </script>


@endsection
