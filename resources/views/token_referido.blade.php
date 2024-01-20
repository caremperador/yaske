@extends('layouts.template-configuracion')

@section('title', 'Token de Referido')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-[#1F2937] p-6 rounded-lg shadow-lg text-center mb-4">
            <h3 class="text-xl font-bold mb-4 text-white">Token de Referido</h3>

            @if ($token)
                
                <p class="text-6xl text-green-500 font-bold my-4">{{ $token }}</p>
                @if ($timeLeft)
                    <p class="text-white">Expira en:</p>
                    <p class="text-red-500 text-lg font-bold">{{ $timeLeft }}</p>
                @else
                    <p class="text-red-500">El token ha expirado.</p>
                @endif
            @else
                <p class="text-white">No hay token generado.</p>
            @endif

            <form action="{{ route('generar.token') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow focus:outline-none focus:shadow-outline">
                    Generar Nuevo Token
                </button>
            </form>
        </div>

        <div class="bg-gray-800 p-4 rounded-lg shadow-lg mb-4">
            <h3 class="font-semibold border-b border-gray-700 pb-2 text-white">Lista de Tus Referidos</h3>
            @if ($referidos->isNotEmpty())
                <div class="mt-4">
                    @foreach ($referidos as $referido)
                        <div class="flex items-center justify-between bg-gray-700 p-3 rounded-lg mt-2 shadow">
                            <span class="text-white text-lg">{{ $referido->referido->name }}</span>
                            <span class="text-white">Referido por: {{ $referido->revendedor->name }}</span>
                            <span class="text-white">{{ $referido->created_at->format('d/m/Y') }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-white">No tienes referidos todavía.</p>
            @endif
        </div>
        
    </div>
@endsection
