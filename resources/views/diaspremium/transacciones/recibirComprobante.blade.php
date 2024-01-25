@extends('layouts.template-configuracion')

@section('title', 'Transacciones')

@section('content')


    <div class="bg-gray-800 p-4 rounded-lg mb-4">
        <h3 class="font-semibold border-b border-gray-700 pb-2">CONECTARME / DESCONECTARME</h3>
        @if (optional(auth()->user()->diasPremiumRevendedor)->exists)
            {{-- Botón para conectarse o desconectarse --}}
            <form action="{{ route('conectar.desconectar') }}" method="post">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    @if (auth()->user()->diasPremiumRevendedor->estado_conectado)
                        Desconectar
                    @else
                        Conectar
                    @endif
                </button>
            </form>
        @else
            <p class="text-red-500">Por favor, completa tu configuración de revendedor para poder conectarte.</p><br />
            <a href="{{ route('configuracion_revendedor.index') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ir a configuración</a>
        @endif


    </div>


    @if (optional(auth()->user()->diasPremiumRevendedor)->exists)
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
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Metodo de pago
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Cantidad
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Monto total
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                           Aprobar
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Rechazar
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
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $transaction->metodo_pago }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $transaction->cantidad_dias }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $transaction->monto_total }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                {{-- Botón Aprobar --}}
                                <form action="{{ route('transacciones.aprobar', $transaction->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="text-green-500 hover:text-green-700 focus:outline-none">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                {{-- Botón Rechazar --}}
                                <form action="{{ route('transacciones.rechazar', $transaction->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <!-- si no hay no se le muestra nada-->
    @endif

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
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">${data.transaction.metodo_pago}</td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">${data.transaction.cantidad_dias}</td>
 <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">${data.transaction.monto_total}</td>
 <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">      
                                <form action="{{ route('transacciones.aprobar', $transaction->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="text-green-500 hover:text-green-700 focus:outline-none">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">  
                                <form action="{{ route('transacciones.rechazar', $transaction->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
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
