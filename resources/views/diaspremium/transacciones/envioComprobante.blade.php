{{-- resources/views/diaspremium/transacciones/envio_comprobante_comprador.blade.php --}}

@extends('layouts.template-configuracion')

@section('title', 'Subir Foto de Pago')

@section('content')

    <div class="bg-gray-800 p-4 rounded-lg">
        <h3 class="font-semibold border-b border-gray-700 pb-2">ENVIAR COMPROBANTE DE PAGO</h3>

        <form action="{{ route('envio_comprobante.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            {{-- Coloca esto dentro de tu formulario, preferiblemente justo encima del botón de envío --}}


            <div class="mb-4" id="imagePreviewContainer"
                style="{{ session('transactionImagePath') ? '' : 'display: none;' }}">
                <label class="block text-gray-300 text-sm font-bold mb-2">Previsualización de la Imagen:</label>
                <img id="imagePreview"
                    src="{{ session('transactionImagePath') ? Storage::url(session('transactionImagePath')) : '#' }}"
                    alt="Previsualización de la Imagen" style="max-width: 100%; height: auto;" />
            </div>


            <div class="mb-4">
                <label for="photo" class="block text-gray-300 text-sm font-bold mb-2">Selecciona una Foto:</label>
                <input type="file" id="photo" name="photo" accept="image/*"
                    class="shadow border rounded py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
                @error('photo')
                    <span class="text-red-500 text-xs italic">{{ $message }}</span>
                @enderror
            </div>

            {{-- Opcional: Selector de Método de Pago --}}
            {{-- Opcional: Selector de Método de Pago --}}
            @if (is_array($metodosPago) && count($metodosPago) > 0)
                <div class="mb-4">
                    <label for="metodo_pago" class="block text-gray-300 text-sm font-bold mb-2">Método de Pago:</label>
                    <select name="metodo_pago" id="metodo_pago"
                        class="shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach ($metodosPago as $metodo)
                            <option value="{{ $metodo['nombre'] }}">{{ $metodo['nombre'] }} - {{ $metodo['detalle'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <p>No hay métodos de pago disponibles.</p>
            @endif



            {{-- Añade esto en tu formulario en la vista del comprador --}}

            <div class="mb-4">
                <label for="seller_id" class="block text-gray-300 text-sm font-bold mb-2">ID del Vendedor:
                    {{ $seller_id ?? '' }} </label>
                <input type="hidden" id="seller_id" name="seller_id" value="{{ $seller_id ?? '' }}">
            </div>
            @if ($revendedor && $revendedor->diasPremiumRevendedor)
                <div>
                    <p>Nombre del Beneficiario: {{ $revendedor->diasPremiumRevendedor->nombres_beneficiario }}</p>
                    <p>Apellidos del Beneficiario: {{ $revendedor->diasPremiumRevendedor->apellidos_beneficiario }}</p>
                </div>
            @endif

            
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Enviar
                comprobante</button>
        </form>

        {{-- ... resto del código de tu vista ... --}}

        @if (session('transactionId'))
            <div id="cancelTransactionContainer" class="mt-4">
                <form action="{{ route('transacciones.cancelar', session('transactionId')) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancelar Orden
                    </button>
                </form>
            </div>
        @endif

        {{-- ... resto del código ... --}}

    </div>



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
