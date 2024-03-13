@extends('layouts.template-configuracion')

@section('title', 'lista de enlaces caidos')

@section('content')
 

<div class="bg-gray-800 p-6 rounded-lg shadow-lg text-white max-w-4xl mx-auto my-10">

    

    <div class="max-w-7xl mx-auto">
        <div class="text-white text-3xl mb-6">Reportes de Enlaces Caídos</div>
        
        @foreach ($videosConEnlacesCaidos as $video)
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg mb-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">{{ $video->titulo }}</h3>
                    @auth
                        @if (auth()->user()->hasRole('admin'))
                            <a href="{{ route('videos.edit', $video->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Editar
                            </a>
                        @endif
                    @endauth
                </div>
                <div class="mt-4">
                    @foreach ($video->enlaces as $enlace)
                        @if ($enlace->caido)
                            <p class="text-red-400">El enlace {{ $enlace->tipo }} está caído: <a href="{{ $enlace->url }}" target="_blank" class="underline">{{ $enlace->url }}</a></p>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="mt-6">
            {{ $videosConEnlacesCaidos->links() }}
        </div>
    </div>



</div>


@endsection
