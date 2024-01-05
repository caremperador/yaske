@extends('layouts.template')
@section('title', 'Yaske - Pagina principal')
@section('content')

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($videosSinLista as $video)
            <!-- Video card -->
            <a href="{{ route('videos.show', $video->id) }}" class="bg-gray-800 rounded-lg shadow-md overflow-hidden block">
                <div>
                    <!-- Thumbnail -->
                    <img src="{{ $video->thumbnail }}" alt="Video thumbnail" class="w-full">
                    <!-- Video details -->
                    <div class="p-4">
                        <h3 class="font-bold">{{ $video->titulo }}</h3>
                        <p class="text-gray-400 text-sm mt-1">{{ $video->tipo->name }}</p>
                        <div class="flex items-center text-gray-500 text-sm mt-2">
                            <!-- Additional video info -->
                        </div>
                    </div>
                </div>
            </a>
        @endforeach


        @foreach ($listas as $lista)
            <!-- Lista card -->
            <a href="{{ route('listas.show', $lista->id) }}" class="bg-gray-800 rounded-lg shadow-md overflow-hidden block">
                <div>
                    <!-- Thumbnail -->
                    <img src="{{ $lista->thumbnail }}" alt="Lista thumbnail" class="w-full">
                    <!-- Lista details -->
                    <div class="p-4">
                        <h3 class="font-bold">{{ $lista->titulo }}</h3>
                        <p class="text-gray-400 text-sm mt-1">{{ $lista->tipo->name }}</p>
                        <div class="flex items-center text-gray-500 text-sm mt-2">
                            <!-- Additional lista info -->
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="w-full flex justify-center">
        <div class="flex justify-center">
            {{-- {{ $videosSinLista->links() }} --}}
        </div>
    </div>
@endsection
@section('footer')

@endsection

{{-- 
public function index()
    {
        // Define la cantidad de elementos por página (debe ser múltiplo de 12)
        $itemsPerPage = 12; // Puede ser 12, 24, 36, etc.

        // Obtén todos los videos que no pertenecen a ninguna lista
        $videosSinLista = Video::whereNull('lista_id')->orderBy('id', 'desc')->paginate($itemsPerPage, ['*'], 'page_v');

        // Calcula cuántos elementos ya se están mostrando (videos)
        $videosCount = $videosSinLista->count();

        // Calcula cuántos elementos adicionales se pueden mostrar (listas)
        $additionalListasCount = $itemsPerPage - $videosCount;

        // Si necesitas mostrar más listas, ajusta la cantidad
        if ($additionalListasCount > 0) {
            $listas = Lista::orderBy('id', 'desc')->limit($additionalListasCount)->get();
        } else {
            $listas = collect();
        }

        return view('videos.index', compact('videosSinLista', 'listas'));
    } --}}