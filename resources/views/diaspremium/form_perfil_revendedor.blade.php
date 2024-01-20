{{-- resources/views/diaspremium/perfilRevendedor.blade.php --}}

@extends('layouts.template-configuracion')

@section('title', 'Perfil de Revendedor')

@section('content')

    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Configuración del Perfil de Revendedor</h2>

        <form action="{{ route('perfil_revendedor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Mensaje de Perfil --}}
            <div class="mb-4">
                <label for="mensaje_perfil" class="block text-gray-400 text-sm font-bold mb-2">Mensaje de Perfil:</label>
                <textarea name="mensaje_perfil" id="mensaje_perfil" rows="4"
                          class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('mensaje_perfil') }}</textarea>
            </div>

            {{-- Link de Telegram --}}
            <div class="mb-4">
                <label for="link_telegram" class="block text-gray-400 text-sm font-bold mb-2">Enlace de Telegram:</label>
                <input type="text" name="link_telegram" id="link_telegram"
                       class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       value="{{ old('link_telegram') }}">
            </div>

            {{-- Link de WhatsApp --}}
            <div class="mb-4">
                <label for="link_whatsapp" class="block text-gray-400 text-sm font-bold mb-2">Enlace de WhatsApp:</label>
                <input type="text" name="link_whatsapp" id="link_whatsapp"
                       class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       value="{{ old('link_whatsapp') }}">
            </div>

            {{-- Foto de Perfil --}}
            <div class="mb-4">
                <label for="foto_perfil" class="block text-gray-400 text-sm font-bold mb-2">Foto de Perfil:</label>
                <input type="file" name="foto_perfil" id="foto_perfil"
                       class="shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Guardar Cambios
            </button>
        </form>
    </div>

@endsection
