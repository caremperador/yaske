@extends('layouts.template-configuracion')

@section('title', 'Añadir Métodos de Pago')

@section('botones')
    {{-- Tus otros botones de navegación aquí --}}
@endsection

@section('content')
    {{-- Mostrar métodos de pago existentes --}}
    @if (is_array($metodosPagoExistentes) && !empty($metodosPagoExistentes))
        <div class="bg-gray-800 p-4 rounded-lg shadow-lg mb-4">
            <h3 class="font-semibold border-b border-gray-700 pb-2 text-white">Métodos de Pago</h3>

            <ul>
                @foreach ($metodosPagoExistentes as $metodo)
                   

                    <div class="flex items-center justify-between bg-gray-700 p-3 rounded-lg mt-2 shadow">
                        <span
                            class="text-white text-lg">{{ $metodo['nombre'] ?? 'Nombre no disponible' }}</span>
                        <span class="text-white">{{ $metodo['detalle'] ?? 'Detalle no disponible' }}</span>
                    </div>
                @endforeach
            </ul>
        </div>
    @else
        <p>No tienes métodos de pago añadidos.</p>
    @endif


    <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
        <h3 class="font-semibold border-b border-gray-700 pb-2 text-white">Añadir Métodos de Pago</h3>

        <form action="{{ route('metodosPago.guardar') }}" method="POST" class="mt-4">
            @csrf

            {{-- Método de Pago - Nombre y Detalle --}}
            <div id="metodosPagoContainer">
                {{-- Aquí se añadirán los campos dinámicamente --}}
            </div>

            {{-- Botón para agregar más métodos de pago --}}
            <div class="mt-4">
                <button type="button" id="agregarMetodoPagoBtn"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Agregar Método de Pago
                </button>
            </div>

            {{-- Botón de envío del formulario --}}
            <div class="mt-4">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Guardar Métodos de Pago
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('agregarMetodoPagoBtn').addEventListener('click', function() {
            const container = document.getElementById('metodosPagoContainer');
            const newElement = `
                <div class="mb-4">
                    <input type="text" name="metodo_pago_nombre[]" placeholder="Nombre del Método" 
                           class="shadow border rounded w-full py-2 px-3 text-gray-700 mb-2">
                    <input type="text" name="metodo_pago_detalle[]" placeholder="Detalle (ej. número de cuenta)" 
                           class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newElement);
        });
    </script>
@endsection
