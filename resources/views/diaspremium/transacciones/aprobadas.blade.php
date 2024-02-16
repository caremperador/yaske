@extends('layouts.template-configuracion')

@section('title', 'Transacciones')

@section('content')

    <div class="bg-gray-800 p-4 rounded-lg mb-4">
        <h3 class="font-semibold border-b border-gray-700 pb-2">Transacciones Aprobadas</h3>
        <div class="list-group">
            @foreach ($transaccionesAprobadas as $transaccion)
                <div class="list-group-item">
                    Transacción #{{ $transaccion->id }} - Estado: {{ $transaccion->estado }}
                    <!-- Más detalles de la transacción aquí -->
                </div>
            @endforeach
        </div>

    </div>

@endsection
