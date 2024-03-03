@extends('layouts.template-configuracion')

@section('title', 'crear capitulo')
<meta name="api-key" content="{{ env('TMDB_API_KEY') }}">

@section('content')
    <div class="container">

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

        <h1>Agregar Capítulo a Lista</h1>
        <form action="{{ route('capitulos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- URL de TMDB --}}
            <div class="mb-3">
                <label for="tmdb_url" class="form-label">URL de TMDB</label>
                <input style="color: black;" type="text" name="tmdb_url" id="tmdb_url" class="form-control">
            </div>

            {{-- Seleccionar foto --}}
            <div>
                <label for="thumbnail">Miniatura:</label>
                <input type="file" name="thumbnail" id="thumbnail" required>
            </div>
            <input type="hidden" name="tipo_id" value="9">

            {{-- Selector de Lista --}}
            <div class="mb-3">
                <label for="lista_id" class="form-label">Seleccionar Lista</label>
                <select style="color: black;" name="lista_id" id="lista_id" class="form-select">
                    <option value="">Seleccione una Lista</option>
                    @foreach ($listas as $lista)
                        <option style="color: black;" value="{{ $lista->id }}">{{ $lista->titulo }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Título del Capítulo --}}
            <div class="mb-3">
                <label for="titulo" class="form-label">Título del Capítulo</label>
                <input style="color: black;" type="text" name="titulo" id="titulo" class="form-control" required>
            </div>

            {{-- URL del Video --}}
            <div class="mb-3">
                <label for="url_video" class="form-label">URL del Video</label>
                <input style="color: black;" type="text" name="url_video" id="url_video" class="form-control" required>
            </div>

            {{-- Estado --}}
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select style="color: black;" name="estado" id="estado" class="form-select">
                    <option style="color: black;" value="1">Activo</option>
                    <option style="color: black;" value="0">Inactivo</option>
                </select>
            </div>

            {{-- Botón de envío --}}
            <button type="submit" class="btn btn-primary">Agregar Capítulo</button>
        </form>
    </div>

    <script>
        document.getElementById('tmdb_url').addEventListener('change', function() {
            const tmdbUrl = this.value;
            // Expresión regular para extraer el ID de la serie, temporada y episodio de la URL
            const match = tmdbUrl.match(/\/tv\/(\d+).*\/season\/(\d+)\/episode\/(\d+)/);
            
            if (match) {
                const serieId = match[1];
                const temporada = match[2];
                const episodio = match[3];
                const apiKey = document.querySelector('meta[name="api-key"]').getAttribute('content');
                const url = `https://api.themoviedb.org/3/tv/${serieId}/season/${temporada}/episode/${episodio}?api_key=${apiKey}&language=es-ES`;
        
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        // Aquí actualizas los campos del formulario con los datos de TMDB
                        document.getElementById('titulo').value = data.name; // El título del episodio
                        // Para la imagen, puedes decidir cómo manejarla. Si solo guardas la URL en tu DB:
                        // document.getElementById('input_para_thumbnail').value = `https://image.tmdb.org/t/p/w500${data.still_path}`;
                        // O si muestras una vista previa de la imagen:
                        // document.getElementById('vista_previa_imagen').src = `https://image.tmdb.org/t/p/w500${data.still_path}`;
                    })
                    .catch(error => console.error('Error al obtener datos de TMDB:', error));
            } else {
                console.error('Formato de URL no reconocido.');
            }
        });
        </script>
        
@endsection
