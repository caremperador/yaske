@extends('layouts.template')
@section('title', 'Listas de tipo ' . $tipo->name)

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($listas as $lista)
                    <!-- Lista card -->
                    <a href="{{ route('listas.show', $lista->id) }}" class="bg-gray-800 rounded-lg shadow-md overflow-hidden block">
                        <div class="bg-cover bg-center h-64" style="background-image: url('{{ $lista->thumbnail }}');"></div>
                        <div class="p-4">
                            <h3 class="font-bold text-white">{{ $lista->titulo }}</h3>
                            <p class="text-gray-400 text-sm">{{ $lista->descripcion }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-4">
                        <p class="text-center text-gray-500">No hay listas disponibles en este tipo.</p>
                    </div>
                @endforelse
            </div>

            <!-- Paginación -->
            <div class="mt-6 flex justify-center">
                {{ $listas->links() }}
            </div>
        </div>
    </div>
@endsection
