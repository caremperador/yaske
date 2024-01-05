@extends('layouts.template')
@section('title', 'Yaske - Página principal')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($videos as $video)
            <!-- Video card -->
            <a href="{{ route('videos.show', $video->id) }}" class="bg-gray-800 rounded-lg shadow-md overflow-hidden block">
                <div>
                    <!-- Thumbnail -->
                    <img src="{{ $video->thumbnail }}" alt="Video thumbnail" class="w-full">
                    <!-- Video details -->
                    <div class="p-4">
                        <h3 class="font-bold">{{ $video->titulo }}</h3>
                        <p class="text-gray-400 text-sm mt-1">{{ $video->tipo->name }}</p>
                        <!-- Additional video info -->
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="w-full flex justify-center mt-8">
        {{ $videos->links() }}
    </div>
@endsection
