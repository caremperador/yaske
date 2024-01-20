@extends('layouts.template-configuracion')

@section('title', 'Comprar Días Premium')

@section('content')
    <div class="container mx-auto p-4">
        @if (session('success'))
            <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">
                Éxito
            </div>
            <div class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif
        <div class="bg-[#1F2937] p-6 rounded-lg shadow-lg">
            <h3 class="font-semibold text-white text-xl border-b border-gray-700 pb-2">Comprar Días Como Revendedor</h3>
            <div class="mt-4">
                <form method="POST" action="{{ route('comprar_dias_revendedor.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="cantidad_dias" class="text-gray-200 block mb-2">Cantidad de Días Premium a Comprar</label>
                        <input type="number" id="cantidad_dias" name="cantidad_dias"
                               class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" style="color:black;">
                    </div>

                    <div class="text-center">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                            Comprar días premium
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
