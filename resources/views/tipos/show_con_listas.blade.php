@extends('layouts.template')
@section('title', 'Listas de tipo ' . $tipo->name)

@section('content')
    <div class="flex flex-col justify-center">
        <div class="relative m-3 flex flex-wrap mx-auto justify-center">

            <div class="grid xs:grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2  2xl:grid-cols-4 gap-2">
                @forelse ($listas as $lista)

                    <!-- listas card -->
                    <div class="relative  w-[340px] bg-white/5 shadow-md rounded-3xl p-2 mx-1 my-3 ">
                        <div class="overflow-x-hidden rounded-2xl relative">
                            <a href="{{ route('listas.show', $lista->id) }}" class="block"> <img
                                    class="h-40 rounded-2xl w-full object-cover" src="{{ asset('storage/' . $lista->thumbnail) }}"
                                    alt="{{ $lista->titulo }}"></a>
                            <p class="absolute right-2 top-2 cursor-pointer">
                                @foreach ($lista->categorias as $categoria)
                                    @if ($categoria->name == 'Prime Video')
                                        <img src="/images/logo/logo-prime-video.png" height="35" width="35" />
                                    @elseif ($categoria->name == 'Netflix')
                                        <img src="/images/logo/logo-netflix.png" height="35" width="35" />
                                    @endif
                                @endforeach

                            </p>
                        </div>
                        <div class="mt-4 pl-2 mb-2 flex justify-between ">
                            <div>
                                <p class="text-md font-semibold text-gray-200 mb-4 line-clamp-1">{{ $lista->titulo }}
                                </p>
                                <p class="text-md text-gray-400 mt-0"></p>
                                <!-- Idiomas disponibles en la lista -->
                                @php
                                    $idiomas = ['Ing' => false, 'Es' => false, 'Lat' => false, 'Sub' => false];
                                    foreach ($lista->videos as $video) {
                                        $idiomas['Ing'] = $idiomas['Ing'] || !empty($video->url_video);
                                        $idiomas['Es'] = $idiomas['Es'] || !empty($video->es_url_video);
                                        $idiomas['Lat'] = $idiomas['Lat'] || !empty($video->lat_url_video);
                                        $idiomas['Sub'] = $idiomas['Sub'] || !empty($video->sub_url_video);
                                    }
                                @endphp

                                @foreach ($idiomas as $idioma => $disponible)
                                    @if ($disponible)
                                        <span class="text-xxs text-gray-300 uppercase bg-gray-600 px-1 py-1 rounded"><i
                                                class="fa fa-volume-up pr-1"></i>{{ $idioma }}</span>
                                    @endif
                                @endforeach
                            </div>
                            <div class="flex flex-col-reverse mb-1 mr-2 text- group cursor-pointer">

                              {{--   <!-- Indica si contiene videos premium -->
                                @php
                                    $esPremium = $lista->videos->contains(function ($video) {
                                        return $video->estado == 1;
                                    });
                                @endphp
                                @if ($esPremium)
                                    <span
                                        class="text-xxs text-gray-300 font-bold uppercase bg-red-800  px-1 py-1 rounded absolute right-2 bottom-4">Contiene
                                        Premium</span>
                                @else
                                    <span
                                        class="text-xxs text-gray-300 font-bold uppercase bg-green-800 px-1 py-1 rounded  absolute right-2 bottom-4">Todo
                                        Gratis</span>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4">
                        <p class="text-center text-gray-500">No hay listas disponibles en este tipo.</p>
                    </div>
                @endforelse
            </div>


        </div>

    </div>


    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="mx-auto max-w-3xl">
            <!-- Paginación -->
            <div class="my-6">
                {{ $listas->links() }}
            </div>
        </div>
    </div>

@endsection
