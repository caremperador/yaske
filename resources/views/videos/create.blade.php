<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Video') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="max-w-2xl mx-auto">

                    <!-- Mostrar mensajes de error de validación -->
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            <p><strong>Por favor, corrige los siguientes errores:</strong></p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h1 class="text-2xl font-medium text-gray-900">
                        Bienvenido a la creacion de videos
                    </h1>
                    <p class="mt-6 text-gray-500 leading-relaxed">
                        Aquí puedes subir y compartir tus videos con el mundo. Completa los campos a continuación para
                        agregar un nuevo video a tu plataforma.
                    </p>

                    <div class="mt-8">
                        <form action="{{ route('videos.store') }}" method="post" class="space-y-6">
                            @csrf
                            <div>
                                <input type="text" name="titulo" id="titulo" placeholder="Title" required
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                    value="{{ old('titulo') }}">
                                @error('titulo')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Description"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- aqui empiezan los links de url de idiomas --}}
                            <div>
                                <input type="url" id="url_video" name="url_video" placeholder="URL Video (Inglés)"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" value="{{ old('url_video') }}">
                            </div>
                            <div>
                                <input type="url" id="es_url_video" name="es_url_video"
                                    placeholder="URL Video (Español)"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" value="{{ old('es_url_video') }}">
                            </div>
                            <div>
                                <input type="url" id="lat_url_video" name="lat_url_video"
                                    placeholder="URL Video (Latino)"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" value="{{ old('lat_url_video') }}">
                            </div>
                            <div>
                                <input type="url" id="sub_url_video" name="sub_url_video"
                                    placeholder="URL Video (Subtitulado)"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" value="{{ old('sub_url_video') }}">
                            </div>
                            {{-- aqui terminan los links de url de idiomas --}}
                            <div>
                                <input type="url" id="thumbnail" name="thumbnail"
                                    placeholder="https://via.placeholder.com/210x118" required
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" value="{{ old('thumbnail') }}">
                            </div>
                            <div>
                                <select name="lista_id" id="lista_id"
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
                                <label for="tipo_id" class="block text-sm font-medium text-gray-700">Tipo de
                                    Video</label>
                                <select name="tipo_id" id="tipo_id" required
                                        class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                    <option value="" disabled {{ old('tipo_id') ? '' : 'selected' }}>Seleccione un tipo</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id }}" {{ old('tipo_id') == $tipo->id ? 'selected' : '' }}>{{ $tipo->name }}</option>
                                    @endforeach
                                </select>
                                @error('tipo_id')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="categoria_id"
                                       class="block text-sm font-medium text-gray-700">Categorías</label>
                                <select name="categoria_id[]" id="categoria_id" multiple required
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
                                <p class="mt-2 text-sm text-gray-500">Mantén presionada la tecla 'Ctrl' (Windows/Linux)
                                    o 'Command' (Mac) para seleccionar múltiples opciones.</p>
                            </div>

                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-700">Estado del
                                    Video</label>
                                <select name="estado" id="estado"
                                        class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                    <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Premium</option>
                                    <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Gratis</option>
                                </select>
                                @error('estado')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-center">
                                <input type="submit" value="Crear Video"
                                       class="px-6 py-2 text-white bg-indigo-600 rounded-md shadow hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200">
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
