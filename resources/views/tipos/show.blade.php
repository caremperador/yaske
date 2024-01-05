@extends('layouts.template')
@section('title', 'Videos de ' . $tipo->name)

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($videos as $video)
                    <!-- Video card -->
                    <a href="{{ route('videos.show', $video->id) }}" class="bg-gray-800 rounded-lg shadow-md overflow-hidden block">
                        <img src="{{ $video->thumbnail }}" alt="{{ $video->titulo }}" class="w-full">
                        <div class="p-4">
                            <h3 class="font-bold text-white">{{ $video->titulo }}</h3>
                            <!-- Otra información del video si es necesario -->
                        </div>
                    </a>
                @empty
                    <div class="col-span-4">
                        <p class="text-center text-gray-500">No hay videos disponibles en este tipo.</p>
                    </div>
                @endforelse
            </div>

            <!-- Paginación -->
            <div class="mt-6 flex justify-center">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
@endsection
