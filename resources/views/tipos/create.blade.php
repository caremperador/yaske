@extends('layouts.template-configuracion')

@section('title', 'Crear tipo de video')

@section('content')


    <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
        <h3 class="font-semibold border-b border-gray-700 pb-2 text-white"> Crear Nuevo Tipo</h3>


        <p class="mt-6 text-gray-300 leading-relaxed">
            Introduce el nombre del nuevo tipo.
        </p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </span>
            </div>
        @endif

        <div class="mt-8">
            <form action="{{ route('tipos.store') }}" method="post" class="space-y-6">
                @csrf
                <div>
                    <input type="text" name="name" id="name" placeholder="Nombre del tipo" required
                        class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                </div>

                <div class="flex justify-center">
                    <input type="submit" value="Crear Tipo"
                        class="px-6 py-2 text-white bg-indigo-600 rounded-md shadow hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200">
                </div>
            </form>
        </div>
    @endsection
