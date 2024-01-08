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
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Description"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"></textarea>
                            </div>
                            <div>
                                <input type="url" id="url_video" name="url_video"
                                    placeholder="https://www.youtube.com/embed/dQw4w9WgXcQ" required
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <input type="url" id="thumbnail" name="thumbnail"
                                    placeholder="https://via.placeholder.com/210x118" required
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <select name="lista_id" id="lista_id"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                    <option value="">Seleccione una lista</option>
                                    @foreach ($listas as $lista)
                                        <option value="{{ $lista->id }}">{{ $lista->titulo }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div>
                                <select name="tipo_id" id="tipo_id"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                    <option value="">Seleccione un tipo</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div>
                                <label for="categoria_id"
                                    class="block text-sm font-medium text-gray-700">Categorías</label>
                                <select name="categoria_id[]" id="categoria_id" multiple
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Seleccione categorías</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-2 text-sm text-gray-500">Mantén presionada la tecla 'Ctrl' (Windows/Linux)
                                    o 'Command' (Mac) para seleccionar múltiples opciones.</p>
                            </div>

                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-700">Estado del
                                    Video</label>
                                <select name="estado" id="estado"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                    <option value="0" selected>0 - No Premium</option>
                                    <option value="1">1 - Premium</option>
                                </select>
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
