@extends('layouts.template-configuracion')


@section('title', 'Seleccionar Revendedor')

@section('content')

    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Paso1: Selecciona tu País</h2>

        {{-- Formulario para filtrar por país --}}
        <form action="{{ route('seleccionarRevendedorFiltrado') }}" method="GET" class="mb-4">
            <div class="flex items-center">
                <select style="color:black;" name="pais" class="bg-white border rounded px-4 py-2 mr-2">
                    <option value="">Selecciona un país</option>
                    <option value="">Selecciona un país</option>
                    <option value="argentina">Argentina</option>
                    <option value="bolivia">Bolivia</option>
                    <option value="chile">Chile</option>
                    <option value="colombia">Colombia</option>
                    <option value="costa rica">Costa Rica</option>
                    <option value="cuba">Cuba</option>
                    <option value="ecuador">Ecuador</option>
                    <option value="el salvador">El Salvador</option>
                    <option value="españa">España</option>
                    <option value="guatemala">Guatemala</option>
                    <option value="honduras">Honduras</option>
                    <option value="méxico">México</option>
                    <option value="nicaragua">Nicaragua</option>
                    <option value="panamá">Panamá</option>
                    <option value="paraguay">Paraguay</option>
                    <option value="perú">Perú</option>
                    <option value="puerto rico">Puerto Rico</option>
                    <option value="república dominicana">República Dominicana</option>
                    <option value="uruguay">Uruguay</option>
                    <option value="venezuela">Venezuela</option>
                </select>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filtrar
                </button>
            </div>
        </form>
        <h2 class="text-xl font-bold mb-4">Paso 2: Seleccionar Revendedor</h2>

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
                            @if ($revendedor->diasPremiumRevendedor)
                                {!! $revendedor->diasPremiumRevendedor->estado_conectado
                                    ? '<i class="fas fa-circle" style="color: green;"></i>'
                                    : '<i class="fas fa-circle" style="color: red;"></i>' !!} -
                                {{ $revendedor->diasPremiumRevendedor->ultimo_conexion ? $revendedor->diasPremiumRevendedor->ultimo_conexion->diffForHumans() : 'N/A' }}
                            @else
                                <i class="fas fa-circle" style="color: red;"></i> - N/A
                            @endif
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
                            <b>
                                {{ optional($revendedor->diasPremiumRevendedor)->precio ? optional($revendedor->diasPremiumRevendedor)->moneda . ' ' . optional($revendedor->diasPremiumRevendedor)->precio : 'N/A' }}</b>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $revendedor->diasPremiumRevendedor->cantidad_minima ?? 'N/A' }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $revendedor->diasPremiumRevendedor->dias_revendedor_premium ?? 'N/A' }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">



                            @php
                                $metodosPago = json_decode(optional($revendedor->diasPremiumRevendedor)->metodos_pago, true);
                            @endphp

                            @if ($metodosPago && is_array($metodosPago))
                                @foreach ($metodosPago as $metodo)
                                    <span
                                        class="text-black text-0.5xl">{{ $metodo['nombre'] ?? 'Nombre no disponible' }}</span>
                                @endforeach
                            @else
                                <p class="text-white">No hay métodos de pago disponibles.</p>
                            @endif


                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a target="_blank"
                                href="{{ route('envio_comprobante.index', ['seller_id' => $revendedor->id]) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Comprar
                            </a>
                        </td>
                        <!-- Otros campos si es necesario -->
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Enlaces de paginación --}}
        {{ $revendedores->links() }}
    </div>

@endsection
