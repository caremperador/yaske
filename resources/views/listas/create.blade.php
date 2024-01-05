<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Lista de Videos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="max-w-2xl mx-auto">
                    <h1 class="text-2xl font-medium text-gray-900">
                        Crear Nueva Lista de Videos
                    </h1>
                    <p class="mt-6 text-gray-500 leading-relaxed">
                        Completa los campos a continuación para agregar una nueva lista a tu plataforma.
                    </p>

                    <div class="mt-8">
                        <form action="{{ route('listas.store') }}" method="post" class="space-y-6">
                            @csrf
                            <div>
                                <input type="text" name="titulo" id="titulo" placeholder="Título de la lista" required
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Descripción de la lista"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"></textarea>
                            </div>
                            <div>
                                <input type="url" id="thumbnail" name="thumbnail"
                                    placeholder="URL del thumbnail de la lista"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <select name="categoria_id" id="categoria_id"
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                    <option value="">Seleccione una categoría</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
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
                            <div class="flex justify-center">
                                <input type="submit" value="Crear Lista"
                                    class="px-6 py-2 text-white bg-indigo-600 rounded-md shadow hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
