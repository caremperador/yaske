<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Categoría') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="max-w-2xl mx-auto">
                    <h1 class="text-2xl font-medium text-gray-900">
                        Crear Nueva Categoría
                    </h1>
                    <p class="mt-6 text-gray-500 leading-relaxed">
                        Introduce el nombre de la nueva categoría.
                    </p>

                    <!-- Mostrar errores de validación -->
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
                        <form action="{{ route('categorias.store') }}" method="post" class="space-y-6">
                            @csrf
                            <div>
                                <input type="text" name="name" id="name" placeholder="Nombre de la categoría" required
                                    class="block w-full px-4 py-3 bg-white border rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            </div>

                            <div class="flex justify-center">
                                <input type="submit" value="Crear Categoría"
                                    class="px-6 py-2 text-white bg-indigo-600 rounded-md shadow hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
