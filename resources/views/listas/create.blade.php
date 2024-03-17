@extends('layouts.template-configuracion')

@section('title', 'Crear listas')

@section('content')


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


        <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
            <h3 class="font-semibold border-b border-gray-700 pb-2 text-white"> Crear Nueva Lista de Videos</h3>


            <p class="mt-6 text-gray-300 leading-relaxed">
                Completa los campos a continuación para agregar una nueva lista a tu plataforma.
            </p>

            <div class="mt-8">
                <form action="{{ route('listas.store') }}" method="post" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    <!-- capo de busqueda de tmdb -->
                    <div>
                        <label for="tmdbSearch" class="block text-sm font-medium text-gray-300">Buscar en TMDB:</label>
                        <input type="text" id="tmdbSearch" name="tmdbSearch" placeholder="Ingresa ID de TMDB de la serie"
                            style="color:black;"
                            class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    </div>
                    <div id="thumbnailPreviewContainer" style="display: none;">
                        <label class="block text-sm font-medium text-gray-300">Vista previa del Thumbnail:</label>
                        <img id="thumbnailPreview" src="" alt="Vista previa del thumbnail"
                            class="w-32 h-48 object-cover">
                    </div>

                    <input type="hidden" id="thumbnailUrl" name="thumbnailUrl">
                    <!-- Corregido para que coincida con la validación y manejo en el controlador -->
                    <input type="hidden" id="tmdb_id" name="tmdb_id">


                    <div>

                        <label for="photo" class="block text-gray-300 text-sm font-bold mb-2">Selecciona una
                            Foto:</label>
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                            class="shadow border rounded py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <input style="color:black;" type="text" name="titulo" id="titulo"
                            placeholder="Título de la lista" required
                            class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    </div>
                    <div>
                        <input style="color:black;" type="text" name="es_titulo" id="es_titulo"
                            placeholder="Título en español" required
                            class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    </div>
                    <div>
                        <input style="color:black;" type="text" name="lat_titulo" id="lat_titulo"
                            placeholder="Título en latino" required
                            class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    </div>
                    <div>
                        <textarea style="color:black;" id="descripcion" name="descripcion" rows="4" placeholder="Descripción de la lista"
                            class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"></textarea>
                    </div>



                    <div class="flex flex-wrap gap-2 mt-4">
                        <label for="categoria_id" class="block text-sm font-medium text-gray-300">Categorías</label>
                        @foreach ($categorias as $categoria)
                            <div class="category-checkbox">
                                <input type="checkbox" id="cat-{{ $categoria->id }}" name="categoria_id[]"
                                    value="{{ $categoria->id }}" class="hidden peer"
                                    @if (is_array(old('categoria_id')) && in_array($categoria->id, old('categoria_id', []))) checked @endif />
                                <label for="cat-{{ $categoria->id }}"
                                    class="px-3 py-1 bg-gray-600 text-white text-sm font-medium rounded-full cursor-pointer hover:bg-gray-700 peer-checked:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                    {{ $categoria->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    


                    <div>
                        <select style="color:black;" name="tipo_id" id="tipo_id"
                            class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            <option value="">Seleccione un tipo</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-center">
                        <input type="submit" value="Crear Lista"
                            class="px-6 py-2 text-white bg-indigo-600 rounded-md shadow hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200">
                    </div>
                </form>
            </div>

            @push('scripts')
                <script>
                    document.getElementById('tmdbSearch').addEventListener('input', async function() {
                        const tmdbId = this.value;
                        if (tmdbId.length === 0) return; // Evita búsquedas vacías

                        // Actualiza el campo oculto con el ID de TMDB
                        document.getElementById('tmdb_id').value = tmdbId;

                        try {
                            // Obtener detalles de la serie en inglés (título original)
                            const responseEn = await fetch(`/buscar-serie-tmdb/${tmdbId}?language=en`);
                            const serieEn = await responseEn.json();
                            document.getElementById('titulo').value = serieEn.name || '';

                            // Vista previa del thumbnail y actualización del campo oculto para la imagen
                            if (serieEn.poster_path) {
                                const imageUrl = `https://image.tmdb.org/t/p/w533_and_h300_bestv2${serieEn.backdrop_path}`;
                                document.getElementById('thumbnailPreview').src = imageUrl;
                                document.getElementById('thumbnailPreviewContainer').style.display = 'block';
                                document.getElementById('thumbnailUrl').value = imageUrl;
                            }

                            // Obtener detalles en español de España
                            const responseEs = await fetch(`/buscar-serie-tmdb/${tmdbId}?language=es-ES`);
                            if (responseEs.ok) {
                                const serieEs = await responseEs.json();
                                document.getElementById('es_titulo').value = serieEs.name || '';
                                document.getElementById('descripcion').value = serieEs.overview || '';
                            }

                            // Detalles en español de Latinoamérica
                            const responseLat = await fetch(`/buscar-serie-tmdb/${tmdbId}?language=es-MX`);
                            if (responseLat.ok) {
                                const serieLat = await responseLat.json();
                                document.getElementById('lat_titulo').value = serieLat.name || '';
                            }
                        } catch (error) {
                            console.error('Error al buscar la serie:', error);
                        }
                    });
                </script>
                <script>
                 document.addEventListener('DOMContentLoaded', function () {
    // Script para manejar el estado activo de las categorías
    document.querySelectorAll('.category-checkbox input').forEach(checkbox => {
        const label = checkbox.nextElementSibling;
        checkbox.checked ? label.classList.add('bg-blue-700') : label.classList.remove('bg-blue-700');
        
        label.addEventListener('click', () => {
            setTimeout(() => {
                checkbox.checked ? label.classList.add('bg-blue-700') : label.classList.remove('bg-blue-700');
            }, 10);
        });
    });
});

                </script>
            @endpush


        @endsection
