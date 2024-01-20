{{-- resources/views/diaspremium/revendedor_configuracion.blade.php --}}

@extends('layouts.template-configuracion')

@section('title', 'Configuración de Revendedor')

@section('botones')


@endsection

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-gray-800 p-4 rounded-lg">
        <h3 class="font-semibold border-b border-gray-700 pb-2">CONFIGURACION DE REVENDEDOR</h3>



        <form action="{{ route('revendedor.configuracion.guardar') }}" method="POST">
            @csrf
            {{-- Nombre y Apellido del Beneficiario --}}
            <div class="mb-4">
                <label for="nombres_beneficiario" class="block text-gray-400 text-sm font-bold mb-2">Nombres del
                    Beneficiario:</label>
                <input type="text" name="nombres_beneficiario" id="nombres_beneficiario"
                    value="{{ old('nombres_beneficiario') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>

                <label for="apellidos_beneficiario" class="block text-gray-400 text-sm font-bold mb-2 mt-4">Apellidos del
                    Beneficiario:</label>
                <input type="text" name="apellidos_beneficiario" id="apellidos_beneficiario"
                    value="{{ old('apellidos_beneficiario') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>



            {{-- País --}}
            <div class="mb-4">
                <label for="pais" class="block text-gray-400 text-sm font-bold mb-2">País:</label>
                <select name="pais" id="pais"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                    <option value="">Selecciona un país</option>
                    <option value="peru">Perú</option>
                    <option value="colombia">Colombia</option>
                    {{-- ... otros países ... --}}
                </select>
            </div>

            {{-- Número de Teléfono y WhatsApp Link --}}
            <div class="mb-4">
                <label for="numero_telefono" class="block text-gray-400 text-sm font-bold mb-2">Número de Teléfono:</label>
                <input type="tel" name="numero_telefono" id="numero_telefono" value="{{ old('numero_telefono') }}"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                {{-- Aquí puedes agregar un evento onblur o onchange para generar el link de WhatsApp automáticamente --}}
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
@endsection
