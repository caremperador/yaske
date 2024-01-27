@extends('layouts.template')
@section('title', 'Inicio')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @foreach ($secciones as $seccion)
            <!-- Sección -->
            <h2 class="text-3xl font-bold text-white mb-4">{{ $seccion['tipo']->name }}</h2>
            
            <!-- Videos sin lista -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach ($seccion['videos'] as $video)
                    <!-- Video card -->
                    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <a href="{{ route('videos.show', $video->id) }}" class="block">
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->titulo }}" class="w-full h-36 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-white">{{ $video->titulo }}</h3>
                                <!-- Información del video -->
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Listas del tipo -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach ($seccion['listas'] as $lista)
                    <!-- Lista card -->
                    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <a href="{{ route('listas.show', $lista->id) }}" class="block">
                            <img src="{{ $lista->thumbnail }}" alt="{{ $lista->titulo }}" class="w-full h-36 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-white">{{ $lista->titulo }}</h3>
                                <!-- Información de la lista -->
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
@endsection
