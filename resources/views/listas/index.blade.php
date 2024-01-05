@extends('layouts.template')
@section('title', 'Listas de Videos')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($listas as $lista)
                    <!-- Lista card -->
                    <a href="{{ route('listas.show', $lista->id) }}" class="bg-gray-800 rounded-lg shadow-md overflow-hidden block">
                        <div>
                            <!-- Thumbnail -->
                            <img src="{{ $lista->thumbnail }}" alt="{{ $lista->titulo }}" class="w-full">
                            <!-- Lista details -->
                            <div class="p-4">
                                <h3 class="font-bold text-white">{{ $lista->titulo }}</h3>
                                <p class="text-gray-400 text-sm mt-1">{{ $lista->tipo->name ?? 'Tipo no especificado' }}</p>
                                <!-- Aquí puedes agregar más información sobre la lista si es necesario -->
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-4">
                        <p class="text-center text-gray-500">No hay listas disponibles.</p>
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
