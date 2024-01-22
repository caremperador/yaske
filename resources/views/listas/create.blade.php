@extends('layouts.template-configuracion')

@section('title', 'Crear listas')

@section('content')


    <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
        <h3 class="font-semibold border-b border-gray-700 pb-2 text-white"> Crear Nueva Lista de Videos</h3>


        <p class="mt-6 text-gray-300 leading-relaxed">
            Completa los campos a continuación para agregar una nueva lista a tu plataforma.
        </p>

        <div class="mt-8">
            <form action="{{ route('listas.store') }}" method="post" class="space-y-6">
                @csrf
                <div>
                    <input style="color:black;" type="text" name="titulo" id="titulo" placeholder="Título de la lista" required
                        class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                </div>
                <div>
                    <textarea style="color:black;" id="descripcion" name="descripcion" rows="4" placeholder="Descripción de la lista"
                        class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"></textarea>
                </div>
                <div>
                    <input style="color:black;" type="url" id="thumbnail" name="thumbnail" placeholder="URL del thumbnail de la lista"
                        class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                </div>
                <div>
                    <select style="color:black;" name="categoria_id" id="categoria_id"
                        class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                        @endforeach
                    </select>
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
    @endsection
