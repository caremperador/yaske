@extends('layouts.template-configuracion')

@section('title', 'Editar Video')

@section('content')
    <div class="container">
        <h1>Agregar Capítulo a Lista</h1>
        <form action="{{ route('capitulos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
             {{-- Seleccionar foto --}}
            <div>
                <label for="thumbnail">Miniatura:</label>
                <input type="file" name="thumbnail" id="thumbnail" required>
            </div>
            {{-- Selector de Lista --}}
            <div class="mb-3">
                <label for="lista_id" class="form-label">Seleccionar Lista</label>
                <select style="color: black;" name="lista_id" id="lista_id" class="form-select">
                    <option value="">Seleccione una Lista</option>
                    @foreach ($listas as $lista)
                        <option style="color: black;" value="{{ $lista->id }}">{{ $lista->titulo }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Título del Capítulo --}}
            <div class="mb-3">
                <label for="titulo" class="form-label">Título del Capítulo</label>
                <input style="color: black;" type="text" name="titulo" id="titulo" class="form-control" required>
            </div>

            {{-- URL del Video --}}
            <div class="mb-3">
                <label for="url_video" class="form-label">URL del Video</label>
                <input style="color: black;" type="text" name="url_video" id="url_video" class="form-control" required>
            </div>

            {{-- Estado --}}
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select style="color: black;" name="estado" id="estado" class="form-select">
                    <option style="color: black;" value="1">Activo</option>
                    <option style="color: black;" value="0">Inactivo</option>
                </select>
            </div>

            {{-- Botón de envío --}}
            <button type="submit" class="btn btn-primary">Agregar Capítulo</button>
        </form>
    </div>
@endsection
