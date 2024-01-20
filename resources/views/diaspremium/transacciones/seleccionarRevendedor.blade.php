@extends('layouts.template')

@section('title', 'Seleccionar Revendedor')

@section('content')

    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Seleccionar Revendedor</h2>

        <table class="min-w-full leading-normal text-black">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Estado
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Pais
                    </th>

                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Nombre
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Precio
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Cantidad Mínima
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Días Premium
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Métodos de Pago
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        comprar
                    </th>
                    <!-- Otros campos si es necesario -->
                </tr>
            </thead>
            <tbody>
                @foreach ($revendedores as $revendedor)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {!! $revendedor->estado_conectado
                                ? '<i class="fas fa-circle" style="color: green;"></i>'
                                : '<i class="fas fa-circle" style="color: red;"></i>' !!} -
                            {{ $revendedor->ultimo_conexion ? $revendedor->ultimo_conexion->diffForHumans() : 'N/A' }}

                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $revendedor->diasPremiumRevendedor->pais ?? 'N/A' }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                           
                            @if (!empty($revendedor->diasPremiumRevendedor->slug))
                                <a
                                    href="{{ route('perfilRevendedor', ['slug' => $revendedor->diasPremiumRevendedor->slug]) }}">
                                    {{ $revendedor->diasPremiumRevendedor->nombres_beneficiario }}
                                </a>
                            @else
                                {{ $revendedor->nombres_beneficiario }}
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $revendedor->diasPremiumRevendedor->precio ? '$' . $revendedor->diasPremiumRevendedor->precio : 'N/A' }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $revendedor->diasPremiumRevendedor->cantidad_minima ?? 'N/A' }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $revendedor->diasPremiumRevendedor->dias_revendedor_premium ?? 'N/A' }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ implode(', ', json_decode($revendedor->metodos_pago, true) ?? []) }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a target="_blank" href="{{ route('photo.form', ['seller_id' => $revendedor->id]) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Comprar
                            </a>
                        </td>
                        <!-- Otros campos si es necesario -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
