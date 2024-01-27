@extends('layouts.template')
@section('title', 'Estrenos Gratis')

@section('content')

<div class="bg-gray-800">
    <div class="text-white">
        <h2 class="text-xl font-bold mb-4 px-4 pt-4">Estrenos Gratis</h2>
        <ul>
            @forelse ($videos as $video)
                <li class="border-b border-gray-700  hover:bg-gray-900 transition duration-150 ease-in-out">
                    <a href="{{ route('videos.show', $video->id) }}" class="block">
                        <div class="flex items-start p-4">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->titulo }}"
                                class="h-24 w-40 object-cover">
                            </div>
                            <div class="ml-4 flex-grow">
                                <a href="{{ route('videos.show', $video->id) }}" class="block">
                                    <h3 class="font-semibold">{{ $video->titulo }}</h3>
                                    <p class="text-gray-400 text-sm">{{ Str::limit($video->descripcion, 100, '...') }}
                                    </p>
                                    <p class="text-gray-400 text-sm mt-1">
                                        Estado:
                                        <span class="{{ $video->estado == 0 ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $video->estado == 0 ? 'Gratis' : 'Premium' }}
                                        </span>
                                        | Tipo: {{ $video->tipo->name }}
                                    </p>
                                    <div class="text-gray-400 text-sm mt-2">
                                        <strong>Idiomas disponibles:</strong>
                                        <div class="flex flex-row flex-wrap gap-2 mt-1">
                                            @if ($video->url_video)
                                                <span class="bg-gray-700 px-2 py-1 rounded">Inglés</span>
                                            @endif
                                            @if ($video->es_url_video)
                                                <span class="bg-gray-700 px-2 py-1 rounded">Español (España)</span>
                                            @endif
                                            @if ($video->lat_url_video)
                                                <span class="bg-gray-700 px-2 py-1 rounded">Español
                                                    (Latinoamérica)</span>
                                            @endif
                                            @if ($video->sub_url_video)
                                                <span class="bg-gray-700 px-2 py-1 rounded">Inglés Subtitulado</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </a>
                </li>
            @empty
                <li class="px-4 py-2">
                    <p>No se encontraron videos.</p>
                </li>
            @endforelse
        </ul>

        <!-- Paginación -->
        <div class="px-4 py-3">
            {{ $videos->links() }}
        </div>
    </div>
</div>

@endsection
