@extends('layouts.template')
@section('title', 'Yaske - Pagina principal')
@section('content')

                 

<div class="flex justify-center">
    <div class="w-full lg:w-8/12 xl:w-9/12">

        <div class="aspect-w-16 aspect-h-9 bg-gray-900">

            <!-- Responsive Video Container -->
            <div class="relative" style="padding-top: 56.25%;">
                <!-- YouTube Video Embed -->
                <iframe class="absolute top-0 left-0 w-full h-full"
                    src="{{$video->url_video}}" title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        </div>


        <div class="mt-4">
            <h2 class="text-2xl font-bold">{{$video->titulo}}</h2>
            <p class="text-gray-400 text-sm mt-1">{{$video->name}} </p>
              <!-- Video description -->
              <p class="text-gray-400 text-sm mt-4">{{$video->descripcion}}</p>
            <div class="flex items-center justify-between mt-3">
              
               
               
                <div class="flex items-center justify-between mt-3">
                    <!-- Botones de navegación -->
                    @if($video->lista)
                        <a href="{{ route('listas.show', $video->lista->id) }}"
                           class="text-white bg-blue-600 hover:bg-blue-700 font-semibold py-2 px-4 rounded shadow mr-5">
                            Ir a la Lista de Videos
                        </a>
                    @endif
    
                    <div class="flex gap-2">
                        @if($prevVideo)
                            <a href="{{ route('videos.show', $prevVideo->id) }}"
                               class="text-white bg-gray-600 hover:bg-gray-700 font-semibold py-2 px-4 rounded shadow">
                                Anterior
                            </a>
                        @endif
    
                        @if($nextVideo)
                            <a href="{{ route('videos.show', $nextVideo->id) }}"
                               class="text-white bg-gray-600 hover:bg-gray-700 font-semibold py-2 px-4 rounded shadow">
                                Siguiente
                            </a>
                        @endif
                    </div>
                </div>



            </div>
           
        </div>
    </div>
</div>
       

@endsection
@section('footer')

@endsection