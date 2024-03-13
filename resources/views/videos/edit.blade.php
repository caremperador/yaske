@extends('layouts.template-configuracion')

@section('title', 'Editar Video')

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
    
        <h3 class="font-semibold border-b border-gray-700 pb-2 text-white">Editar Video</h3>
        <form action="{{ route('videos.update', $video->id) }}" method="post" class="space-y-4" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="photo" class="block text-gray-300 text-sm font-bold mb-2">Thumbnail Actual:</label>
                <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Thumbnail" class="w-32 h-20 object-cover mb-4">
                <label for="thumbnail" class="block text-gray-300 text-sm font-bold mb-2">Actualizar Foto:</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                    class="shadow border rounded py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <input style="color:black;" type="text" name="titulo" id="titulo" placeholder="Titulo original"
                    required
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ $video->titulo }}">
            </div>

            {{-- Continuación de los campos en la vista videos.edit --}}

            {{-- Título en español --}}
            <div>
                <input style="color:black;" type="text" name="es_titulo" id="es_titulo" placeholder="Titulo en español"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ $video->es_titulo }}">
            </div>

            {{-- Título en latinoamérica --}}
            <div>
                <input style="color:black;" type="text" name="lat_titulo" id="lat_titulo"
                    placeholder="Titulo en latinoamérica"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ $video->lat_titulo }}">
            </div>

            {{-- Descripción --}}
            <div>
                <textarea style="color:black;" id="descripcion" name="descripcion" rows="4" placeholder="Descripción"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">{{ $video->descripcion }}</textarea>
            </div>
            <h2> links premium</h2>

            {{-- URL de video en inglés --}}
            <div>
                <input style="color:black;" type="url" id="url_video" name="url_video" placeholder="URL Video (Inglés)"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ $video->url_video }}">
            </div>

            {{-- URL de video en español --}}
            <div>
                <input style="color:black;" type="url" id="es_url_video" name="es_url_video"
                    placeholder="URL Video (Español)"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ $video->es_url_video }}">
            </div>

            {{-- URL de video en latino --}}
            <div>
                <input style="color:black;" type="url" id="lat_url_video" name="lat_url_video"
                    placeholder="URL Video (Latino)"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ $video->lat_url_video }}">
            </div>

            {{-- URL de video subtitulado --}}
            <div>
                <input style="color:black;" type="url" id="sub_url_video" name="sub_url_video"
                    placeholder="URL Video (Subtitulado)"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ $video->sub_url_video }}">
            </div>

            {{-- links gratis --}}
            <h2> links gratis</h2>


               {{-- URL de video en inglés gratis --}}
               <div>
                <input style="color:black;" type="url" id="url_video_gratis" name="url_video_gratis" placeholder="URL Video (Inglés) gratis"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ $video->url_video_gratis }}">
            </div>

            {{-- URL de video en español gratis --}}
            <div>
                <input style="color:black;" type="url" id="es_url_video_gratis" name="es_url_video_gratis"
                    placeholder="URL Video (Español) gratis"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ $video->es_url_video_gratis }}">
            </div>

            {{-- URL de video en latino gratis --}}
            <div>
                <input style="color:black;" type="url" id="lat_url_video_gratis" name="lat_url_video_gratis"
                    placeholder="URL Video (Latino) gratis"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ $video->lat_url_video_gratis }}">
            </div>

            {{-- URL de video subtitulado gratis --}}
            <div>
                <input style="color:black;" type="url" id="sub_url_video_gratis" name="sub_url_video_gratis"
                    placeholder="URL Video (Subtitulado) gratis"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ $video->sub_url_video_gratis }}">
            </div>

            {{-- Lista --}}
            <div>
                {{-- Asumo que tienes una colección de listas disponibles como $listas --}}
                <select style="color:black;" name="lista_id" id="lista_id"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="">Seleccione una lista</option>
                    @foreach ($listas as $lista)
                        <option value="{{ $lista->id }}" {{ $video->lista_id == $lista->id ? 'selected' : '' }}>
                            {{ $lista->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tipo de video --}}
            <div>
                <select style="color:black;" name="tipo_id" id="tipo_id" 
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ $video->tipo_id == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Categorías "categoria_id[]--}}
            <div>
                <select id="categoria_id" name="categoria_id[]" multiple class="block w-full rounded-md bg-white border border-gray-600 text-white leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" style="color:black;">
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ in_array($categoria->id, $video->categorias->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $categoria->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        

            {{-- Estado del video --}}
            <div>
                <select style="color:black;" name="estado" id="estado"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="0" {{ $video->estado == '0' ? 'selected' : '' }}>Gratis</option>
                    <option value="1" {{ $video->estado == '1' ? 'selected' : '' }}>Premium</option>
                </select>
            </div>
            {{-- Checkbox para calidad "cam" --}}
            <div>
                <label for="es_calidad_cam" class="block text-sm font-medium text-gray-300">Calidad CAM</label>
                <input type="checkbox" id="es_calidad_cam" name="es_calidad_cam" value="1"
                    {{ $video->es_calidad_cam ? 'checked' : '' }} class="mt-1">
            </div>

            <div class="flex justify-center mt-6">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Actualizar Video
                </button>
            </div>
        </form>
    </div>
@endsection
