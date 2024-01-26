@extends('layouts.template-configuracion')

@section('title', 'Estado de la Transacción')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Estado de tu Transacción {{ $buyerId }}</h2>
        <div id="transactionStatus">
            Esperando respuesta del vendedor...
        </div>


        {{-- Mostrar el comprobante de pago --}}
        <div class="bg-gray-800 p-4 rounded-lg shadow-lg mb-4">
            <h3 class="font-semibold border-b border-gray-700 pb-2 text-white">Comprobante de Pago</h3>
            <img src="{{ Storage::url($transaction->photo_path) }}" alt="Comprobante"
                style="max-width: 100%; max-height: 200px; height: auto;">
        </div>

        {{-- Botón para cancelar la transacción --}}
        <form action="{{ route('transacciones.cancelar', $transaction->id) }}" method="post">
            @csrf

            <button type="submit"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cancelar Transacción
            </button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('load', function() {
            // Asegúrate de que esta variable se establezca con el ID del vendedor en alguna parte de tu vista o script
            const sellerId = @json($sellerId);
            const transactionId = @json($transaction->id);
            Echo.private('transacciones.comprador.' + transactionId)
                .listen('TransactionApproved', (data) => {
                    window.location.href = "{{ route('transaccion.aprobada') }}";
                })
                .listen('TransactionRejected', (data) => {
                const statusDiv = document.getElementById('transactionStatus');
                if (statusDiv) {
                    statusDiv.innerText = 'Tu comprobante ha sido rechazado';
                    // Opcionalmente, redirigir a otra página o realizar otras acciones
                }
            }); // Cierra el método .listen
        });
    </script>
@endpush
