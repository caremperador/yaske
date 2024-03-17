@extends('layouts.template-configuracion')

@section('title', 'Crear video nuevo')

@section('content')


    <!-- mostrar errores en el formulario -->
    <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
        @if ($errors->any())
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Errores
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <h3 class="font-semibold border-b border-gray-700 pb-2 text-white">Crear Video</h3>
        <form action="{{ route('videos.store') }}" method="post" class="space-y-4" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="tmdbSearch" class="block text-sm font-medium text-gray-300">Buscar en TMDB:</label>
                <input type="text" style="color:black;" id="tmdbSearch" name="tmdbSearch"
                    placeholder="Escribe para buscar..."
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <!-- Vista previa del Thumbnail, inicialmente oculta -->
            <div id="thumbnailPreviewContainer" style="display: none;">
                <label class="block text-sm font-medium text-gray-300">Vista previa del Thumbnail:</label>
                <img id="thumbnailPreview" src="" alt="Vista previa del thumbnail"
                    class="w-full max-w-xs mx-auto rounded-lg object-cover">
            </div>


            <!-- Campo oculto para la URL del thumbnail (opcional) -->
            <input type="hidden" id="thumbnailUrl" name="thumbnailUrl">

            <!-- Corregido para que coincida con la validación y manejo en el controlador -->
            <input type="hidden" id="tmdb_id" name="tmdb_id">



            <div>

                <label for="photo" class="block text-gray-300 text-sm font-bold mb-2">Selecciona una Foto:</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                    class="shadow border rounded py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <input style="color:black;" type="text" name="titulo" id="titulo" placeholder="Titulo original"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('titulo') }}">
                @error('titulo')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input style="color:black;" type="text" name="es_titulo" id="es_titulo" placeholder="Titulo en español"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('es_titulo') }}">
                @error('es_titulo')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input style="color:black;" type="text" name="lat_titulo" id="lat_titulo"
                    placeholder="Titutlo en latino America"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('lat_titulo') }}">
                @error('lat_titulo')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <textarea style="color:black;" id="descripcion" name="descripcion" rows="4" placeholder="Description"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- aqui empiezan los links de url de idiomas --}}
            <h2> links premium</h2>
            <div>
                <input style="color:black;" type="url" id="url_video" name="url_video"
                    placeholder="URL Video (Inglés) premium"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('url_video') }}">
            </div>
            <div>
                <input style="color:black;" type="url" id="es_url_video" name="es_url_video"
                    placeholder="URL Video (Español) premium"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('es_url_video') }}">
            </div>
            <div>
                <input style="color:black;" type="url" id="lat_url_video" name="lat_url_video"
                    placeholder="URL Video (Latino) premium"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('lat_url_video') }}">
            </div>
            <div>
                <input style="color:black;" type="url" id="sub_url_video" name="sub_url_video"
                    placeholder="URL Video (Subtitulado) premium"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('sub_url_video') }}">
            </div>
            {{-- aqui terminan los links de url de idiomas --}}

            {{-- aqui empiezan los links de url de idiomas gratis --}}
            <h2> links gratis</h2>
            <div>
                <input style="color:black;" type="url" id="url_video_gratis" name="url_video_gratis"
                    placeholder="URL Video (Inglés) gratis"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('url_video_gratis') }}">
            </div>
            <div>
                <input style="color:black;" type="url" id="es_url_video_gratis" name="es_url_video_gratis"
                    placeholder="URL Video (Español) gratis"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('es_url_video_gratis') }}">
            </div>
            <div>
                <input style="color:black;" type="url" id="lat_url_video_gratis" name="lat_url_video_gratis"
                    placeholder="URL Video (Latino) gratis"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('lat_url_video_gratis') }}">
            </div>
            <div>
                <input style="color:black;" type="url" id="sub_url_video_gratis" name="sub_url_video_gratis"
                    placeholder="URL Video (Subtitulado) gratis"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('sub_url_video_gratis') }}">
            </div>
            {{-- aqui terminan los links de url de idiomas --}}
            <h2> lista a la que pertenece</h2>
            <div>
                <select style="color:black;" name="lista_id" id="lista_id"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="">Seleccione una lista</option>
                    @foreach ($listas as $lista)
                        <option value="{{ $lista->id }}" {{ old('lista_id') == $lista->id ? 'selected' : '' }}>
                            {{ $lista->titulo }}
                        </option>
                    @endforeach
                </select>
                @error('lista_id')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>



            <div>
                <label for="tipo_id" class="block text-sm font-medium text-gray-300">Tipo de
                    Video</label>
                <select style="color:black;" name="tipo_id" id="tipo_id" required
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="" disabled {{ old('tipo_id') ? '' : 'selected' }}>Seleccione un tipo</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ old('tipo_id') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->name }}</option>
                    @endforeach
                </select>
                @error('tipo_id')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>




            <div class="flex flex-wrap gap-2 mt-4">
                @foreach ($categorias->sortBy('name') as $categoria)
                    <div class="category-checkbox">
                        <input type="checkbox" id="cat-{{ $categoria->id }}" name="categoria_id[]"
                            value="{{ $categoria->id }}" class="hidden peer"
                            @if (is_array(old('categoria_id')) && in_array($categoria->id, old('categoria_id'))) checked @endif />
                        <label for="cat-{{ $categoria->id }}"
                            class="px-3 py-1 bg-gray-600 text-white text-sm font-medium rounded-full cursor-pointer hover:bg-gray-700 peer-checked:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            {{ $categoria->name }}
                        </label>
                    </div>
                @endforeach
                @error('categoria_id')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-300">Estado del
                    Video</label>
                <select style="color:black;" name="estado" id="estado"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Gratis</option>
                    <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Premium</option>
                </select>
                @error('estado')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Checkbox para calidad "cam" en la vista de creación --}}
            <div>
                <label for="es_calidad_cam" class="block text-sm font-medium text-gray-300">Calidad CAM</label>
                <input type="checkbox" id="es_calidad_cam" name="es_calidad_cam" value="1" class="mt-1">
            </div>



            <div class="flex justify-center mt-6">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Crear Video
                </button>
            </div>
        </form>


    </div>
    @push('scripts')
        <script>
            document.getElementById('tmdbSearch').addEventListener('input', async function() {
                const tmdbId = this.value;
                if (tmdbId.length === 0) return; // Evita búsquedas vacías

                try {
                    // Realiza la solicitud para obtener detalles de la película en inglés
                    const responseEn = await fetch(`/buscar-pelicula-tmdb/${tmdbId}?language=en`);
                    const movieEn = await responseEn.json();
                    const yearEn = movieEn.release_date ? ` (${movieEn.release_date.split('-')[0]})` : '';
                    document.getElementById('titulo').value = `${movieEn.title}${yearEn}` || '';
                    // Actualiza el campo oculto con el ID de TMDB de la película
                    document.getElementById('tmdb_id').value = tmdbId; // Asegúrate de que este es el ID de TMDB

                    // Realiza la solicitud para obtener detalles de la película en español de España
                    const responseEs = await fetch(`/buscar-pelicula-tmdb/${tmdbId}?language=es-ES`);
                    const movieEs = await responseEs.json();
                    const yearEs = movieEs.release_date ? ` (${movieEs.release_date.split('-')[0]})` : '';
                    document.getElementById('es_titulo').value = `${movieEs.title}${yearEs}` || '';
                    document.getElementById('descripcion').value = movieEs.overview || '';

                    // Realiza la solicitud para obtener detalles de la película en español de Latinoamérica
                    const responseLat = await fetch(`/buscar-pelicula-tmdb/${tmdbId}?language=es-MX`);
                    const movieLat = await responseLat.json();
                    const yearLat = movieLat.release_date ? ` (${movieLat.release_date.split('-')[0]})` : '';
                    document.getElementById('lat_titulo').value = `${movieLat.title}${yearLat}` || '';

                    // Actualizar la vista previa del thumbnail utilizando el póster de la película en español (movieEs)
                    if (movieEn.poster_path && movieEn.backdrop_path) {
                        const imageUrl = `https://image.tmdb.org/t/p/w780${movieEn.backdrop_path}`;
                        document.getElementById('thumbnailPreview').src = imageUrl;
                        document.getElementById('thumbnailPreviewContainer').style.display =
                            'block'; // Muestra el contenedor
                        document.getElementById('thumbnailUrl').value = imageUrl;
                    } else {
                        console.log("La película no tiene una imagen de fondo disponible.");
                        // Puedes optar por establecer una imagen por defecto o manejar la ausencia de la imagen de alguna otra manera
                        document.getElementById('thumbnailPreview').src =
                            '/path/to/default/image.jpg'; // Ejemplo de ruta a una imagen por defecto
                        document.getElementById('thumbnailUrl').value = '/path/to/default/image.jpg';
                        // Dependiendo de tu diseño, quizás quieras ocultar el contenedor de vista previa o mostrar un mensaje
                        // document.getElementById('thumbnailPreviewContainer').style.display = 'none';
                    }


                } catch (error) {
                    console.error('Error al buscar la película:', error);
                }
            });
        </script>
   
    @endpush

@endsection
