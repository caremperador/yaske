@extends('layouts.template-configuracion')

@section('title', 'Configuración de Precios por País')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Configuración de Precios por País</h2>

        <form action="{{ route('admin.configuracion.pais.store') }}" method="POST">
            @csrf
            {{-- Selección del país --}}
            <div class="mb-4">
                <label for="pais" class="block text-gray-400 text-sm font-bold mb-2">País:</label>
                <select name="pais" id="pais"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                    <option value="">Seleccione un país</option>
                    @foreach ($paises as $pais)
                        <option value="{{ $pais }}">{{ $pais }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Precio mínimo --}}
            <div class="mb-4">
                <label for="precio_minimo" class="block text-gray-400 text-sm font-bold mb-2">Precio Mínimo:</label>
                <input type="number" name="precio_minimo" id="precio_minimo"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    step="0.01" required>
            </div>

            {{-- Precio máximo --}}
            <div class="mb-4">
                <label for="precio_maximo" class="block text-gray-400 text-sm font-bold mb-2">Precio Máximo:</label>
                <input type="number" name="precio_maximo" id="precio_maximo"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    step="0.01" required>
            </div>

            {{-- Botón de envío --}}
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Guardar
                Configuración</button>
        </form>
    </div>



 {{-- ... código anterior ... --}}

<div class="mt-8">
    <h3 class="text-lg font-semibold">Precios Mínimos y Máximos por País</h3>
    <table class="min-w-full leading-normal mt-4">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">País</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Precio Mínimo</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Precio Máximo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($configuraciones as $configuracion)
            <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-black">{{ $configuracion->pais }}</td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-black">{{ $configuracion->precio_minimo }}</td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-black">{{ $configuracion->precio_maximo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- ... código siguiente ... --}}


@endsection
