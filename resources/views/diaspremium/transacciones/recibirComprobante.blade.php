@extends('layouts.template-configuracion')

@section('title', 'Transacciones')

@section('content')

    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Transacciones Recibidas</h2>
        <table class="min-w-full leading-normal text-black">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        ID
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Comprador
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Foto de Pago
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Rechazar
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Aprobar
                    </th>
                    <!-- Otros campos según sea necesario -->
                </tr>
            </thead>
            <tbody id="transactionsContainer">
                @foreach ($transactions as $transaction)
                    <tr id="transaction_{{ $transaction->id }}">
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $transaction->id }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $transaction->buyer->name }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a href="{{ Storage::url($transaction->photo_path) }}" target="_blank">Ver Foto</a>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                            <button class="text-red-500 hover:text-red-700 focus:outline-none">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                            <button class="text-green-500 hover:text-green-700 focus:outline-none">
                                <i class="fas fa-check"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    @push('scripts')
        <script>
            window.addEventListener('load', function() {
                // Asegúrate de que esta variable se establezca con el ID del vendedor en alguna parte de tu vista o script
                const sellerId = @json($sellerId);
                Echo.private('transactions.' + sellerId)
                    .listen('NewTransaction', (data) => {
                        const transactionsContainer = document.getElementById('transactionsContainer');

                        // Crear la fila de la tabla para la nueva transacción
                        const newTransactionRow = document.createElement('tr');
                        newTransactionRow.id = `transaction_${data.transaction.id}`;
                        newTransactionRow.innerHTML = `
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">${data.transaction.id}</td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">${data.transaction.buyer_name}</td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                <a href="/storage/${data.transaction.photo_path}" target="_blank">Ver Foto</a>
            </td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                <button class="text-red-500 hover:text-red-700 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                <button class="text-green-500 hover:text-green-700 focus:outline-none">
                    <i class="fas fa-check"></i>
                </button>
            </td>
                `;

                        // Añadir la nueva fila al principio del cuerpo de la tabla
                        transactionsContainer.prepend(newTransactionRow);
                    })

                .listen('TransactionCancelled', (data) => {
                    // Eliminar la fila de la transacción cancelada
                    var transactionRow = document.getElementById('transaction_' + data.transactionId);
                    if (transactionRow) {
                        transactionRow.remove();
                    }
                });
            });
        </script>
    @endpush




@endsection
