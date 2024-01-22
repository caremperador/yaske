{{-- resources/views/diaspremium/revendedor_configuracion.blade.php --}}

@extends('layouts.template-configuracion')

@section('title', 'Configuración de Revendedor')

@section('botones')


@endsection

@section('content')


    @php $diasPremiumRevendedor = optional(auth()->user()->diasPremiumRevendedor); @endphp

    @if (!empty($diasPremiumRevendedor->slug))
        <div class="bg-gray-800 p-4 rounded-lg mb-4">
            <h3 class="font-semibold border-b border-gray-700 pb-2">DATOS DE BENEFICIARIO GUARDADOS</h3>
            <div class="flex items-center justify-between bg-gray-700 p-3 rounded-lg mt-2 shadow">
                <span class="text-white text-lg">
                    {{ $diasPremiumRevendedor->nombres_beneficiario }}
                    {{ $diasPremiumRevendedor->apellidos_beneficiario }}
                </span>
            </div>
        </div>
    @else
        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
            Importante!
        </div>
        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
            solo se puede enviar una unica vez los datos de beneficiario, una vez envies tus nombres y
            apellidos no podras editarlos.<br>
            Asi que asegurate de que tus datos sean correctos y que tu nombre coincida con tus metodos de pago
        </div>
    @endif

    <div class="bg-gray-800 p-4 rounded-lg">
        <h3 class="font-semibold border-b border-gray-700 pb-2">CONFIGURACION DE REVENDEDOR</h3>



        <form action="{{ route('configuracion_revendedor.store') }}" method="POST">
            @csrf
            @if (empty(optional(auth()->user()->diasPremiumRevendedor)->slug))
                {{-- Nombre y Apellido del Beneficiario --}}
                <div class="mb-4">
                    <label for="nombres_beneficiario" class="block text-gray-400 text-sm font-bold mb-2">Nombres del
                        Beneficiario:
                    </label>
                    <input type="text" name="nombres_beneficiario" id="nombres_beneficiario"
                        value="{{ old('nombres_beneficiario') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('nombres_beneficiario')
                        <p class="text-red-500"> {{ $message }}</p>
                    @enderror
                    <label for="apellidos_beneficiario" class="block text-gray-400 text-sm font-bold mb-2 mt-4">Apellidos
                        del
                        Beneficiario:</label>
                    <input type="text" name="apellidos_beneficiario" id="apellidos_beneficiario"
                        value="{{ old('apellidos_beneficiario') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('nombres_beneficiario')
                        <p class="text-red-500"> {{ $message }}</p>
                    @enderror
                </div>
            @endif

            {{-- País y Moneda --}}
            <div class="mb-4 flex items-end space-x-4">
                {{-- País --}}
                <div class="flex-1">
                    <label for="pais" class="block text-gray-400 text-sm font-bold mb-2">País:</label>
                    <select name="pais" id="pais"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
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
                </div>

                {{-- Moneda --}}
                <div class="flex-1">
                    <label for="moneda" class="block text-gray-400 text-sm font-bold mb-2">Moneda:</label>
                    <input type="text" name="moneda" id="moneda"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        readonly>
                </div>
            </div>

            {{-- Prefijo Telefónico y Número de Teléfono --}}
            <div class="mb-4 flex items-end space-x-4">
                {{-- Prefijo Telefónico --}}
                <div class="flex-1">
                    <label for="prefijo_telefonico" class="block text-gray-400 text-sm font-bold mb-2">Prefijo
                        Telefónico:</label>
                    <input type="text" name="prefijo_telefonico" id="prefijo_telefonico"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        readonly>
                </div>

                {{-- Número de Teléfono --}}
                <div class="flex-1">
                    <label for="numero_telefono" class="block text-gray-400 text-sm font-bold mb-2">Número de
                        Teléfono:</label>
                    <input type="tel" name="numero_telefono" id="numero_telefono" value="{{ old('numero_telefono') }}"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
            </div>

            {{-- Cantidad Mínima y Precio --}}
            <div class="mb-4">
                <label for="cantidad_minima" class="block text-gray-400 text-sm font-bold mb-2">Cantidad Mínima:</label>
                <input type="number" name="cantidad_minima" id="cantidad_minima" value="{{ old('cantidad_minima') }}"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>

                <label for="precio" class="block text-gray-400 text-sm font-bold mb-2 mt-4">Precio por día:</label>
                <input type="text" name="precio" id="precio" value="{{ old('precio') }}"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Guardar Configuración
            </button>
        </form>
    </div>


    {{-- ... código anterior ... --}}

    <div class="mt-8">
        <h3 class="text-lg font-semibold">Precios Mínimos y Máximos por País</h3>
        <table class="min-w-full leading-normal mt-4">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        País</th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Precio Mínimo</th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Precio Máximo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($preciosPaises as $configuracion)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-black">
                            {{ $configuracion->pais }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-black">
                            {{ $configuracion->precio_minimo }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-black">
                            {{ $configuracion->precio_maximo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ... código siguiente ... --}}



    @push('scripts')
        <script>
            const paisInfo = {
                'argentina': {
                    moneda: 'ARS',
                    prefijo: '+54'
                },
                'bolivia': {
                    moneda: 'BOB',
                    prefijo: '+591'
                },
                'chile': {
                    moneda: 'CLP',
                    prefijo: '+56'
                },
                'colombia': {
                    moneda: 'COP',
                    prefijo: '+57'
                },
                'costa rica': {
                    moneda: 'CRC',
                    prefijo: '+506'
                },
                'cuba': {
                    moneda: 'CUP',
                    prefijo: '+53'
                },
                'ecuador': {
                    moneda: 'USD',
                    prefijo: '+593'
                },
                'el salvador': {
                    moneda: 'USD',
                    prefijo: '+503'
                },
                'españa': {
                    moneda: 'EUR',
                    prefijo: '+34'
                },
                'guatemala': {
                    moneda: 'GTQ',
                    prefijo: '+502'
                },
                'honduras': {
                    moneda: 'HNL',
                    prefijo: '+504'
                },
                'méxico': {
                    moneda: 'MXN',
                    prefijo: '+52'
                },
                'nicaragua': {
                    moneda: 'NIO',
                    prefijo: '+505'
                },
                'panamá': {
                    moneda: 'PAB',
                    prefijo: '+507'
                },
                'paraguay': {
                    moneda: 'PYG',
                    prefijo: '+595'
                },
                'perú': {
                    moneda: 'PEN',
                    prefijo: '+51'
                },
                'puerto rico': {
                    moneda: 'USD',
                    prefijo: '+1-787',
                    alternativo: '+1-939'
                },
                'república dominicana': {
                    moneda: 'DOP',
                    prefijo: '+1-809',
                    alternativo: '+1-829',
                    otroAlternativo: '+1-849'
                },
                'uruguay': {
                    moneda: 'UYU',
                    prefijo: '+598'
                },
                'venezuela': {
                    moneda: 'VES',
                    prefijo: '+58'
                }
            };
        </script>


        <script>
            document.getElementById('pais').addEventListener('change', function() {
                let paisSeleccionado = this.value;
                let moneda = paisInfo[paisSeleccionado]?.moneda || '';
                let prefijo = paisInfo[paisSeleccionado]?.prefijo || '';

                document.getElementById('moneda').value = moneda;
                document.getElementById('prefijo_telefonico').value = prefijo;
            });
        </script>
    @endpush
@endsection
