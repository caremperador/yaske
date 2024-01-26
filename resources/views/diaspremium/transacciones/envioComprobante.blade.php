@extends('layouts.template-configuracion')

@section('title', 'Subir Foto de Pago')

@section('content')



    {{-- Añade esto en tu formulario en la vista del comprador --}}

   
        <div class="bg-gray-800 p-4 rounded-lg shadow-lg mb-4" id="imagePreviewContainer"
            style="{{ session('transactionImagePath') ? '' : 'display: none;' }}">
            <h3 class="font-semibold border-b border-gray-700 pb-2 text-white">TU COMPROBANTE DE PAGO</h3>
            <img id="imagePreview"
                src="{{ session('transactionImagePath') ? Storage::url(session('transactionImagePath')) : '#' }}"
                alt="Previsualización de la Imagen" style="max-width: 100%; max-height: 200px; height: auto;" />
        </div>
   
    <div class="bg-gray-800 p-4 rounded-lg mb-3">
        <h3 class="font-semibold border-b border-gray-700 pb-2">ENVIAR COMPROBANTE DE PAGO</h3>

        <form action="{{ route('envio_comprobante.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            {{-- Coloca esto dentro de tu formulario, preferiblemente justo encima del botón de envío --}}

            {{-- Opcional: Selector de Método de Pago --}}
            @if (is_array($metodosPago) && count($metodosPago) > 0)
                <div class="mb-4">
                    <label class="block text-gray-300 text font-bold mb-3">Paso 1: selecciona el método de Pago</label>
                    @foreach ($metodosPago as $index => $metodo)
                        <div class="flex items-center mb-2">
                            <input type="radio" id="metodo_pago_{{ $index }}" name="metodo_pago"
                                value="{{ $metodo['nombre'] }}"
                                class="text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2">
                            <label for="metodo_pago_{{ $index }}" class="text-gray-300 text-sm">
                                {{ $metodo['nombre'] }} - {{ $metodo['detalle'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No hay métodos de pago disponibles.</p>
            @endif


            {{-- Campo para ingresar la cantidad de días --}}
            <div class="mb-4">
                <label for="cantidad_dias" class="block text-gray-300 text-sm font-bold mb-2">
                    Cantidad de días a comprar (Mínimo: {{ $cantidadMinima }} días):
                </label>
                <!-- Campo para ingresar la cantidad de días -->
                <input style="color:black" type="number" id="cantidad_dias" name="cantidad_dias"
                    value="{{ $cantidadMinima }}" min="{{ $cantidadMinima }}" class="...">

            </div>

            {{-- Mostrar el total a pagar --}}
            <div id="totalPagar" class="text-white mb-4">
                Total a Pagar: {{ $precioPorDia * $cantidadMinima }} {{ $moneda }}
            </div>

            {{-- Campo oculto para el monto total --}}
            <input type="hidden" id="monto_total" name="monto_total" value="{{ $cantidadMinima * $precioPorDia }}">





            <div class="mb-4">
                <label for="photo" class="block text-gray-300 text-sm font-bold mb-2">Selecciona una Foto:</label>
                <input type="file" id="photo" name="photo" accept="image/*"
                    class="shadow border rounded py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
                @error('photo')
                    <span class="text-red-500 text-xs italic">{{ $message }}</span>
                @enderror
            </div>

            {{-- id del revendedor enviandose en el formulario --}}

            <input type="hidden" id="seller_id" name="seller_id" value="{{ $seller_id ?? '' }}">


            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Enviar
                comprobante</button>
        </form>


    </div>

    <div class="bg-gray-800 p-4 rounded-lg shadow-lg mb-4">
        <h3 class="font-semibold border-b border-gray-700 pb-2 text-white">DATOS DEL REVENDEDOR</h3>

        <ul>
            <div class="flex items-center justify-between bg-gray-700 p-3 rounded-lg mt-2 shadow">
                <span class="text-white"> <b>ID del Vendedor:</b>
                    {{ $seller_id ?? '' }}</span>
            </div>
            @if ($revendedor && $revendedor->diasPremiumRevendedor)
                <div class="flex items-center justify-between bg-gray-700 p-3 rounded-lg mt-2 shadow">
                    <span class="text-white"><b>Nombre del Beneficiario:</b>
                        {{ $revendedor->diasPremiumRevendedor->nombres_beneficiario }}
                        {{ $revendedor->diasPremiumRevendedor->apellidos_beneficiario }}</span>

                </div>
            @endif
        </ul>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Calcular y establecer el valor inicial para el monto total
            calcularTotal();

            // Evento para actualizar el monto total cuando cambia la cantidad de días
            document.getElementById('cantidad_dias').addEventListener('input', calcularTotal);
        });

        function calcularTotal() {
            var cantidadDias = document.getElementById('cantidad_dias').value || {{ $cantidadMinima }};
            var precioPorDia = {{ $precioPorDia }};
            var total = cantidadDias * precioPorDia;

            // Actualizar el campo oculto con el monto total
            document.getElementById('monto_total').value = total.toFixed(2);

            // Actualizar el texto en la vista
            document.getElementById('totalPagar').innerText = 'Total a Pagar: ' + total.toFixed(2) +
                ' {{ $moneda }}';
        }
    </script>

    <script>
        function previewImage(fileInput) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('imagePreview');
                var container = document.getElementById('imagePreviewContainer');
                preview.src = e.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }

        document.getElementById('photo').onchange = function(e) {
            previewImage(this);
        };

        window.onload = function() {
            // Verifica si existe una imagen en la sesión y previsualízala
            @if (session('transactionImagePath'))
                previewImage(document.getElementById('photo'));
            @endif
        };
    </script>
@endsection
