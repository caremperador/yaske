@extends('layouts.template-configuracion')

@section('title', 'Crear video nuevo')

@section('content')


<div class="bg-gray-800 p-4 rounded-lg shadow-lg">
    <h3 class="font-semibold border-b border-gray-700 pb-2 text-white">Crear Video</h3>
    <form action="{{ route('videos.store') }}" method="post" class="space-y-4">
        @csrf
            <div>
                <input style="color:black;" type="text" name="titulo" id="titulo" placeholder="Title" required
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('titulo') }}">
                @error('titulo')
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
            <div>
                <input style="color:black;" type="url" id="url_video" name="url_video" placeholder="URL Video (Inglés)"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('url_video') }}">
            </div>
            <div>
                <input style="color:black;" type="url" id="es_url_video" name="es_url_video" placeholder="URL Video (Español)"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('es_url_video') }}">
            </div>
            <div>
                <input style="color:black;" type="url" id="lat_url_video" name="lat_url_video" placeholder="URL Video (Latino)"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('lat_url_video') }}">
            </div>
            <div>
                <input style="color:black;" type="url" id="sub_url_video" name="sub_url_video" placeholder="URL Video (Subtitulado)"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('sub_url_video') }}">
            </div>
            {{-- aqui terminan los links de url de idiomas --}}
            <div>
                <input type="url" id="thumbnail" name="thumbnail" placeholder="https://via.placeholder.com/210x118"
                    required
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    value="{{ old('thumbnail') }}">
            </div>
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

            <div>
                <label for="categoria_id" class="block text-sm font-medium text-gray-300">Categorías</label>
                <select style="color:black;" name="categoria_id[]" id="categoria_id" multiple required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="" disabled {{ old('categoria_id') ? '' : 'selected' }}>
                        Seleccione categorías</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ in_array($categoria->id, old('categoria_id', [])) ? 'selected' : '' }}>
                            {{ $categoria->name }}</option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-300">Mantén presionada la tecla 'Ctrl' (Windows/Linux)
                    o 'Command' (Mac) para seleccionar múltiples opciones.</p>
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-300">Estado del
                    Video</label>
                <select style="color:black;" name="estado" id="estado"
                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Premium</option>
                    <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Gratis</option>
                </select>
                @error('estado')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center mt-6">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Crear Video
                </button>
            </div>
        </form>


    </div>

@endsection
