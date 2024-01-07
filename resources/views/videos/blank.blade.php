{{-- ... Parte anterior de tu vista ... --}}

{{-- Sección de calificaciones --}}
<div class="mt-8 bg-gray-800 p-6 rounded-lg shadow-lg">
    {{-- Puntuación promedio y estrellas --}}
    <div class="flex items-center mb-4">
        <div class="text-4xl text-yellow-400 mr-2">{{ number_format($puntuacionPromedio, 1) }}</div>
        <div>
            @for ($i = 1; $i <= 5; $i++)
                <span class="text-yellow-400">{{ $puntuacionPromedio >= $i ? '★' : '☆' }}</span>
            @endfor
        </div>
        <div class="text-sm text-gray-400 ml-2">({{ $totalOpiniones }} opiniones)</div>
    </div>

    {{-- Barras de calificación por puntuación --}}
    @foreach ($opinionesPorPuntuacion as $puntuacion => $cantidad)
        <div class="flex items-center my-1">
            <div class="text-xs w-6">{{ $puntuacion }}</div>
            <div class="w-full bg-gray-700 rounded-full h-2 overflow-hidden">
                <div class="bg-green-500 h-2" style="width: {{ $totalOpiniones > 0 ? ($cantidad / $totalOpiniones) * 100 : 0 }}%"></div>
            </div>
        </div>
    @endforeach
</div>

{{-- ... Formulario de puntuación ... --}}

{{-- Sección de comentarios --}}
<div class="mt-8 bg-gray-800 p-6 rounded-lg shadow-lg">
    <h3 class="text-xl font-bold mb-4 text-white">Críticas para este video</h3>
    <div class="flex justify-between items-center">
        <div>{{ $video->comentarios->count() }} comentarios</div>
        <div>
            {{-- Condición para mostrar el formulario solo si el usuario ya ha votado --}}
            @if ($usuarioHaVotado)
                {{-- Formulario de comentarios --}}
                {{-- ... --}}
            @else
                <p class="text-white">Debes puntuar el video para poder dejar un comentario.</p>
            @endif
        </div>
    </div>

    {{-- Listado de comentarios --}}
    {{-- ... --}}

</div>

{{-- ... Resto de tu vista ... --}}
